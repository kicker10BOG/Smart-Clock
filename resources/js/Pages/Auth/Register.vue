<script setup>
import BasicButton from '@/Components/BasicButton.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <div class="container flex flex-col justify-center m-auto">
    <div class="flex flex-row justify-center">
      <div class="m-auto">
        <Head title="Register" />

        <form @submit.prevent="submit">
          <div>
            <TextInput id="name" label="Username" type="text" position="top" class="mt-1 block w-full" v-model="form.name" required autofocus
              autocomplete="name" />
            <InputError class="mt-2" :message="form.errors.name" />
          </div>

          <div class="mt-4">
            <TextInput id="email" type="email" label="Email" position="top" class="mt-1 block w-full" v-model="form.email" required
              autocomplete="username" />
            <InputError class="mt-2" :message="form.errors.email" />
          </div>

          <div class="mt-4">
            <TextInput id="password" label="Password" type="password" position="top" class="mt-1 block w-full" v-model="form.password" required
              autocomplete="new-password" />
            <InputError class="mt-2" :message="form.errors.password" />
          </div>

          <div class="mt-4">
            <TextInput id="password_confirmation" label="Confirm Password" position="top" type="password" class="mt-1 block w-full"
              v-model="form.password_confirmation" required autocomplete="new-password" />
            <InputError class="mt-2" :message="form.errors.password_confirmation" />
          </div>

          <div class="flex items-center justify-end mt-4">
            <Link :href="route('login')">
              Already registered?
            </Link>

            <BasicButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
              Register
            </BasicButton>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
