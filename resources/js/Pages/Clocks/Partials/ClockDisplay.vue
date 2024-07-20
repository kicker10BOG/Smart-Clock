<script setup>
import { ref, computed, onMounted } from 'vue'

const model = defineModel()

const dateElement = ref(null)
const timeElement = ref(null)
const alarmElement = ref(null)
const clockCenterX = computed(() => model.value.width / 2)
const clockCentery = computed(() => model.value.height / 2)

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

const updateTime = () => {
  currTime.value = new Date(Date.now())
  currMonth.value = currTime.value.getMonth()
  currWeekday.value = currTime.value.getDay()
  currMonthDay.value = currTime.value.getDate()
  currHour.value = currTime.value.getHours()
  currMinute.value = currTime.value.getMinutes()
  currSecond.value = currTime.value.getSeconds()
  currAMPM.value = currHour.value > 11 ? 'P' : 'A'

  currMonth.value = model.value.month_format == 'short' ? monthsShort[currMonth.value] : monthsLong[currMonth.value]
  currWeekday.value = model.value.weekday_format == 'short' ? weekdaysShort[currWeekday.value] : weekdaysLong[currWeekday.value]

  if (model.value.use_12hr) {
    currHour.value = currHour.value % 12
    currHour.value = currHour.value > 0 ? currHour.value : 12
  }

  currMinute.value = currMinute.value > 9 ? currMinute.value : '0' + currMinute.value
  currSecond.value = currSecond.value > 9 ? currSecond.value : '0' + currSecond.value
  currAMPM.value = model.value.shorten_ampm ? currAMPM.value : currAMPM.value + 'M'
}

updateTime()

setInterval(() => {
  updateTime()
}, 1000)
</script>

<template>
  <div ref="dateElement" class="absolute opacity-0 top-0 left-0 z-0"
    :style="`font-size: ${model.date_size}px; font-family: ${model.date_font};`">
    <span v-if="model.weekday_format !== 'hide'">{{ currWeekday }},</span> {{ currMonth }} {{ currMonthDay }}
  </div>
  <div ref="timeElement" class="absolute opacity-0 top-0 left-0 z-0"
    :style="`font-size: ${model.clock_size}px; font-family: ${model.clock_font};`">
    {{ currHour }}:{{ currMinute }}<span v-if="model.show_seconds">:{{ currSecond }}</span> <span
      v-if="model.show_ampm">{{
        currAMPM }}</span>
  </div>
  <div ref="alarmElement" class="absolute opacity-0 top-0 left-0 z-0"
    :style="`font-size: ${model.alarm_size}px; font-family: ${model.alarm_font};`">
    next alarm
  </div>
  <div class="relative m-auto" :style="`width: ${model.width}px; height:${model.height}px;`">
    <div v-if="model.show_date && dateElement" class="absolute"
      :style="`font-size: ${model.date_size}px; font-family: ${model.date_font}; left: ${model.date_x + clockCenterX - (dateElement.clientWidth / 2)}px; bottom: ${model.date_y + clockCentery - (dateElement.clientHeight / 2)}px;`">
      <span v-if="model.weekday_format !== 'hide'">{{ currWeekday }},</span> {{ currMonth }} {{ currMonthDay }}
    </div>
    <div v-if="timeElement" class="absolute"
      :style="`font-size: ${model.clock_size}px; font-family: ${model.clock_font}; left: ${model.clock_x + clockCenterX - (timeElement.clientWidth / 2)}px; bottom: ${model.clock_y + clockCentery - (timeElement.clientHeight / 2)}px;`">
      {{ currHour }}:{{ currMinute }}<span v-if="model.show_seconds">:{{ currSecond }}</span> <span
        v-if="model.show_ampm">{{
          currAMPM }}</span>
    </div>
    <div v-if="model.show_next_alarm && alarmElement" class="absolute"
      :style="`font-size: ${model.alarm_size}px; font-family: ${model.alarm_font}; left: ${model.alarm_x + clockCenterX - (alarmElement.clientWidth / 2)}px; bottom: ${model.alarm_y + clockCentery - (alarmElement.clientHeight / 2)}px;`">
      next alarm
    </div>
  </div>
</template>