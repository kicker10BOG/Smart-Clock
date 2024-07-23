<script setup>
import { ref, computed, onMounted } from 'vue'
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
// const clockProxy = ref(props.clock)
const clock = computed(() => page.props.clock)
</script>

<template>
  <div class="flex flex-grow flex-col w-full justify-around">
    <ClockDisplay v-model="clock" />
    <div v-if="user && clock.user_id == user.id" class="relative">
      <ClockManage v-model="clock" />
    </div>
  </div>
</template>