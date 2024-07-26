<script setup>
import BasicButton from '@/Components/BasicButton.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm } from '@inertiajs/vue3';

defineProps({
  canResetPassword: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});
const emit = defineEmits(['loggedIn'])

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(route('login'), {
    onSuccess: () => emit('loggedIn'),
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <form @submit.prevent="submit">
    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>

    <div>
      <TextInput id="email" label="Email" type="email" position="top" class="mt-1 block w-full" v-model="form.email"
        required autofocus autocomplete="username" />
      <InputError class="mt-2" :message="form.errors.email" />
    </div>

    <div class="mt-4">
      <TextInput id="password" label="Password" type="password" position="top" class="mt-1 block w-full"
        v-model="form.password" required autocomplete="current-password" />
      <InputError class="mt-2" :message="form.errors.password" />
    </div>

    <div class="block mt-4">
      <div class="flex items-center">
        <Checkbox v-model:checked="form.remember" id="remember" label="Remember Me" position="right" />
      </div>
    </div>

    <div class="flex items-center justify-end mt-4">
      <!-- <Link v-if="canResetPassword" :href="route('password.request')">
            Forgot your password?
            </Link> -->

      <BasicButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
        Log in
      </BasicButton>
    </div>
  </form>
</template>
