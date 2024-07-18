<script setup>
const model = defineModel()
</script>

<template>
  <div class="inline-flex flex-row flex-shrink my-1 cursor-pointer" @click="model = !model">
    <div class="flex mx-1">
      <slot name="leftIcon" />
    </div>
    <div class="relative">
      <div class="block bg-gray-500 w-14 h-8 rounded-full"></div>
      <div class="dot absolute top-1 w-6 h-6 rounded-full transition glossy"
        :class="model == true ? 'right-1 bg-green-600' : 'left-1 bg-white'">
      </div>
    </div>
    <div class="flex mx-1">
      <slot name="rightIcon" />
    </div>
  </div>
</template>