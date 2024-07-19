<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import SlideTransition from "@/Components/SlideTransition.vue"
import Icon from '@/Components//Icon.vue';
import showNav from '@/Stores/showNav.js'

const page = usePage()
const clock = computed(() => page.props.clock)
</script>

<template>
  <SlideTransition direction="up">
    <div v-if="showNav" class="flex flex-row justify-around h-8 w-full bg-gray-300 dark:bg-gray-700">
      <template v-if="clock">
        <div class="flex flex-col justify-around">
          Created by: Jason Bogle
        </div>
        <div class="flex flex-col justify-around">
          <div>
            <Icon icon="clock" /> {{ clock.name }} by {{ clock.username }}
          </div>
        </div>
      </template>
      <template v-else>
        <div class="flex flex-col justify-around">
          Created by: Jason Bogle
        </div>
        <!-- <div class="flex flex-col justify-around">
          {{ $page.url }}
        </div> -->
      </template>
    </div>
  </SlideTransition>
</template>