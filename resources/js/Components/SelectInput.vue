<script setup>
import { onMounted, ref } from 'vue';


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
  selectClass: {
    default: ''
  },
  position: {
    default: "left",
    validator: (value) => ["left", "right", "bottom", "top"].indexOf(value) !== -1,
  },
})

const input = ref(null);
const div = ref(null);

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
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
  <div class="flex justify-around m-auto" ref="div"
    :class="{ 'flex-col': position == 'top', 'flex-row': position == 'right', 'flex-col-reverse': position == 'bottom', 'flex-row-reverse': position == 'right' }">
    <div class="m-auto">
      <label :for="id" class="m-1 font-medium">{{ label }}</label>
    </div>
    <div class="m-auto">
      <select ref="input"
        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm min-w-fit"
        v-model="model">
        <slot />
      </select>
    </div>
  </div>
</template>
