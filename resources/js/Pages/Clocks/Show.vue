<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
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
const reloadOk = ref(true)
const reloadInterval = ref(null)

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

onMounted(() => {
  // console.log(window.Echo);
  window.Echo.channel(`clock.${clock.value.id}`)
    .listen('ClockUpdated', (e) => {
      // console.log(e)
      page.props.clock = e.clock
    })
  // reloadInterval.value = setInterval(() => {
  //   if (reloadOk.value) {
  //     router.reload({
  //       only: ['clock',],
  //     })
  //   }
  // }, 60000)
})

onUnmounted(() => {
  // clearInterval(reloadInterval.value)
  window.Echo.leaveChannel(`clock.${clock.value.id}`)
})
</script>

<template>
  <div class="flex flex-grow flex-col w-full justify-around">
    <ClockDisplay v-model="clock" />
    <div v-if="user && clock.user_id == user.id" class="relative">
      <ClockManage v-model="clock" @opened="reloadOk = false" @closed="reloadOk = true"/>
    </div>
  </div>
</template>