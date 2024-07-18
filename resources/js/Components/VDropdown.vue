<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import SlideTransition from "@/Components/SlideTransition.vue";
const model = defineModel({ default: false })
const props = defineProps({
  placement: {
    type: String,
    default: "right",
    validator: (value) => ["right", "left"].indexOf(value) !== -1,
  },
  direction: {
    type: String,
    default: "down",
    validator: (value) => ["up", "down", "right", "left"].indexOf(value) !== -1,
  },
  subHeight: {
    default: 55,
  },
})
const height = ref(200)
const handleResize = () => {
  height.value = window.innerHeight - props.subHeight;
}
onMounted(() => {
  const onEscape = (e) => {
    if (e.key === "Esc" || e.key === "Escape") {
      model.value = false;
    }
  };
  document.addEventListener("keydown", onEscape);
  window.addEventListener("resize", handleResize);
  handleResize();
})
onUnmounted(() => {
  window.removeEventListener("resize", handleResize);
})
</script>

<template>
  <div class="relative">
    <button class="z-10 relative flex items-center focus:outline-none select-none" @click="model = !model">
      <slot name="button" />
    </button>

    <!-- to close when clicked on space around it-->
    <button class="fixed inset-0 h-full w-full cursor-default focus:outline-none" v-if="model" @click="model = false"
      tabindex="-1"></button>

    <!--dropdown menu-->
    <slide-transition :direction="direction">
      <div
        class="absolute shadow-lg border min-w-[150px] rounded py-1 px-2 text-sm mt-2 bg-gray-100 z-50 dark:bg-gray-900 dark:border-gray-600 overflow-y-auto"
        :class="placement === 'right' ? 'right-0' : 'left-0'" v-if="model" :style="`max-height: ${height}px`">
        <slot />
      </div>
    </slide-transition>
  </div>
</template>
