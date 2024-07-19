<script setup>
import { computed } from 'vue'
import { Link, useForm, usePage } from '@inertiajs/vue3';
import BasicModule from '@/Components/BasicModal.vue'
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

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

const page = usePage()

const form = useForm({
  email: '',
  password: '',
  remember: false,
  url: computed(() => page.url),
});

const submit = () => {
  form.transform(data => ({
    ...data,
    remember: form.remember ? 'on' : '',
  })).post(route('login'), {
    onFinish: () => {
      form.reset('password')
      model.value = false
    }
  });
};
</script>

<template>
  <BasicModule v-model="model">
    <template #header>
      <h3>
        Login
      </h3>
    </template>
    <AuthenticationCard>

      <div v-if="status" class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
        {{ status }}
      </div>

      <form @submit.prevent="submit">
        <div>
          <TextInput id="email" label="Email" v-model="form.email" type="email" position="top" class="mt-1 block w-full"
            required autofocus autocomplete="username" />
          <InputError class="mt-2" :message="form.errors.email" />
        </div>

        <div class="mt-4">
          <TextInput id="password" label="Password" v-model="form.password" type="password" position="top"
            class="mt-1 block w-full" required autocomplete="current-password" />
          <InputError class="mt-2" :message="form.errors.password" />
        </div>

        <div class="block mt-4">
          <div class="flex flex-row justify-end">
            <Checkbox v-model:checked="form.remember" id="remember" label="remember me" position="right" />
          </div>
        </div>

      </form>
    </AuthenticationCard>

    <template #footer>
      <div class="flex flex-row items-center justify-end w-full mt-4">
        <Link v-if="canResetPassword" :href="route('password.request')"
          class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
        Forgot your password?
        </Link>

        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
          @click="submit()">
          Log in
        </PrimaryButton>
      </div>
    </template>
  </BasicModule>
</template>
