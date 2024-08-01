<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import ClockDisplay from './Partials/ClockDisplay.vue';
import ClockManage from './Partials/ClockManage.vue';

const props = defineProps({
  clock: {
    required: true,
    type: Object,
  }
})

const page = usePage()
const user = computed(() => page.props.auth.user)
const clock = computed(() => page.props.clock)

let timeout = null
const wakeTime = 3000
function hideMouseCursor() {
  if (document.body.style.cursor !== 'none') {
    document.body.style.cursor = 'none';
  }
}
function showMouseCursor() {
  clearTimeout(timeout);
  if (document.body.style.cursor !== 'default') {
    document.body.style.cursor = 'default';
  }
}
document.onmousemove = function () {
  showMouseCursor();
  timeout = setTimeout(hideMouseCursor, wakeTime);
};
document.onmousedown = function () {
  showMouseCursor();
  timeout = setTimeout(hideMouseCursor, wakeTime);
};
</script>

<template>
  <div class="flex flex-grow flex-col w-full justify-around">
    <ClockDisplay v-model="clock" />
    <div v-if="user && clock.user_id == user.id" class="relative">
      <ClockManage v-model="clock"/>
    </div>
  </div>
</template>