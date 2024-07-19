<script setup>
import { ref, computed } from 'vue'
import BasicButton from '@/Components/BasicButton.vue'
import BasicPanel from '@/Components/BasicPanel.vue'
import InputError from '@/Components/InputError.vue'
import TextInput from '@/Components/TextInput.vue'
import SelectInput from '@/Components/SelectInput.vue'
import Checkbox from '@/Components/Checkbox.vue'
import { VueDraggable } from 'vue-draggable-plus'

const model = defineModel()

const fontOptions = ref(['sans-serif', 'serif', 'monospace', 'cursive', 'fantasy', 'system-ui', 'math'])
const orderArr = ref(new Array())

for (let i = 0; i < 3; i++) {
  if (model.value.date_order == i + 1) {
    orderArr.value[i] = {
      id: 'date',
      name: 'Date',
    }
    continue
  }
  if (model.value.clock_order == i + 1) {
    orderArr.value[i] = {
      id: 'clock',
      name: 'Clock',
    }
    continue
  }
  if (model.value.alarm_order == i + 1) {
    orderArr.value[i] = {
      id: 'alarm',
      name: 'Alarm',
    }
    continue
  }
}

const setOrder = () => {
  for (let i = 0; i < orderArr.value.length; i++) {
    if (orderArr.value[i].id == 'date') {
      model.value.date_order = i + 1
      continue
    }
    if (orderArr.value[i].id == 'clock') {
      model.value.clock_order = i + 1
      continue
    }
    if (orderArr.value[i].id == 'alarm') {
      model.value.alarm_order = i + 1
      continue
    }
  }
}
</script>

<template>
  <form @submit.prevent="submit">
    <div class="flex flex-col bg-gray-200 dark:bg-gray-800 rounded-lg p-2 m-2">
      <TextInput id="name" label="Name" v-model="model.name" type="text" class="w-full" required autofocus />
      <!-- <InputError class="mt-2" :message="form.errors.name" /> -->
    </div>
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
          <!-- <InputError class="mt-2" :message="form.errors.date_format" /> -->
        </div>
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 rounded-lg p-2 m-1">
          <SelectInput id="weekday_format" label="Weekday Format" v-model="model.weekday_format" class="w-fit">
            <option value="hide">Hide</option>
            <option value="short">Short</option>
            <option value="long">Long</option>
          </SelectInput>
          <!-- <InputError class="mt-2" :message="form.errors.date_format" /> -->
        </div>
      </div>
    </BasicPanel>
    <BasicPanel :collapsible="true">
      <template #header>
        Display Toggles
      </template>
      <div class="flex flex-row flex-wrap">
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
          <Checkbox id="show_date" label="Show Date" v-model="model.show_date" />
          <!-- <InputError class="mt-2" :message="form.errors.show_date" /> -->
        </div>
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
          <Checkbox id="show_next_alarm" label="Show Next Alarm" v-model="model.show_next_alarm" />
          <!-- <InputError class="mt-2" :message="form.errors.show_next_alarm" /> -->
        </div>
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
          <Checkbox id="show_seconds" label="Show Seconds" v-model="model.show_seconds" />
          <!-- <InputError class="mt-2" :message="form.errors.show_seconds" /> -->
        </div>
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
          <Checkbox id="use_12hr" label="Use 12 Hr Format" v-model="model.use_12hr" />
          <!-- <InputError class="mt-2" :message="form.errors.use_12hr" /> -->
        </div>
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
          <Checkbox id="show_ampm" label="Show AM/PM" v-model="model.show_ampm" />
          <!-- <InputError class="mt-2" :message="form.errors.show_ampm" /> -->
        </div>
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
          <Checkbox id="shorten_ampm" label="Shorten AM/PM to A/P" v-model="model.shorten_ampm" />
          <!-- <InputError class="mt-2" :message="form.errors.shorten_ampm" /> -->
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
          <!-- <InputError class="mt-2" :message="form.errors.date_font" /> -->
        </div>
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
          <SelectInput id="clock_font" label="Clock Font" v-model="model.clock_font" class="mt-1 block  w-fit">
            <template v-for="(opt, i) in fontOptions" :key="i">
              <option :value="opt">{{ opt }}</option>
            </template>
          </SelectInput>
          <!-- <InputError class="mt-2" :message="form.errors.clock_font" /> -->
        </div>
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
          <SelectInput id="alarm_font" label="Alarm Font" v-model="model.alarm_font" class="mt-1 block  w-fit">
            <template v-for="(opt, i) in fontOptions" :key="i">
              <option :value="opt">{{ opt }}</option>
            </template>
          </SelectInput>
          <!-- <InputError class="mt-2" :message="form.errors.alarm_font" /> -->
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
            inputWidthClass="w-24" />
          <!-- <InputError class="mt-2" :message="form.errors.date_size" /> -->
        </div>
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
          <TextInput id="clock_size" label="Clock Font Size (px)" v-model="model.clock_size" type="number" step="1"
            min="1" inputWidthClass="w-24" />
          <!-- <InputError class="mt-2" :message="form.errors.clock_size" /> -->
        </div>
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
          <TextInput id="alarm_size" label="Alarm Font Size (px)" v-model="model.alarm_size" type="number" step="1"
            min="1" inputWidthClass="w-24" />
          <!-- <InputError class="mt-2" :message="form.errors.alarm_size" /> -->
        </div>
      </div>
    </BasicPanel>
    <BasicPanel :collapsible="true">
      <template #header>
        Minimum Vertical Spacing
      </template>
      <div class="flex flex-row flex-wrap">
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
          <TextInput id="date_margin" label="Date Margin (px)" v-model="model.date_margin" type="number" step="1"
            min="-1000" inputWidthClass="w-24" />
          <!-- <InputError class="mt-2" :message="form.errors.date_margin" /> -->
        </div>
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
          <TextInput id="clock_margin" label="Clock Margin (px)" v-model="model.clock_margin" type="number" step="1"
            min="-1000" inputWidthClass="w-24" />
          <!-- <InputError class="mt-2" :message="form.errors.clock_margin" /> -->
        </div>
        <div class="flex flex-col bg-gray-200 dark:bg-gray-800 p-1 m-1 rounded-lg">
          <TextInput id="alarm_margin" label="Alarm Margin (px)" v-model="model.alarm_margin" type="number" step="1"
            min="-1000" inputWidthClass="w-24" />
          <!-- <InputError class="mt-2" :message="form.errors.alarm_margin" /> -->
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
  </form>
</template>