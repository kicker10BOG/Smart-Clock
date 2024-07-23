<script setup>
import { onMounted, ref } from 'vue'

const model = defineModel()

const props = defineProps({
  id: {
    required: true,
  },
  value: {
    default: 1,
  },
  label: {
    default: "",
  },
  position: {
    default: "left",
    validator: (value) => ["left", "right", "bottom", "top"].indexOf(value) !== -1,
  },
})

const div = ref(null)
const input = ref(null)

onMounted(() => {
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
})

defineExpose({ focus: () => input.value.focus() })
</script>

<template>
  <div class="flex justify-around" ref="div"
    :class="{ 'flex-col': position == 'top', 'flex-row': position == 'right', 'flex-col-reverse': position == 'bottom', 'flex-row-reverse': position == 'right' }">
    <div class="m-auto">
      <label :for="id" class="m-1 font-medium">{{ label }}
        <slot />
      </label>
    </div>
    <div class="m-auto">
      <input :id="id" ref="input" type="checkbox" :value="value" v-model="model"
        class="w-4 h-4 m-1 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-900 dark:border-gray-600" />
    </div>
  </div>
</template>