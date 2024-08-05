<script setup>
import { computed } from 'vue'
import { Head, usePage } from '@inertiajs/vue3'

const page = usePage()
const user = computed(() => page.props.auth.user)
</script>

<template>
  <div class="container mx-auto">
    <div class="flex flex-grow flex-col gap-2 w-full">
      <Head title="Home" />
      <h1>Welcome</h1>
      <p>Hello {{ user ? user.name : 'guest' }}, welcome to the Smart Clock web app!</p>
      <p>This web app can be used to create clocks for different sized screens.</p>
      <p>
        Once a clock is created, you can change its configuration and set alarms. 
        Any changes will be automatically pushed to any device that displays the clock. 
        So, if you have something like a tablet or pi showing a clock and you want to change 
          the font size or edit an alarm, you can do that from your pc or phone and it you 
          will see the changes on the tablet or pi or any other device showing the clock. 
        Snooze and dismiss also work across devices.
        So, pressing snooze or dismiss on one device will also cause it to take effect on 
          all other devices showing that clock. 
      </p>
      <p>
        The menu in the top right also has a few useful buttons.
        The first toggles between light and dark modes.
        The next one hides the navigation.
        This is especially useful when you just want to display a clock and nothing else. 
        When you hide the navigation, a small, discreet down-arrow will appear in the top 
          right.
        Clicking it will bring back the navigation.
        The last button toggles fullscreen mode. 
        Of course, on a pc you can also just hit F11, but I anticipate this being used on
          something like a cheap tablet where you may not have a keyboard connected to it.
      </p>
      <p v-if="user">
        So, go to your Dashboard using the menu in the top right and start experimenting
          with some clocks! 
      </p>
      <p v-else>
        So, login or register then go to your Dashboard using the menu in the top right and 
          start experimenting with some clocks! 
      </p>
    </div>
  </div>
</template>