<script setup>
import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import Manage from './Partials/Manage.vue';

const props = defineProps({
  clock: {
    required: true,
    type: Object,
  }
})

const page = usePage()
const user = computed(() => page.props.auth.user)

const clockProxy = ref(props.clock)

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

  currMonth.value = clockProxy.value.month_format == 'short' ? monthsShort[currMonth.value] : monthsLong[currMonth.value]
  currWeekday.value = clockProxy.value.weekday_format == 'short' ? weekdaysShort[currWeekday.value] : weekdaysLong[currWeekday.value]

  if (clockProxy.value.use_12hr) {
    currHour.value = currHour.value % 12
    currHour.value = currHour.value > 0 ? currHour.value : 12
  }

  currMinute.value = currMinute.value > 9 ? currMinute.value : '0' + currMinute.value
  currSecond.value = currSecond.value > 9 ? currSecond.value : '0' + currSecond.value
  currAMPM.value = clockProxy.value.shorten_ampm ? currAMPM.value : currAMPM.value + 'M'
}

updateTime()

setInterval(() => {
  updateTime()
}, 1000)
</script>

<template>
  <div class="flex flex-col w-full justify-around">
    <div v-if="clock.date_format != 'off'"
      :style="`font-size: ${clock.date_size}px; font-family: ${clock.date_font}; margin: ${clock.date_margin}px auto; order: ${clock.date_order};`">
      <span v-if="clock.weekday_format !== 'hide'">{{ currWeekday }},</span> {{ currMonth }} {{ currMonthDay }}
    </div>
    <div
      :style="`font-size: ${clock.clock_size}px; font-family: ${clock.clock_font}; margin: ${clock.clock_margin}px auto; order: ${clock.clock_order};`">
      {{ currHour }}:{{ currMinute }}<span v-if="clock.show_seconds">:{{ currSecond }}</span> <span
        v-if="clock.show_ampm">{{
          currAMPM }}</span>
    </div>
    <div v-if="clock.show_next_alarm"
      :style="`font-size: ${clock.alarm_size}px; font-family: ${clock.alarm_font}; margin: ${clock.alarm_margin}px auto; order: ${clock.alarm_order};`">
      next alarm
    </div>
  </div>
  <div v-if="user && clockProxy.user_id == user.id" class="relative">
    <Manage v-model="clockProxy" />
  </div>
</template>