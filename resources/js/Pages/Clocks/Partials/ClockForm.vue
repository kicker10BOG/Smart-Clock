<script setup>
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import ClockInnerForm from './ClockInnerForm.vue'
import BasicButton from '@/Components/BasicButton.vue'

const model = defineModel()

const props = defineProps({
  type: {
    default: 'update',
    validator: (value) => ["update", "new"].indexOf(value) !== -1,
  }
})

defineEmits(['update:model-value'])

const useModel = model.value != undefined

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
  width: 1024,
  height: 600,
  date_x: 0,
  clock_x: 0,
  alarm_x: 0,
  date_y: 225,
  clock_y: 0,
  alarm_y: -215,
  date_size: 100,
  clock_size: 310,
  alarm_size: 80,
  date_font: 'sans-serif',
  clock_font: 'math',
  alarm_font: 'sans-serif',
})

if (useModel) {
  model.value.show_date = Boolean(model.value.show_date)
  model.value.show_next_alarm = Boolean(model.value.show_next_alarm)
  model.value.show_seconds = Boolean(model.value.show_seconds)
  model.value.use_12hr = Boolean(model.value.use_12hr)
  model.value.show_ampm = Boolean(model.value.show_ampm)
  model.value.shorten_ampm = Boolean(model.value.shorten_ampm)

  form.name = computed(() => model.value.name)
  form.month_format = computed(() => model.value.month_format)
  form.weekday_format = computed(() => model.value.weekday_format)
  form.show_date = computed(() => model.value.show_date)
  form.show_next_alarm = computed(() => model.value.show_next_alarm)
  form.show_seconds = computed(() => model.value.show_seconds)
  form.use_12hr = computed(() => model.value.use_12hr)
  form.show_ampm = computed(() => model.value.show_ampm)
  form.shorten_ampm = computed(() => model.value.shorten_ampm)
  form.width = computed(() => model.value.width)
  form.height = computed(() => model.value.height)
  form.date_x = computed(() => model.value.date_x)
  form.clock_x = computed(() => model.value.clock_x)
  form.alarm_x = computed(() => model.value.alarm_x)
  form.date_y = computed(() => model.value.date_y)
  form.clock_y = computed(() => model.value.clock_y)
  form.alarm_y = computed(() => model.value.alarm_y)
  form.date_size = computed(() => model.value.date_size)
  form.clock_size = computed(() => model.value.clock_size)
  form.alarm_size = computed(() => model.value.alarm_size)
  form.date_font = computed(() => model.value.date_font)
  form.clock_font = computed(() => model.value.clock_font)
  form.alarm_font = computed(() => model.value.alarm_font)
}
else {
  model.value = new Object()
  model.value.name = computed(() => form.name)
  model.value.month_format = computed(() => form.month_format)
  model.value.weekday_format = computed(() => form.weekday_format)
  model.value.show_date = computed(() => form.show_date)
  model.value.show_next_alarm = computed(() => form.show_next_alarm)
  model.value.show_seconds = computed(() => form.show_seconds)
  model.value.use_12hr = computed(() => form.use_12hr)
  model.value.show_ampm = computed(() => form.show_ampm)
  model.value.shorten_ampm = computed(() => form.shorten_ampm)
  model.value.width = computed(() => form.width)
  model.value.height = computed(() => form.height)
  model.value.date_x = computed(() => form.date_x)
  model.value.clock_x = computed(() => form.clock_x)
  model.value.alarm_x = computed(() => form.alarm_x)
  model.value.date_y = computed(() => form.date_y)
  model.value.clock_y = computed(() => form.clock_y)
  model.value.alarm_y = computed(() => form.alarm_y)
  model.value.date_size = computed(() => form.date_size)
  model.value.clock_size = computed(() => form.clock_size)
  model.value.alarm_size = computed(() => form.alarm_size)
  model.value.date_font = computed(() => form.date_font)
  model.value.clock_font = computed(() => form.clock_font)
  model.value.alarm_font = computed(() => form.alarm_font)
}

const submit = () => {
  if (props.type == "update") {
    form.put(route('clocks.update', { 'clock': model.value.id }), {
      onSuccess: () => {
        model.value.show_date = Boolean(model.value.show_date)
        model.value.show_next_alarm = Boolean(model.value.show_next_alarm)
        model.value.show_seconds = Boolean(model.value.show_seconds)
        model.value.use_12hr = Boolean(model.value.use_12hr)
        model.value.show_ampm = Boolean(model.value.show_ampm)
        model.value.shorten_ampm = Boolean(model.value.shorten_ampm)
        form.show_date = computed(() => model.value.show_date)
        form.show_next_alarm = computed(() => model.value.show_next_alarm)
        form.show_seconds = computed(() => model.value.show_seconds)
        form.use_12hr = computed(() => model.value.use_12hr)
        form.show_ampm = computed(() => model.value.show_ampm)
        form.shorten_ampm = computed(() => model.value.shorten_ampm)
      }
    })
  }
  else {
    form.post(route('clocks.store'))
  }
}
</script>

<template>
  <div class="flex flex-col w-fit m-auto">
    <ClockInnerForm v-model="model" />
    <div class="flex flex-row justify-end">
      <BasicButton @click="submit" size="sm">Save</BasicButton>
    </div>
  </div>
</template>