<script setup>
import { onMounted, ref } from 'vue'

const model = defineModel()

const props = defineProps({
  id: {
    required: true,
  },
  type: {
    default: "text",
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
defineExpose({ focus: () => input.value.focus() })

const div = ref(null)
const input = ref(null)

onMounted(() => {
  if (div.value.hasAttribute('autocomplete')) {
    input.value.setAttribute('autocomplete', div.value.removeAttribute('autocomplete'))
    div.value.removeAttribute('autocomplete')
  }
  if (div.value.hasAttribute('autofocus')) {
    div.value.removeAttribute('autofocus')
    input.value.setAttribute('autofocus', '')
    input.value.focus()
  }
  if (div.value.hasAttribute('required')) {
    div.value.removeAttribute('required')
    input.value.setAttribute('required', '')
  }
  if (div.value.hasAttribute('disabled')) {
    div.value.removeAttribute('disabled')
    input.value.setAttribute('disabled', '')
  }
  if (div.value.hasAttribute('step')) {
    input.value.setAttribute('step', div.value.getAttribute('step'))
    div.value.removeAttribute('step')
  }
  if (div.value.hasAttribute('min')) {
    input.value.setAttribute('min', div.value.getAttribute('min'))
    div.value.removeAttribute('min')
  }
  if (div.value.hasAttribute('max')) {
    input.value.setAttribute('max', div.value.getAttribute('max'))
    div.value.removeAttribute('max')
  }
})
</script>

<template>
  <div class="flex" ref="div"
    :class="{ 'flex-col': position == 'top', 'flex-row': position == 'right', 'flex-col-reverse': position == 'bottom', 'flex-row-reverse': position == 'right' }">
    <div class="m-auto">
      <label :for="id" class="m-1 font-medium whitespace-nowrap">{{ label }}</label>
    </div>
    <div class="m-auto" :class="inputClass">
      <input ref="input" :id="id"
        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
        :class="inputClass" :type="type" v-model="model">
    </div>
  </div>
</template>
