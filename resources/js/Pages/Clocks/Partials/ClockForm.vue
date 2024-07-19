<script setup>
import { ref, computed } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
import ClockInnerForm from './ClockInnerForm.vue'
import BasicButton from '@/Components/BasicButton.vue'

const model = defineModel()
console.log(model.value);

const props = defineProps({
  type: {
    default: 'update',
    validator: (value) => ["update", "new"].indexOf(value) !== -1,
  }
})

const useModel = model.value != undefined
console.log(useModel);
const orderArr = ref(new Array())

if (useModel) {
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
}
else {
  orderArr.value = [
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
  ]
}

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
  form.date_order = computed(() => model.value.date_order)
  form.clock_order = computed(() => model.value.clock_order)
  form.alarm_order = computed(() => model.value.alarm_order)
  form.date_size = computed(() => model.value.date_size)
  form.clock_size = computed(() => model.value.clock_size)
  form.alarm_size = computed(() => model.value.alarm_size)
  form.date_margin = computed(() => model.value.date_margin)
  form.clock_margin = computed(() => model.value.clock_margin)
  form.alarm_margin = computed(() => model.value.alarm_margin)
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
  model.value.date_order = computed(() => form.date_order)
  model.value.clock_order = computed(() => form.clock_order)
  model.value.alarm_order = computed(() => form.alarm_order)
  model.value.date_size = computed(() => form.date_size)
  model.value.clock_size = computed(() => form.clock_size)
  model.value.alarm_size = computed(() => form.alarm_size)
  model.value.date_margin = computed(() => form.date_margin)
  model.value.clock_margin = computed(() => form.clock_margin)
  model.value.alarm_margin = computed(() => form.alarm_margin)
  model.value.date_font = computed(() => form.date_font)
  model.value.clock_font = computed(() => form.clock_font)
  model.value.alarm_font = computed(() => form.alarm_font)
}

const submit = () => {
  // console.log(useModel)
  // console.log(useModel.value)
  console.log(props.type)
  if (props.type == "update") {
    form.put(route('clocks.update', { 'clock': model.value.id }));
    router.visit(route('clocks.show', { 'clock': model.value.id }), {
      only: ['clock'],
    })
  }
  else {
    form.post(route('clocks.store'));
  }
}
</script>

<template>
  <div class="flex flex-col w-fit m-auto">
    <ClockInnerForm v-model="model" v-if="useModel" />
    <ClockInnerForm v-model="form" v-else />
    <div class="flex flex-row justify-end">
      <BasicButton @click="submit">Save</BasicButton>
    </div>
  </div>
</template>