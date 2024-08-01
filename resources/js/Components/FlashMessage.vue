<script setup>
import { onMounted, ref } from 'vue'
import { flash } from '@/Stores/flashMessages.js'
import Icon from './Icon.vue';

const props = defineProps({
  message: {
    type: Object,
    required: true,
  },
})

const visible = ref(false)
const typeClass = ref("");
switch (props.message.type) {
  case "info":
    typeClass.value = "bg-blue-300 text-gray-900";
    break;
  case "success":
  case "good":
    typeClass.value = "bg-green-300 text-gray-900";
    break;
  case "warning":
    typeClass.value = "bg-yellow-300 text-gray-900";
    break;
  case "error":
  case "danger":
    typeClass.value = "bg-red-300 text-gray-900";
    break;
}

function delMsg() {
  flash(props.message).remove()
}

function deleteMsg() {
  visible.value = false
  setTimeout(delMsg, 400)
}

onMounted(() => {
  setTimeout(() => visible.value = true, 100)
  if (props.message.delay > 0 && !props.message.important) {
    setTimeout(deleteMsg, props.message.delay * 1000 + 100)
  }
})
</script>

<template>
  <div v-if="visible" class="flex flex-col w-full my-2 mx-auto p-2 rounded-lg border-black border-2 text-center z-10"
    :class="typeClass">
    <div class="relative w-full">
      <div @click="deleteMsg" class="absolute right-0 top-0 cursor-pointer">
        <Icon icon="x" />
      </div>
    </div>
    <span v-if="message.title" class="mb-2 border-b-2 pb-1 text-lg">
      {{ message.title }}
    </span>
    <span>
      {{ message.message }}
    </span>
  </div>
</template>
