<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import TextInput from '@/Components/TextInput.vue'
import SelectInput from '@/Components/SelectInput.vue'
import Checkbox from '@/Components/Checkbox.vue'
import BasicPanel from '@/Components/BasicPanel.vue'
import { VueDraggable } from 'vue-draggable-plus'
import BasicButton from '@/Components/BasicButton.vue'
import ClockForm from './Partials/ClockForm.vue'

const orderArr = ref([
  {
    id: 'date',
    name: 'Date',
  },
  {
    id: 'clock',
    name: 'Clock',
  },
  {
    id: 'alarm',
    name: 'Alarm',
  },
])

const fontOptions = ref(['sans-serif', 'serif', 'monospace', 'cursive', 'fantasy', 'system-ui', 'math'])

const form = useForm({
  name: '',
  month_format: 'short',
  weekday_format: 'short',
  show_date: true,
  show_next_alarm: true,
  show_seconds: false,
  use_12hr: true,
  show_ampm: true,
  shorten_ampm: true,
  date_order: 1,
  clock_order: 2,
  alarm_order: 3,
  date_size: 108,
  clock_size: 310,
  alarm_size: 108,
  date_margin: 0,
  clock_margin: -120,
  alarm_margin: 0,
  date_font: 'sans-serif',
  clock_font: 'math',
  alarm_font: 'sans-serif',
})

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

  currMonth.value = form.month_format == 'short' ? monthsShort[currMonth.value] : monthsLong[currMonth.value]
  currWeekday.value = form.weekday_format == 'short' ? weekdaysShort[currWeekday.value] : weekdaysLong[currWeekday.value]

  if (form.use_12hr) {
    currHour.value = currHour.value % 12
    currHour.value = currHour.value > 0 ? currHour.value : 12
  }

  currMinute.value = currMinute.value > 9 ? currMinute.value : '0' + currMinute.value
  currSecond.value = currSecond.value > 9 ? currSecond.value : '0' + currSecond.value
  currAMPM.value = form.shorten_ampm ? currAMPM.value : currAMPM.value + 'M'
}

setInterval(() => {
  updateTime()
}, 1000)
</script>

<template>
  <div class="flex flex-col w-full">
    <h3>
      Create a Ne Clock
    </h3>
    <ClockForm v-model="form" type="new" />

    <div class="flex flex-col w-full justify-around">
      <div v-if="form.date_format != 'off'"
        :style="`font-size: ${form.date_size}px; font-family: ${form.date_font}; margin: ${form.date_margin}px auto; order: ${form.date_order};`">
        <span v-if="form.weekday_format !== 'hide'">{{ currWeekday }},</span> {{ currMonth }} {{ currMonthDay }}
      </div>
      <div
        :style="`font-size: ${form.clock_size}px; font-family: ${form.clock_font}; margin: ${form.clock_margin}px auto; order: ${form.clock_order};`">
        {{ currHour }}:{{ currMinute }}<span v-if="form.show_seconds">:{{ currSecond }}</span> <span
          v-if="form.show_ampm">{{
            currAMPM }}</span>
      </div>
      <div v-if="form.show_next_alarm"
        :style="`font-size: ${form.alarm_size}px; font-family: ${form.alarm_font}; margin: ${form.alarm_margin}px auto; order: ${form.alarm_order};`">
        next alarm
      </div>
    </div>
  </div>
</template>