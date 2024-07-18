<script setup>
import { ref } from 'vue'
import { Link, useForm, usePage } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import SelectInput from '@/Components/SelectInput.vue'
import Checkbox from '@/Components/Checkbox.vue'
import BasicPanel from '@/Components/BasicPanel.vue'
import { VueDraggable } from 'vue-draggable-plus'
import BasicButton from '@/Components/BasicButton.vue'

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

const setOrder = () => {
  for (let i = 0; i < orderArr.value.length; i++) {
    if (orderArr.value[i].id == 'date') {
      form.date_order = i + 1
      continue
    }
    if (orderArr.value[i].id == 'clock') {
      form.clock_order = i + 1
      continue
    }
    if (orderArr.value[i].id == 'alarm') {
      form.alarm_order = i + 1
      continue
    }
  }
}

const submit = () => {
  form.post(route('clocks.store'));
}

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
      Create a New Clock
    </h3>
    <form @submit.prevent="submit">
      <div class="flex flex-col bg-gray-200 dark:bg-gray-800 rounded-lg p-2 m-">
        <TextInput id="name" label="Name" v-model="form.name" type="text" class="w-full" required autofocus />
        <InputError class="mt-2" :message="form.errors.name" />
      </div>
      <BasicPanel :collapsible="true">
        <template #header>
          Format Options
        </template>
        <div class="flex flex-row flex-wrap">
          <div class="flex flex-col bg-gray-200 dark:bg-gray-800 rounded-lg p-2 m-1">
            <!-- <InputLabel for="month_format" value="Month Format" /> -->
            <SelectInput id="month_format" label="Month Format" v-model="form.month_format" class="w-fit">
              <option value="short">Short</option>
              <option value="long">Long</option>
            </SelectInput>
            <InputError class="mt-2" :message="form.errors.date_format" />
          </div>
          <div class="flex flex-col bg-gray-200 dark:bg-gray-800 rounded-lg p-2 m-1">
            <!-- <InputLabel for="weekday_format" value="Weekday Format" /> -->
            <SelectInput id="weekday_format" label="Weekday Format" v-model="form.weekday_format" class="w-fit"
             >
              <option value="hide">Hide</option>
              <option value="short">Short</option>
              <option value="long">Long</option>
            </SelectInput>
            <InputError class="mt-2" :message="form.errors.date_format" />
          </div>
        </div>
      </BasicPanel>
      <BasicPanel :collapsible="true">
        <template #header>
          Display Toggles
        </template>
        <div class="flex flex-row flex-wrap">
          <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
            <Checkbox id="show_next_alarm" label="Show Next Alarm" v-model="form.show_next_alarm" />
            <InputError class="mt-2" :message="form.errors.show_next_alarm" />
          </div>
          <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
            <Checkbox id="show_seconds" label="Show Seconds" v-model="form.show_seconds" />
            <InputError class="mt-2" :message="form.errors.show_seconds" />
          </div>
          <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
            <Checkbox id="use_12hr" label="Use 12 Hr Format" v-model="form.use_12hr" />
            <InputError class="mt-2" :message="form.errors.use_12hr" />
          </div>
          <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
            <Checkbox id="show_ampm" label="Show AM/PM" v-model="form.show_ampm" />
            <InputError class="mt-2" :message="form.errors.show_ampm" />
          </div>
          <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
            <Checkbox id="shorten_ampm" label="Shorten AM/PM to A/P" v-model="form.shorten_ampm" />
            <InputError class="mt-2" :message="form.errors.shorten_ampm" />
          </div>
        </div>
      </BasicPanel>
      <BasicPanel :collapsible="true">
        <template #header>
          Fonts
        </template>
        <div class="flex flex-row flex-wrap">
          <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
            <SelectInput id="date_font" label="Date Font" v-model="form.date_font" class="mt-1 block  w-fit">
              <template v-for="(opt, i) in fontOptions" :key="i">
                <option :value="opt">{{ opt }}</option>
              </template>
            </SelectInput>
            <InputError class="mt-2" :message="form.errors.date_font" />
          </div>
          <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
            <SelectInput id="clock_font" label="Clock Font" v-model="form.clock_font" class="mt-1 block  w-fit">
              <template v-for="(opt, i) in fontOptions" :key="i">
                <option :value="opt">{{ opt }}</option>
              </template>
            </SelectInput>
            <InputError class="mt-2" :message="form.errors.clock_font" />
          </div>
          <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
            <SelectInput id="alarm_font" label="Alarm Font" v-model="form.alarm_font" class="mt-1 block  w-fit" disabled>
              <template v-for="(opt, i) in fontOptions" :key="i">
                <option :value="opt">{{ opt }}</option>
              </template>
            </SelectInput>
            <InputError class="mt-2" :message="form.errors.alarm_font" />
          </div>
        </div>
      </BasicPanel>
      <BasicPanel :collapsible="true">
        <template #header>
          Font Sizes
        </template>
        <div class="flex flex-row flex-wrap">
          <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
            <TextInput id="date_size" label="Date Font Size (px)" v-model="form.date_size" type="number" step="1"
              min="1" inputWidthClass="w-24" disabled />
            <InputError class="mt-2" :message="form.errors.date_size" />
          </div>
          <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
            <TextInput id="clock_size" label="Clock Font Size (px)" v-model="form.clock_size" type="number" step="1"
              min="1" inputWidthClass="w-24" />
            <InputError class="mt-2" :message="form.errors.clock_size" />
          </div>
          <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
            <TextInput id="alarm_size" label="Alarm Font Size (px)" v-model="form.alarm_size" type="number" step="1"
              min="1" inputWidthClass="w-24" />
            <InputError class="mt-2" :message="form.errors.alarm_size" />
          </div>
        </div>
      </BasicPanel>
      <BasicPanel :collapsible="true">
        <template #header>
          Vertical Spacing
        </template>
        <div class="flex flex-row flex-wrap">
          <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
            <TextInput id="date_margin" label="Date Margin (px)" v-model="form.date_margin" type="number" step="1" min="-1000"
              inputWidthClass="w-24" />
            <InputError class="mt-2" :message="form.errors.date_margin" />
          </div>
          <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
            <TextInput id="clock_margin" label="Clock Margin (px)" v-model="form.clock_margin" type="number" step="1" min="-1000"
            inputWidthClass="w-24" />
            <InputError class="mt-2" :message="form.errors.clock_margin" />
          </div>
          <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
            <TextInput id="alarm_margin" label="Alarm Margin (px)" v-model="form.alarm_margin" type="number" step="1" min="-1000"
              inputWidthClass="w-24" />
            <InputError class="mt-2" :message="form.errors.alarm_margin" />
          </div>
        </div>
      </BasicPanel>
      <BasicPanel :collapsible="true">
        <template #header>
          Display Order
        </template>
        <div class="flex flex-row flex-wrap">
          <div class="w-fit">
            <VueDraggable v-model="orderArr" item-key="id" @end="setOrder">
              <div v-for="(el, i) in orderArr" :key="el.id" slot="item"
                class="w-fit m-1 py-2 px-3 bg-gray-200 dark:bg-gray-800 rounded-lg cursor-pointer">
                {{ el.name }}
              </div>
            </VueDraggable>
          </div>
        </div>
      </BasicPanel>


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
      <div class="flex flex-row justify-end">
        <BasicButton>Submit</BasicButton>
      </div>
    </form>
  </div>
</template>