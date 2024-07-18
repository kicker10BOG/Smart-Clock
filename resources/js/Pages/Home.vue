<script setup>
import { computed } from 'vue'
import { Head, usePage } from '@inertiajs/vue3'

const page = usePage()
const user = computed(() => page.props.auth.user )
</script>

<template>
  <Layout>
    <Head title="Welcome" />
    <h1>Welcome</h1>
    <p>Hello {{ user ? user.name : 'guest' }}, welcome to your first Inertia app!</p>
  </Layout>
</template>