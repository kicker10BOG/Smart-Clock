<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3'
import BasicPanel from '@/Components/BasicPanel.vue';
import LinkButton from '@/Components/LinkButton.vue'
import Icon from '@/Components/Icon.vue';
import BasicButton from '@/Components/BasicButton.vue';
import BasicModal from '@/Components/BasicModal.vue';

const props = defineProps({
  clocks: {
    required: true,
    type: Array,
  }
})

const delModalRefs = ref([])

function confirmDeleteClock(i) {
  delModalRefs.value[i].openModal()
}

function deleteClock(clock, i) {
  delModalRefs.value[i].closeModal()
  setTimeout(() => {
    router.delete(route('clocks.destroy', { 'clock': clock }), {
      preserveScroll: true,
    })
  }, 300)
}
</script>

<template>
  <div class="container mx-auto">
    <div class="flex flex-col w-full">
      <div class="flex flex-row mt-2">
        <LinkButton :href="route('clocks.create')" type="standard">Create Clock</LinkButton>
      </div>
      <div class="flex flex-row flex-wrap justify-around">
        <!-- <Link :href="route('clocks.show', { 'clock': clock.id })" v-for="(clock, i) in clocks" :key="clock.id"
          class="mt-2 mx-1 px-3 py-2 bg-gray-200 dark:bg-gray-800 glossy rounded-full">
        <Icon icon="clock" /> {{ clock.name }}
        </Link> -->
        <div v-for="(clock, i) in clocks" :key="clock.id">
          <BasicPanel>
            <template #header>
              <span>
                <Icon icon="clock" />
                {{ clock.name }}
              </span>
            </template>
            <div class="flex flex-col gap-1 p-1 m-auto">
              <LinkButton :href="route('clocks.show', { 'clock': clock.id })">
                <span>
                  <Icon icon="clock" />
                  View
                </span>
              </LinkButton>
              <LinkButton :href="route('clocks.manage', { 'clock': clock.id })">
                <span>
                  <Icon icon="gear" />
                  Manage
                </span>
              </LinkButton>
              <BasicButton @click="confirmDeleteClock(i)" type="danger">
                <span>
                  <Icon icon="trash" />
                  Delete
                </span>
              </BasicButton>
            </div>
          </BasicPanel>
          <BasicModal ref="delModalRefs" :showCloseX="false">
            <div class="flex flex-col w-full">
              <div class="m-auto">
                Are you sure you want to delete <strong>{{ clock.name }}</strong>?
              </div>
              <div class="flex flex-row justify-around w-full">
                <BasicButton @click="deleteClock(clock, i)" type="danger">
                  <Icon icon="trash" />
                  Delete
                </BasicButton>
                <BasicButton @click="delModalRefs[i].closeModal()">
                  Cancel
                </BasicButton>
              </div>
            </div>
          </BasicModal>
        </div>
      </div>
    </div>
  </div>
</template>
