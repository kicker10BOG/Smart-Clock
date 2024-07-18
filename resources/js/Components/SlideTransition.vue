<template>
  <transition
    v-if="direction === 'left'"
    enter-active-class="transition-all duration-300 ease-out"
    leave-active-class="transition-all duration-300 ease-in"
    enter-from-class="scale-x-0 origin-right"
    enter-to-class="scale-x-100 origin-right"
    leave-from-class="scale-x-100 origin-right"
    leave-to-class="scale-x-0 origin-right"
  >
    <slot></slot>
  </transition>
  <transition
    v-else-if="direction === 'right'"
    enter-active-class="transition-all duration-300 ease-out"
    leave-active-class="transition-all duration-300 ease-in"
    enter-from-class="scale-x-0 origin-left"
    enter-to-class="scale-x-100 origin-left"
    leave-from-class="scale-x-100 origin-left"
    leave-to-class="scale-x-0 origin-left"
  >
    <slot></slot>
  </transition>
  <transition
    v-else-if="direction === 'up'"
    enter-active-class="transition-all duration-300 ease-out"
    leave-active-class="transition-all duration-300 ease-in"
    enter-from-class="scale-y-0 origin-bottom"
    enter-to-class="scale-y-100 origin-bottom"
    leave-from-class="scale-y-100 origin-bottom"
    leave-to-class="scale-y-0 origin-bottom"
  >
    <slot></slot>
  </transition>
  <transition
    v-else
    enter-active-class="transition-all duration-300 ease-out"
    leave-active-class="transition-all duration-300 ease-in"
    enter-from-class="scale-y-0 origin-top"
    enter-to-class="scale-y-100 origin-top"
    leave-from-class="scale-y-100 origin-top"
    leave-to-class="scale-y-0 origin-top"
  >
    <slot></slot>
  </transition>
</template>
<script>
export default {
  name: "slide-transition",
  props: {
    direction: {
      type: String,
      default: "down",
      validator: (value) => ["up", "down", "right", "left"].indexOf(value) !== -1,
    },
  },
};
</script>
