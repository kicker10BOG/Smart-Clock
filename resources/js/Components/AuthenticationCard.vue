<template>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 flex-1">
        <div>
            <slot name="logo" />
        </div>

        <div class="w-full sm:max-w-md px-6 py-4 bg-gray-200 dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>
