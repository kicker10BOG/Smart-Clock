<script setup>
import { computed } from 'vue'
import { Head, usePage } from '@inertiajs/vue3'

const page = usePage()
const user = computed(() => page.props.auth.user )
</script>

<template>
    <div class="flex flex-grow flex-col w-full">
        <Head title="Welcome" />
        <h1>Welcome</h1>
        <p>Hello {{ user ? user.name : 'guest' }}, welcome to your first Inertia app!</p>
    </div>
</template>