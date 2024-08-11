<script setup>
import { computed, onMounted, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import BasicModal from '@/Components/BasicModal.vue'
import BasicButton from '@/Components/BasicButton.vue';
import ColorForm from './ColorForm.vue';
import Icon from '@/Components/Icon.vue';
import LinkButton from '@/Components/LinkButton.vue';

const openNewModal = ref(false)
const openEditModal = ref()
const page = usePage()
const clock = computed(() => (page.props.clock))

onMounted(() => {
  openEditModal.value = []
  clock.value.colors.forEach(color => {
    openEditModal.value[color.id] = false
  });
})
</script>

<template>
  <div class="flex flex-col w-full py-1">
    <div class="flex flex-row justify-around w-full my-1">
      <BasicButton class="mx-auto" type="new" @click="openNewModal = true" size="sm">Add New Color</BasicButton>
    </div>
    <div v-if="openEditModal" v-for="(color, i) in clock.colors" :key="color.id"
      class="flex flex-col bg-gray-200 dark:bg-gray-800 rounded-lg mx-2 my-1 p-2">
      <div class="flex flex-row justify-start">
        <span class="mr-1">
          {{ color.name }}
        </span>
        <BasicButton type="standard" size="sm" class="ml-1" @click="openEditModal[color.id] = true">
          <Icon icon="edit" size="sm" />
        </BasicButton>
      </div>
      <div class="flex flex-row justify-start">
        <div class="mr-l">
          <LinkButton v-if="color.enabled" method="put" :href="route('colors.disable', { color: color.id })" as="button"
            type="good" size="sm" preserve-scroll>
            <Icon icon="check" size="sm" />
          </LinkButton>
          <LinkButton v-else method="put" :href="route('colors.enable', { color: color.id })" as="button" type="bad"
            size="sm" preserve-scroll>
            <Icon icon="x" size="sm" />
          </LinkButton>
        </div>
        <div class="mx-1">
          <span v-if="clock.use_12hr">
            {{ color.hour % 12 == 0 ? '12' : (color.hour % 12) }}:{{ color.minute < 10 ? `0${color.minute}` :
              color.minute }} {{ color.hour > 11 ? 'PM' : 'AM' }}
          </span>
          <span v-else>
            {{ color.hour }}:{{ color.minute < 10 ? `0${color.minute}` : color.minute }} </span>
        </div>
        <div class="ml-1">
          <LinkButton method="delete" :href="route('colors.destroy', { color: color.id })" as="button" type="danger"
            size="sm" preserve-scroll>
            <Icon icon="trash" size="sm" />
          </LinkButton>
        </div>
      </div>
      <BasicModal v-model="openEditModal[color.id]">
        <template #header>
          <div class="my-auto">
            <h3>
              Edit Color
            </h3>
          </div>
        </template>
        <ColorForm v-model="clock.colors[i]" @submit="openEditModal[color.id] = false" />
      </BasicModal>
    </div>
  </div>

  <BasicModal v-model="openNewModal">
    <template #header>
      <div class="my-auto">
        <h3>
          Add New Color Change
        </h3>
      </div>
    </template>
    <ColorForm @submit="openNewModal = false" />
  </BasicModal>
</template>