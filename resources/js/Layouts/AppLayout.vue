<script setup>
// import Icon from '@/Components/Icon.vue'
// import Toggle from '@/Components/Toggle.vue'
import NavBar from '@/Components/Nav/NavBar.vue'
import Footer from '@/Components/Footer.vue'
import darkMode from '@/Stores/darkMode.js'

// console.log(darkMode)
// const toggled = () => {
//   console.log(darkMode)
// }
</script>

<template>
  <div class="w-full" :class="darkMode ? 'dark' : ''">
    <div class="flex flex-col bg-white dark:bg-black text-black dark:text-white min-h-screen">
      <NavBar sitename="Smart Clock" />
      <div class="container flex-grow">
        <slot />
      </div>
      <Footer />
    </div>
  </div>
</template>