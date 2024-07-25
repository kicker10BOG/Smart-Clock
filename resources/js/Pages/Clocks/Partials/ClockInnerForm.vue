<script setup>
import { ref } from 'vue'
import BasicPanel from '@/Components/BasicPanel.vue'
import TextInput from '@/Components/TextInput.vue'
import SelectInput from '@/Components/SelectInput.vue'
import Checkbox from '@/Components/Checkbox.vue'

const model = defineModel()
defineEmits(['update:model-value'])
const fontOptions = ref(['sans-serif', 'serif', 'monospace', 'cursive', 'fantasy', 'system-ui', 'math'])
</script>

<template>
  <form @submit.prevent="submit">
    <div class="flex flex-col bg-gray-200 dark:bg-gray-800 rounded-lg p-2 m-2">
      <TextInput id="name" label="Name" v-model="model.name" type="text" class="w-full" required autofocus />
    </div>
    <BasicPanel :collapsible="true">
      <template #header>
        Clock Dimensions
      </template>
      <div class="flex flex-row flex-wrap">
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 rounded-lg p-2 m-1">
          <TextInput id="width" label="Width (px)" v-model="model.width" type="number" step="1" min="1"
            inputClass="w-24" />
        </div>
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 rounded-lg p-2 m-1">
          <TextInput id="height" label="Height (px)" v-model="model.height" type="number" step="1" min="1"
            inputClass="w-24" />
        </div>
      </div>
    </BasicPanel>
    <BasicPanel :collapsible="true">
      <template #header>
        Format Options
      </template>
      <div class="flex flex-row flex-wrap">
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 rounded-lg p-2 m-1">
          <SelectInput id="month_format" label="Month Format" v-model="model.month_format" class="w-fit">
            <option value="short">Short</option>
            <option value="long">Long</option>
          </SelectInput>
        </div>
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 rounded-lg p-2 m-1">
          <SelectInput id="weekday_format" label="Weekday Format" v-model="model.weekday_format" class="w-fit">
            <option value="hide">Hide</option>
            <option value="short">Short</option>
            <option value="long">Long</option>
          </SelectInput>
        </div>
      </div>
    </BasicPanel>
    <BasicPanel :collapsible="true">
      <template #header>
        Display Toggles
      </template>
      <div class="flex flex-row flex-wrap">
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
          <Checkbox id="show_date" label="Show Date" v-model="model.show_date" :value="true" />
        </div>
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
          <Checkbox id="show_next_alarm" label="Show Next Alarm" v-model="model.show_next_alarm" :value="true" />
        </div>
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
          <Checkbox id="show_seconds" label="Show Seconds" v-model="model.show_seconds" :value="true" />
        </div>
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
          <Checkbox id="use_12hr" label="Use 12 Hr Format" v-model="model.use_12hr" :value="true" />
        </div>
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
          <Checkbox id="show_ampm" label="Show AM/PM" v-model="model.show_ampm" :value="true" />
        </div>
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
          <Checkbox id="shorten_ampm" label="Shorten AM/PM to A/P" v-model="model.shorten_ampm" :value="true" />
        </div>
      </div>
    </BasicPanel>
    <BasicPanel :collapsible="true">
      <template #header>
        Positioning
      </template>
      <div class="flex flex-col w-full">
        <span>(0, 0) is in the center and you are positioning the center of each element</span>
        <div class="flex flex-row flex-wrap">
          <div class="flex flex-col bg-gray-200 dark:bg-gray-800 rounded-lg p-2 m-1">
            <TextInput id="date_x" label="Date X (px)" v-model="model.date_x" type="number" step="1"
              inputClass="w-24" />
          </div>
          <div class="flex flex-col bg-gray-200 dark:bg-gray-800 rounded-lg p-2 m-1">
            <TextInput id="date_y" label="Date Y (px)" v-model="model.date_y" type="number" step="1"
              inputClass="w-24" />
          </div>
          <div class="flex flex-col bg-gray-200 dark:bg-gray-800 rounded-lg p-2 m-1">
            <TextInput id="clock_x" label="Time X (px)" v-model="model.clock_x" type="number" step="1"
              inputClass="w-24" />
          </div>
          <div class="flex flex-col bg-gray-200 dark:bg-gray-800 rounded-lg p-2 m-1">
            <TextInput id="clock_y" label="Time Y (px)" v-model="model.clock_y" type="number" step="1"
              inputClass="w-24" />
          </div>
          <div class="flex flex-col bg-gray-200 dark:bg-gray-800 rounded-lg p-2 m-1">
            <TextInput id="alarm_x" label="Alarm X (px)" v-model="model.alarm_x" type="number" step="1"
              inputClass="w-24" />
          </div>
          <div class="flex flex-col bg-gray-200 dark:bg-gray-800 rounded-lg p-2 m-1">
            <TextInput id="alarm_y" label="Alarm Y (px)" v-model="model.alarm_y" type="number" step="1"
              inputClass="w-24" />
          </div>
        </div>
      </div>
    </BasicPanel>
    <BasicPanel :collapsible="true">
      <template #header>
        Fonts
      </template>
      <div class="flex flex-row flex-wrap">
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
          <SelectInput id="date_font" label="Date Font" v-model="model.date_font" class="mt-1 block  w-fit">
            <template v-for="(opt, i) in fontOptions" :key="i">
              <option :value="opt">{{ opt }}</option>
            </template>
          </SelectInput>
        </div>
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
          <SelectInput id="clock_font" label="Time Font" v-model="model.clock_font" class="mt-1 block  w-fit">
            <template v-for="(opt, i) in fontOptions" :key="i">
              <option :value="opt">{{ opt }}</option>
            </template>
          </SelectInput>
        </div>
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
          <SelectInput id="alarm_font" label="Alarm Font" v-model="model.alarm_font" class="mt-1 block  w-fit">
            <template v-for="(opt, i) in fontOptions" :key="i">
              <option :value="opt">{{ opt }}</option>
            </template>
          </SelectInput>
        </div>
      </div>
    </BasicPanel>
    <BasicPanel :collapsible="true">
      <template #header>
        Font Sizes
      </template>
      <div class="flex flex-row flex-wrap">
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
          <TextInput id="date_size" label="Date Font Size (px)" v-model="model.date_size" type="number" step="1" min="1"
            inputClass="w-24" />
        </div>
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
          <TextInput id="clock_size" label="Time Font Size (px)" v-model="model.clock_size" type="number" step="1"
            min="1" inputClass="w-24" />
        </div>
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
          <TextInput id="alarm_size" label="Alarm Font Size (px)" v-model="model.alarm_size" type="number" step="1"
            min="1" inputClass="w-24" />
        </div>
      </div>
    </BasicPanel>
  </form>
</template>