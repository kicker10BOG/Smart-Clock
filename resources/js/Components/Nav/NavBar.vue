<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'

import LoginModal from '@/Components/LoginModal.vue'
import Icon from '@/Components/Icon.vue'
import Toggle from '@/Components/Toggle.vue'
import NavLink from '@/Components/Nav/NavLink.vue'
import SlideTransition from "@/Components/SlideTransition.vue";
import VDropdown from '@/Components/VDropdown.vue'

import darkMode from '@/Stores/darkMode.js'
import showNav from '@/Stores/showNav.js'

const props = defineProps({
  sitename: {
    default: 'Site',
  },
  logo: {
    default: null,
  },
  subHeight: {
    default: 100,
  }
})

// const height = ref(200)
const isOpen = ref(false)
const openLoginModal = ref(false)

const toggleFullScreen = () => {
  if (!document.fullscreenElement) {
    document.documentElement.requestFullscreen();
  } else if (document.exitFullscreen) {
    document.exitFullscreen();
  }
}

const logout = () => {
  router.post('/logout')
  router.reload({ preserveState: false })
}

// const handleResize = () => {
//   height.value = window.innerHeight - props.subHeight;
// }
// onMounted(() => {
//   window.addEventListener("resize", handleResize);
//   handleResize();
// })
// onUnmounted(() => {
//   window.removeEventListener("resize", handleResize);
// })

const closeMenu = () => {
  isOpen.value = false
}
</script>

<template>
  <SlideTransition>
  <div v-if="showNav" class="flex flex-row h-8 w-full bg-gray-300 dark:bg-gray-700">
    <div class="flex flex-shrink flex-col justify-around">
      <Link href="/" class="mx-1 text-xl">
      <img v-if="props.logo" :src="props.logo" />
      <span v-else>
        {{ props.sitename }}
      </span>
      </Link>
    </div>
    <div class="flex flex-grow">
    </div>
    <div class="flex flex-shrink flex-col justify-around">
      <div class="flex flex-shrink flex-row justify-around">
        <div class="mx-1 my-auto">
          <VDropdown v-model="isOpen">
            <template #button>
              <Icon icon="menu" iconSize="md" extraClass="cursor-pointer" />
            </template>
            <Toggle v-model="darkMode">
              <template #leftIcon>
                <Icon icon="sun" />
              </template>
              <template #rightIcon>
                <Icon icon="moon" />
              </template>
            </Toggle>
            <div class="flex flex-col overflow-y-auto z-50" @click="closeMenu()">
              <NavLink href="" @click="showNav = !showNav" as="button">Hide Nav</NavLink>
              <NavLink href="" @click="toggleFullScreen()" as="button">Toggle Fullscreen</NavLink>
              <NavLink href="/">Home</NavLink>
              <!-- <NavLink v-if="$page.props.auth.user" href="/logout" method="post" @click="logout()">Logout</NavLink> -->
              <template v-if="$page.props.auth.user">
                <NavLink href="/dashboard">Dashboard</NavLink>
                <NavLink href="/logout" method="post" as="button">Logout</NavLink>
              </template>
              <template v-else>
                <!-- <NavLink href="/login">Login</NavLink> -->
                <NavLink href="" @click="openLoginModal = !openLoginModal" as="button">Login</NavLink>
                <NavLink href="/register">Register</NavLink>
              </template>
            </div>
          </VDropdown>
        </div>
        <!-- <div class="my-auto ml-2 mr-1 cursor-pointer rotate-180" @click="showNav = !showNav">
          <Icon icon="arrow" iconSize="sm" />
        </div> -->
      </div>
    </div>
  </div>
  <div v-else class="absolute top-1 right-1 cursor-pointer text-gray-300 dark:text-gray-700"
    @click="showNav = !showNav">
    <Icon icon="arrow" iconSize="sm" />
  </div>
  </SlideTransition>
  <LoginModal v-model="openLoginModal">
    <template #title>
      Login
    </template>
    <template #content>
      form here 
    </template>
    <template #footer>
      footer
    </template>
  </LoginModal>
</template>