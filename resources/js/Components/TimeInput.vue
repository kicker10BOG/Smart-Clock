<script setup>
import { onMounted, ref, watch } from 'vue'
import Dropdown from './Dropdown.vue'
import SelectInput from './SelectInput.vue'
import TextInput from './TextInput.vue'

const model = defineModel()

const props = defineProps({
  id: {
    required: true,
  },
  use_12hr: {
    default: true,
  },
  label: {
    default: "",
  },
  inputClass: {
    default: "w-full",
  },
  position: {
    default: "left",
    validator: (value) => ["left", "right", "bottom", "top"].indexOf(value) !== -1,
  },
})

defineEmits(['update:model-value'])

const timeShow = ref('')
const hour = ref(model ? (props.use_12hr ? ((model.value.hour % 12 == 0 ? 12 : (model.value.hour % 12))) : model.value.hour) : 8)
const minute = ref(model ? model.value.minute : 0)
const ampm = ref(model ? (model.hour > 11 ? 'PM' : 'AM') : 'AM')

watch(hour, (newVal, oldVal) => {
  if (props.use_12hr) {
    if (ampm.value == 'PM') {
      model.value.hour = newVal + 12
    }
    else if (newVal == 12) {
      model.value.hour = 0
    }
    else {
      model.value.hour = newVal
    }
  }
  else {
    model.value.hour = newVal
  }
  updateTime()
})

watch(minute, (newVal, oldVal) => {
  model.value.minute = newVal
  updateTime()
})

watch(ampm, (newVal, oldVal) => {
  if (newVal == 'PM') {
    if (model.value.hour < 12) {
      model.value.hour += 12
    }
  }
  else {
    if (model.value.hour >= 12) {
      model.value.hour -= 12
    }
  }
  updateTime()
})

const updateTime = () => {
  let hr = model.value.hour
  if (props.use_12hr) {
    hr %= 12
    if (hr == 0) {
      hr = 12
    }
    if (model.value.hour > 11) {
      ampm.value = 'PM'
    }
  }
  let m = model.value.minute
  m = m < 10 ? `0${m}` : m
  timeShow.value = `${hr}:${m} ${props.use_12hr ? ampm.value : ''}`
}

onMounted(() => {
  updateTime()
})

</script>

<template>
  <div class="flex" ref="div"
    :class="{ 'flex-col': position == 'top', 'flex-row': position == 'right', 'flex-col-reverse': position == 'bottom', 'flex-row-reverse': position == 'right' }">
    <div class="m-auto">
      <label :for="id" class="m-1 font-medium whitespace-nowrap">{{ label }}</label>
    </div>
    <div class="m-auto" :class="inputClass">
      <Dropdown placement="left">
        <template #button>
          <div :id="id"
            class="cursor-pointer border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm p-2">
            {{ timeShow }}
          </div>
        </template>
        <div class="flex flex-row justify-center">
          <TextInput id="hour" v-model="hour" type="number" :min="use_12hr ? 1 : 0" :max="use_12hr ? 12 : 23"
            inputClass="w-16" />
          <span class="m-auto">:</span>
          <TextInput id="minute" v-model="minute" type="number" min="0" max="59" inputClass="w-16" />
          <SelectInput v-if="use_12hr" id="ampm" v-model="ampm">
            <option value="AM">AM</option>
            <option value="PM">PM</option>
          </SelectInput>
        </div>
      </Dropdown>
    </div>
  </div>
</template>