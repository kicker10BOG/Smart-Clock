<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'

import LoginModal from '@/Components/LoginModal.vue'
import Icon from '@/Components/Icon.vue'
import Toggle from '@/Components/Toggle.vue'
import NavLink from '@/Components/Nav/NavLink.vue'
import SlideTransition from "@/Components/SlideTransition.vue";
import Dropdown from '@/Components/Dropdown.vue'
import BasicButton from '@/Components/BasicButton.vue'

import darkMode from '@/Stores/darkMode.js'
import showNav from '@/Stores/showNav.js'

const props = defineProps({
  sitename: {
    default: 'Site',
  },
  logo: {
    default: null,
  },
})

const isOpen = ref(false)
const openLoginModal = ref(false)

const toggleFullScreen = () => {
  if (!document.fullscreenElement) {
    document.documentElement.requestFullscreen();
  } else if (document.exitFullscreen) {
    document.exitFullscreen();
  }
}

const closeMenu = () => {
  isOpen.value = false
}
</script>

<template>
  <SlideTransition>
    <div v-if="showNav" class="flex flex-row h-8 w-full bg-gray-300 dark:bg-gray-700 z-20">
      <div class="flex flex-shrink flex-col justify-around">
        <Link href="/" class="mx-1 text-xl">
        <!-- <img v-if="props.logo" :src="props.logo" />
        <span v-else>
          {{ props.sitename }}
        </span> -->
        <slot name="brand">
          {{ props.sitename }}
        </slot>
        </Link>
      </div>
      <div class="flex flex-grow">
      </div>
      <div class="flex flex-shrink flex-col justify-around">
        <div class="flex flex-shrink flex-row justify-around">
          <div class="mx-1 my-auto">
            <Dropdown v-model="isOpen">
              <template #button>
                <Icon icon="menu" size="md" extraClass="cursor-pointer" />
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
                <BasicButton @click="showNav = !showNav" size="sm" type="button">Hide Nav</BasicButton>
                <!-- <NavLink href="" @click="toggleFullScreen()" as="button">Toggle Fullscreen</NavLink> -->
                <BasicButton @click="toggleFullScreen()" size="sm" type="button">Toggle Fullscreen</BasicButton>
                <NavLink href="/">Home</NavLink>
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
            </Dropdown>
          </div>
          <!-- <div class="my-auto ml-2 mr-1 cursor-pointer rotate-180" @click="showNav = !showNav">
          <Icon icon="arrow" size="sm" />
        </div> -->
        </div>
      </div>
    </div>
    <div v-else class="absolute top-1 right-1 cursor-pointer text-gray-300 dark:text-gray-700 z-20"
      @click="showNav = !showNav">
      <Icon icon="arrow" size="sm" />
    </div>
  </SlideTransition>
  <LoginModal v-model="openLoginModal" />
</template>