<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue'
import { Head, usePage } from '@inertiajs/vue3'
import ClockDisplay from './Partials/ClockDisplay.vue';
import ClockManage from './Partials/ClockManage.vue';
import { flash } from '@/Stores/flashMessages';

const props = defineProps({
  clock: {
    required: true,
    type: Object,
  }
})

const page = usePage()
const user = computed(() => page.props.auth.user)
const clock = computed(() => page.props.clock)
const clockElement = ref(null)
const colorStyle = ref('')

let timeout = null
const wakeTime = 3000
function hideMouseCursor() {
  if (document.body.style.cursor !== 'none') {
    document.body.style.cursor = 'none';
  }
}
function showMouseCursor() {
  clearTimeout(timeout);
  if (document.body.style.cursor !== 'default') {
    document.body.style.cursor = 'default';
  }
}
document.onmousemove = function () {
  showMouseCursor();
  timeout = setTimeout(hideMouseCursor, wakeTime);
};
document.onmousedown = function () {
  showMouseCursor();
  timeout = setTimeout(hideMouseCursor, wakeTime);
};

function setColor() {
  // get current color values
  const now = new Date()
  let cC = null
  let colorDiff = null
  page.props.clock.colors.forEach(color => {
    let d = new Date(now)
    if (color.enabled) {
      d.setHours(color.hour, color.minute, 0)
      let diff = d - now
      if (diff > 0) {
        d.setDate(d.getDate() - 1)
        diff = d - now
      }
      if (colorDiff == null || diff > colorDiff) {
        colorDiff = diff
        cC = color
      }
    }
  })
  if (cC) {
    colorStyle.value = cC.background != 'default' ? `background: ${cC.background}; ` : ''
    colorStyle.value += cC.text != 'default' ? `color: ${cC.text};` : ''
  }
  else {
    colorStyle.value = ''
  }
}

let colorInterval = null

onMounted(() => {
  setColor()
  colorInterval = setInterval(setColor, 2000);
  window.Echo.channel(`clock.${clock.value.id}`)
    .listen('ClockUpdated', (e) => {
      flash("Clock Updated").add()
      page.props.clock = e.clock
    })
    .listen('AlarmUpdated', (e) => {
      flash("Alarm Updated").add()
      for (let i = 0; i < page.props.clock.alarms.length; i++) {
        if (page.props.clock.alarms[i].id == e.alarm.id) {
          page.props.clock.alarms[i] = e.alarm
          break
        }
      }
    })
    .listen('AlarmCreated', (e) => {
      flash("Alarm Created").add()
      page.props.clock.alarms.push(e.alarm)
    })
    .listen('AlarmDeleted', (e) => {
      flash("Alarm Deleted").add()
      for (let i = 0; i < page.props.clock.alarms.length; i++) {
        if (page.props.clock.alarms[i].id == e.alarm_id) {
          page.props.clock.alarms.splice(i, 1)
          break
        }
      }
    })
    .listen('AlarmSnoozed', (e) => {
      flash("Alarm Snoozed").add()
      if (clockElement.value) {
        clockElement.value.snoozeAlarm(false, e)
      }
    })
    .listen('AlarmDismissed', (e) => {
      flash("Alarm Dismissed").add()
      if (clockElement.value) {
        clockElement.value.dismissAlarm(false)
      }
    })
    .listen('ColorEvent', (e) => {
      flash(e.message).add()
      if (e.type == 'create') {
        page.props.clock.colors.push(e.color)
      }
      else if (['update', 'enable', 'disable'].includes(e.type)) {
        for (let i = 0; i < page.props.clock.colors.length; i++) {
          if (page.props.clock.colors[i].id == e.color.id) {
            page.props.clock.colors[i] = e.color
            break
          }
        }
      }
      else if (e.type == 'delete') {
        for (let i = 0; i < page.props.clock.colors.length; i++) {
          if (page.props.clock.colors[i].id == e.color_id) {
            page.props.clock.colors.splice(i, 1)
            break
          }
        }
      }
    })
})

onUnmounted(() => {
  window.Echo.leave(`clock.${clock.value.id}`)
  clearInterval(colorInterval)
})
</script>

<template>
  <div class="flex flex-grow flex-col w-full justify-around">

    <Head :title="clock.name" />
    <ClockDisplay ref="clockElement" v-model="clock" :style="colorStyle" />
    <div v-if="$page.props.auth.user && clock.user_id == user.id" class="relative">
      <ClockManage v-model="clock" />
    </div>
  </div>
</template>