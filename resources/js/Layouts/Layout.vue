<script setup>
import Banner from '@/Components/Banner.vue';
import NavBar from '@/Components/Nav/NavBar.vue'
import Footer from '@/Components/Footer.vue'
import darkMode from '@/Stores/darkMode.js'
</script>

<template>
  <div class="w-full" :class="darkMode ? 'dark' : ''">
    <div class="flex flex-col bg-white dark:bg-black text-black dark:text-white" style="min-height: 100vh;">
      <NavBar sitename="Smart Clock" />
      <Banner />
      <div class="flex flex-grow mx-auto w-full z-10">
        <div class="relative flex flex-grow flex-col w-full">
          <transition name="fade">
            <slot />
          </transition>
        </div>
      </div>
      <Footer />
    </div>
  </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  transition: opacity 0.5s ease-in-out;
}

/* .fade-enter-active {
  transition-delay: 0.3s;
} */

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
