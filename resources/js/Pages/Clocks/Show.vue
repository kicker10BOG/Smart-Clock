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

onMounted(() => {
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
})

onUnmounted(() => {
  window.Echo.leave(`clock.${clock.value.id}`)
})
</script>

<template>
  <div class="flex flex-grow flex-col w-full justify-around">
    <Head :title="clock.name" />
    <ClockDisplay ref="clockElement" v-model="clock" />
    <div v-if="user && clock.user_id == user.id" class="relative">
      <ClockManage v-model="clock"/>
    </div>
  </div>
</template>