<script setup>
import LoginForm from '@/Components/LoginForm.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
  canResetPassword: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});
</script>

<template>
  <div class="container flex flex-col justify-center m-auto">
    <div class="flex flex-row justify-center">
      <div class="m-auto">
        <Head title="Log in" />
        <LoginForm :canTesetPassword="canResetPassword" :status="status" />
      </div>
    </div>
  </div>
</template>
