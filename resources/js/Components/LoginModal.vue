<script setup>
import BasicModule from '@/Components/BasicModal.vue'
import LoginForm from './LoginForm.vue';

const model = defineModel({
  type: Boolean,
  default: false
})

defineProps({
  canResetPassword: {
    type: Boolean,
    default: true,
  },
  status: String,
});
</script>

<template>
  <BasicModule v-model="model">
    <template #header>
      <h3>
        Login
      </h3>
    </template>
    <div class="flex flex-row justify-center w-full">
      <div class="m-auto p-2">
        <LoginForm :canTesetPassword="canResetPassword" :status="status" @loggedIn="model = false"/>
      </div>
    </div>
  </BasicModule>
</template>
