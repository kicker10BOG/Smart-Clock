<script setup>
import NavBar from '@/Components/Nav/NavBar.vue'
import Footer from '@/Layouts/Footer.vue'
import Icon from '@/Components/Icon.vue'
import FlashSection from '@/Components/FlashSection.vue'
import darkMode from '@/Stores/darkMode.js'
</script>

<template>
  <div class="w-full" :class="darkMode ? 'dark' : ''">
    <div class="flex flex-col bg-0 text-black dark:text-white" style="min-height: 100vh;">
      <NavBar sitename="Smart Clock">
        <template #brand>
          <Icon icon="clock" />Smart Clock
        </template>
      </NavBar>
      <FlashSection />
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
  transition: opacity 0.15s;
}

.fade-enter-active {
  transition-delay: 0.16s;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
