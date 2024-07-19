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
  vertPlacement: {
    type: String,
    default: "below",
    validator: (value) => ["above", "below"].indexOf(value) !== -1,
  },
  direction: {
    type: String,
    default: "down",
    validator: (value) => ["up", "down", "right", "left"].indexOf(value) !== -1,
  },
  subHeight: {
    default: 55,
  },
  opacity: {
    type: Number,
    default: 1,
  },
  clickAwayToClose: {
    type: Boolean,
    default: true,
  },
  makeFixed: {
    type: Boolean,
    default: false,
  },
  fixedTop: {
    default: null,
  },
  fixedBottom: {
    default: null,
  },
  fixedLeft: {
    default: null,
  },
  fixedRight: {
    default: null,
  },
})

const height = ref(200)
const handleResize = () => {
  height.value = window.innerHeight - props.subHeight;
}

const classes = ref('')
const styles = ref('')
onMounted(() => {
  const onEscape = (e) => {
    if (e.key === "Esc" || e.key === "Escape") {
      model.value = false;
    }
  };
  document.addEventListener("keydown", onEscape);
  window.addEventListener("resize", handleResize);
  handleResize();

  if (props.makeFixed) {
    classes.value = "fixed"
    styles.value += props.fixedTop !== null ? `top: ${props.fixedTop}px; ` : ''
    styles.value += props.fixedBottom !== null ? `bottom: ${props.fixedBottom}px; ` : ''
    styles.value += props.fixedLeft !== null ? `left: ${props.fixedLeft}px; ` : ''
    styles.value += props.fixedRight !== null ? `right: ${props.fixedRight}px; ` : ''
  }
  else {
    classes.value = "absolute"
    classes.value += props.placement == 'right' ? ' right-0' : ' left-0'
    classes.value += props.vertPlacement == 'bottom' ? ' bottom-12' : ''
  }
})
onUnmounted(() => {
  window.removeEventListener("resize", handleResize);
})
</script>

<template>
  <div class="relative">
    <!-- <div class="flex" :class="{'flex-col': vertPlacement == 'bottom', 'flex-col-reverse': vertPlacement == 'top'}"> -->
    <button class="z-10 relative flex items-center focus:outline-none select-none" @click="model = !model">
      <slot name="button" />
    </button>

    <!-- to close when clicked on space around it-->
    <button class="fixed inset-0 h-full w-full cursor-default focus:outline-none" v-if="model && clickAwayToClose"
      @click="model = false" tabindex="-1"></button>

    <!--dropdown menu-->
    <slide-transition :direction="direction">
      <div :class="classes"
        class="shadow-lg border min-w-[150px] rounded py-1 px-2 text-sm mt-2 bg-gray-100 z-50 dark:bg-gray-900 dark:border-gray-600 overflow-y-auto"
        :style="`opacity: ${opacity}; max-height: ${height}px; ${styles}`" v-if="model">
        <slot />
      </div>
    </slide-transition>
    <!-- </div> -->
  </div>
</template>
