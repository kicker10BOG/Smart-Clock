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
import ClockDisplay from './Partials/ClockDisplay.vue'

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
  width: 720,
  height: 480,
  date_x: 0,
  clock_x: 0,
  alarm_x: 0,
  date_y: 175,
  clock_y: 0,
  alarm_y: -155,
  date_size: 70,
  clock_size: 200,
  alarm_size: 70,
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
  <div class="w-full">
    <div class="container mx-auto">
      <div class="flex flex-col w-full">
        <h3>
          Create a New Clock
        </h3>
        <ClockForm v-model="form" type="new" class="z-10"/>
      </div>
    </div>
    <ClockDisplay v-model="form" />
  </div>
</template>