<script setup>
import axios from "axios";
import { ref, computed, onUnmounted, onMounted } from 'vue'
import BasicModal from '@/Components/BasicModal.vue'
import BasicButton from '@/Components/BasicButton.vue';
import { usePage } from '@inertiajs/vue3';
import { flash } from "@/Stores/flashMessages";

const model = defineModel()
const page = usePage()
const clock = computed(() => page.props.clock)
defineEmits(['update:model-value'])

const dateStr = ref('')
const timeStr = ref('')
const nextAlarm = ref(null)
const dateElement = ref(null)
const timeElement = ref(null)
const alarmElement = ref(null)
const audioElement = ref(null)
const clockCenterX = computed(() => model.value.width / 2)
const clockCentery = computed(() => model.value.height / 2)

const alarmTriggered = ref(false)
const triggeredAlarm = ref(null)
const alarmSnoozed = ref(false)
const snoozedAlarm = ref(null)
const snoozedStr = ref('')

const weekdaysShort = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
const weekdaysLong = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']

const monthsShort = [
  'Jan', 'Feb', 'Mar', 'Apr',
  'May', 'Jun', 'Jul', 'Aug',
  'Sep', 'Oct', 'Nov', 'Dec'
]
const monthsLong = [
  'January', 'February', 'March', 'April',
  'May', 'June', 'July', 'August',
  'September', 'October', 'November', 'December'
]

const currTime = ref(new Date(Date.now()))
const currMonth = ref(monthsShort[currTime.value.getMonth()])
const currWeekday = ref(weekdaysShort[currTime.value.getDay()])
const currMonthDay = ref(currTime.value.getDate())
const currHour = ref(currTime.value.getHours())
const currMinute = ref(currTime.value.getMinutes())
const currSecond = ref(currTime.value.getSeconds())
const currAMPM = ref(currHour.value > 11 ? 'P' : 'A')

function updateTime() {
  currTime.value = new Date(Date.now())
  currMonth.value = currTime.value.getMonth()
  currWeekday.value = currTime.value.getDay()
  currMonthDay.value = currTime.value.getDate()
  currHour.value = currTime.value.getHours()
  currMinute.value = currTime.value.getMinutes()
  currSecond.value = currTime.value.getSeconds()
  currAMPM.value = currHour.value > 11 ? 'P' : 'A'

  currMonth.value = model.value.month_format == 'short' ? monthsShort[currMonth.value] : monthsLong[currMonth.value]
  currWeekday.value = model.value.weekday_format == 'hide' ? '' : ((model.value.weekday_format == 'short' ? weekdaysShort[currWeekday.value] : weekdaysLong[currWeekday.value]) + ',')

  if (model.value.use_12hr) {
    currHour.value = currHour.value % 12
    currHour.value = currHour.value > 0 ? currHour.value : 12
  }

  currMinute.value = currMinute.value > 9 ? currMinute.value : '0' + currMinute.value
  currSecond.value = !model.value.show_seconds ? '' : (':' + (currSecond.value > 9 ? currSecond.value : '0' + currSecond.value))
  currAMPM.value = !model.value.show_ampm ? '' : model.value.shorten_ampm ? currAMPM.value : currAMPM.value + 'M'

  dateStr.value = `${currWeekday.value} ${currMonth.value} ${currMonthDay.value}`
  timeStr.value = `${currHour.value}:${currMinute.value}${currSecond.value} ${currAMPM.value}`

  if (currTime.value.getSeconds() == 0) {
    if (alarmSnoozed.value) {
      let d = new Date(currTime.value)
      d.setHours(snoozedAlarm.value.hour, snoozedAlarm.value.minute, 0)
      d.setTime(d.getTime() + snoozedAlarm.value.snooze_length * snoozedAlarm.value.snooze_count * 60000)
      if (currTime.value.getHours() == d.getHours() && currTime.value.getMinutes() == d.getMinutes()) {
        triggeredAlarm.value = { ...snoozedAlarm.value.alarm }
        alarmTriggered.value = true
        audioElement.value.load()
        audioElement.value.play()
      }
    }
    if (nextAlarm.value) {
      if (currTime.value.getDay() == nextAlarm.value.day && currTime.value.getHours() == nextAlarm.value.alarm.hour && currTime.value.getMinutes() == nextAlarm.value.alarm.minute) {
        triggeredAlarm.value = nextAlarm.value.alarm
        alarmTriggered.value = true
        audioElement.value.load()
        audioElement.value.play()
      }
    }
  }
}

function getNextOccurenceDiff(now, alarm) {
  const days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']
  let dateDiff = null
  let dateDiffDay = null
  if (alarmSnoozed.value) {
    let d = new Date(now)
    for (let i = 0; i < model.value.alarms.length; i++) {
      if (model.value.alarms[i].id == snoozedAlarm.value.id) {
        snoozedAlarm.value.hour = model.value.alarms[i].hour
        snoozedAlarm.value.minute = model.value.alarms[i].minute
        snoozedAlarm.value.snooze_length = model.value.alarms[i].snooze_length
      }
    }
    d.setHours(snoozedAlarm.value.hour, snoozedAlarm.value.minute, 0)
    d.setTime(d.getTime() + snoozedAlarm.value.snooze_length * snoozedAlarm.value.snooze_count * 60000)
    dateDiff = d - now
    dateDiffDay = d.getDay()
    let hr = d.getHours()
    let m = d.getMinutes()
    snoozedStr.value = `${model.value.use_12hr ? (hr == 0 ? 12 : hr % 12) : hr}:${m < 10 ? 0 : ''}${m}`
  }
  for (let i = 0; i < 7; i++) {
    if (alarm[days[i]]) {
      let d = new Date(now)
      d.setHours(alarm.hour, alarm.minute, 0)
      if (i != now.getDay()) {
        d.setDate(now.getDate() + (7 + i - d.getDay()) % 7)
      }
      let diff = d - now
      if (diff < 0) {
        d.setDate(d.getDate() + 7)
        diff = d - now
      }
      if (dateDiff == null || diff < dateDiff) {
        dateDiff = diff
        dateDiffDay = i
      }
    }
  }
  return {
    diff: dateDiff,
    day: dateDiffDay,
    alarm: alarm,
    displayStr: `${weekdaysShort[dateDiffDay]}, ${model.value.use_12hr ? (alarm.hour == 0 ? 12 : alarm.hour % 12) : alarm.hour}:${alarm.minute < 10 ? `0${alarm.minute}` : alarm.minute} ${model.value.use_12hr ? (model.value.shorten_ampm ? (alarm.hour > 11 ? 'P' : 'A') : (alarm.hour > 11 ? 'PM' : 'AM')) : ''}`
  }
}

function getNextAlarm() {
  if (model.value.alarms == undefined) {
    return
  }
  const now = new Date()
  let nA = null
  model.value.alarms.forEach(alarm => {
    if (alarm.enabled) {
      let nO = getNextOccurenceDiff(now, alarm)
      if (nA == null || nO.diff < nA.diff) {
        nA = { ...nO }
      }
    }
  });
  nextAlarm.value = nA
}

function dismissAlarm(broadcast = true) {
  alarmTriggered.value = false
  if (broadcast) {
    let alarm = triggeredAlarm.value && triggeredAlarm.value.id ? triggeredAlarm.value : snoozedAlarm.value
    axios.post(route('alarms.dismiss', { 'alarm': alarm }))
  }
  triggeredAlarm.value = null
  if (alarmSnoozed.value) {
    alarmSnoozed.value = false
    snoozedAlarm.value.snooze_count = 0
    snoozedAlarm.value = null
  }
}

function snoozeAlarm() {
  if (!alarmSnoozed.value) {
    alarmSnoozed.value = true
    snoozedAlarm.value = { ...triggeredAlarm.value }
  }
  alarmTriggered.value = false
  triggeredAlarm.value = null
  snoozedAlarm.value.snooze_count++
  axios.post(route('alarms.snooze', { 'alarm': snoozedAlarm.value, 'count': snoozedAlarm.value.snooze_count }))
}

updateTime()
getNextAlarm()

setInterval(updateTime, 1000)
setInterval(getNextAlarm, 2000)

onMounted(() => {
  window.Echo.channel(`clock.${clock.value.id}`)
    .listen('ClockUpdated', (e) => {
      flash("Clock Updated").add()
      page.props.clock = e.clock
    })
    .listen('AlarmUpdated', (e) => {
      for (let i = 0; i < page.props.clock.alarms.length; i++) {
        if (page.props.clock.alarms[i].id == e.alarm.id) {
          page.props.clock.alarms[i] = e.alarm
          break
        }
      }
    })
    .listen('AlarmCreated', (e) => {
      page.props.clock.alarms.push(e.alarm)
    })
    .listen('AlarmDeleted', (e) => {
      for (let i = 0; i < page.props.clock.alarms.length; i++) {
        if (page.props.clock.alarms[i].id == e.alarm_id) {
          page.props.clock.alarms.splice(i, 1)
          break
        }
      }
    })
    .listen('AlarmSnoozed', (e) => {
      flash("Alarm Snoozed").add()
      alarmSnoozed.value = true
      snoozedAlarm.value = { ...e.alarm }
      snoozedAlarm.value.snooze_count = e.count
      alarmTriggered.value = false
      triggeredAlarm.value = null
    })
    .listen('AlarmDismissed', (e) => {
      flash("Alarm Dismissed").add()
      dismissAlarm(false)
    })
})

onUnmounted(() => {
  window.Echo.leave(`clock.${clock.value.id}`)
})
</script>

<template>
  <div class="flex flex-col flex-grow w-full">
    <div ref="dateElement" class="absolute whitespace-nowrap opacity-0 top-0 left-0 z-0"
      :style="`font-size: ${model.date_size}px; font-family: ${model.date_font};`">
      {{ dateStr }}
    </div>
    <div ref="timeElement" class="absolute whitespace-nowrap opacity-0 top-0 left-0 z-0"
      :style="`font-size: ${model.time_size}px; font-family: ${model.clock_font};`">
      {{ timeStr }}
    </div>
    <div ref="alarmElement" class="absolute whitespace-nowrap opacity-0 top-0 left-0 z-0"
      :style="`font-size: ${model.alarm_size}px; font-family: ${model.alarm_font};`">
      <div v-if="alarmSnoozed">
        Snoozed: {{ snoozedStr }}
        <BasicButton @click="dismissAlarm" type="danger" size="xl">Dismiss</BasicButton>
      </div>
      <div v-else>
        Next Alarm:
        <span v-if="nextAlarm">
          {{ nextAlarm.displayStr }}
        </span>
        <span v-else>None Enabled</span>
      </div>
    </div>
    <div class="relative m-auto overflow-hidden" :style="`width: ${model.width}px; height:${model.height}px;`">
      <div v-if="model.show_date && dateElement" class="absolute whitespace-nowrap"
        :style="`font-size: ${model.date_size}px; font-family: ${model.date_font}; left: ${model.date_x + clockCenterX - (dateElement.clientWidth / 2)}px; bottom: ${model.date_y + clockCentery - (dateElement.clientHeight / 2)}px;`">
        {{ dateStr }}
      </div>
      <div v-if="timeElement" class="absolute whitespace-nowrap"
        :style="`font-size: ${model.time_size}px; font-family: ${model.clock_font}; left: ${model.clock_x + clockCenterX - (timeElement.clientWidth / 2)}px; bottom: ${model.clock_y + clockCentery - (timeElement.clientHeight / 2)}px;`">
        {{ timeStr }}
      </div>
      <div v-if="model.show_next_alarm && alarmElement" class="absolute whitespace-nowrap"
        :style="`font-size: ${model.alarm_size}px; font-family: ${model.alarm_font}; left: ${model.alarm_x + clockCenterX - (alarmElement.clientWidth / 2)}px; bottom: ${model.alarm_y + clockCentery - (alarmElement.clientHeight / 2)}px;`">
        <div v-if="alarmSnoozed">
          Snoozed: {{ snoozedStr }}
          <BasicButton @click="dismissAlarm" type="danger" size="xl">Dismiss</BasicButton>
        </div>
        <div v-else>
          Next Alarm:
          <span v-if="nextAlarm">
            {{ nextAlarm.displayStr }}
          </span>
          <span v-else>None Enabled</span>
        </div>
      </div>
    </div>
    <audio ref="audioElement" class="hidden" controls loop>
      <source src="/audio/alarm-clock-90867.mp3">
    </audio>
    <BasicModal v-model="alarmTriggered" :showCloseX="false" :closeOnClickAway="false" @close="audioElement.pause()">
      <template #header>
        <div class="m-auto flex-grow">
          Alarm Triggered!
        </div>
      </template>
      <div class="flex flex-col w-full">
        <div class="m-auto">
          {{ triggeredAlarm.name }}
        </div>
        <div class="flex flex-row w-full min-w-fit justify-around">
          <BasicButton @click="snoozeAlarm" type="warning" size="xl">Snooze</BasicButton>
          <BasicButton @click="dismissAlarm" type="danger" size="xl">Dismiss</BasicButton>
        </div>
      </div>
    </BasicModal>
  </div>
</template>