<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import ClockForm from './Partials/ClockForm.vue'
import ClockDisplay from './Partials/ClockDisplay.vue'
import BasicPanel from '@/Components/BasicPanel.vue';

const form = useForm({
  name: '',
  month_format: 'short',
  weekday_format: 'short',
  show_date: true,
  show_next_alarm: true,
  show_seconds: false,
  use_12hr: true,
  ampm_format: 'dot_pm',
  ampm_dot_size: 80,
  show_ampm: true,
  shorten_ampm: true,
  width: 1024,
  height: 600,
  date_x: 0,
  clock_x: 0,
  alarm_x: 0,
  date_y: 225,
  clock_y: 0,
  alarm_y: -215,
  date_size: 100,
  time_size: 300,
  alarm_size: 80,
  date_font: 'sans-serif',
  clock_font: 'math',
  alarm_font: 'sans-serif',
})
</script>

<template>
  <div class="w-full">
    <Head title="New Clock" />
    <div class="container mx-auto">
      <div class="flex flex-col w-full">
        <h3>
          Create a New Clock
        </h3>
        <ClockForm v-model="form" type="new" class="z-10" />
        <BasicPanel :collapsible="true" :startCollapsed="true" class="z-0">
          <template #header>Preview</template>
          <div class="bg-white dark:bg-black w-full overflow-x-auto" :style="`min-width: ${form.width}px; height: ${form.height}px;`">
            <div class="m-auto" :style="`width: ${form.width}px; height: ${form.height}px;`">
              <ClockDisplay v-model="form" />
            </div>
          </div>
        </BasicPanel>
      </div>
    </div>
  </div>
</template>