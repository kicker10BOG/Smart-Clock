<script setup>
import FlashMessage from '@/Components/FlashMessage.vue';
import { usePage } from '@inertiajs/vue3';
import { ref, watch } from "vue"

const props = defineProps({
  topOffset: {
    default: 35,
  },
  opacity: {
    default: 0.85,
  },
})

const staticDiv = ref(null)
const absoluteDiv = ref(null)

const page = usePage()
console.log(page.props.flash);
watch(page.props.flash, (newFlash) => {
  console.log(newFlash)
})
</script>

<template>
  <div ref="staticDiv" class="fixed flex flex-row justify-around w-full z-20"
    :style="`top: ${topOffset}px; opacity: ${opacity};`">
    <div ref="absoluteDiv" class="container mx-auto">
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
