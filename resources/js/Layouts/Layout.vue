<script setup>
import NavBar from '@/Components/Nav/NavBar.vue'
import Footer from '@/Components/Footer.vue'
import Icon from '@/Components/Icon.vue'
import FlashSection from '@/Components/FlashSection.vue'
import darkMode from '@/Stores/darkMode.js'
import { usePage } from '@inertiajs/vue3'
import { onMounted } from 'vue'

const page = usePage()

onMounted(() => {
  // if (typeof page.props.flash == 'object') {
  //   page.props.flash = Object.values(page.props.flash)
  // }
  // console.log(page.props.flash)
})
</script>

<template>
  <div class="w-full" :class="darkMode ? 'dark' : ''">
    <div class="flex flex-col bg-white dark:bg-black text-black dark:text-white" style="min-height: 100vh;">
      <NavBar sitename="Smart Clock">
        <template #brand>
          <Icon icon="clock" />Smart Clock
        </template>
      </NavBar>
      <!-- <FlashMessage v-for="(msg, i) in $page.props.flash" :key="i" :message="msg" /> -->
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
