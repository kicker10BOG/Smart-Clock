<script setup>
import FlashMessage from '@/Components/FlashMessage.vue'
import { ref } from "vue"

const props = defineProps({
  topOffset: {
    default: 35,
  },
  opacity: {
    default: 0.85,
  },
})
</script>

<template>
  <div class="fixed flex flex-row justify-around w-full z-20"
    :style="`top: ${topOffset}px; opacity: ${opacity};`">
    <div class="container mx-auto">
      <transition name="fade" v-for="(msg, i) in $page.props.flash" :key="msg.id">
        <FlashMessage :message="msg" />
      </transition>
    </div>
  </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
