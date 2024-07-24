<script setup>
import { router } from '@inertiajs/vue3'
import VDropdown from '@/Components/VDropdown.vue'
import SlideTransition from '@/Components/SlideTransition.vue'
import BasicButton from '@/Components/BasicButton.vue'
import BasicPanel from '@/Components/BasicPanel.vue'
import Icon from '@/Components/Icon.vue'
import ClockForm from './ClockForm.vue'
import ClockAlarms from './ClockAlarms.vue'
import showNav from '@/Stores/showNav.js'

const model = defineModel()
defineEmits(['update:model-value'])

const deleteClock = () => {
  router.delete(route('clocks.destroy', { 'clock': model.value.id }))
}
</script>

<template>
  <SlideTransition direction="up">
    <div v-if="showNav" class="fixed right-0 bottom-0">
      <VDropdown direction="left" placement="right" vertPlacement="above" subHeight="130" :opacity="0.97"
        :clickAwayToClose="false" :makeFixed="true" fixedBottom="85" fixedRight="12">
        <template #button>
          <div class="fixed bottom-10 right-2">
            <BasicButton type="button">
              <Icon icon="gear" />
            </BasicButton>
          </div>
        </template>
        <div class="w-fit max-w-xs md:max-w-md lg:max-w-lg xl:max-w-xl">
          <BasicPanel :collapsible="true" :startCollapsed="true">
            <template #header>Configuration</template>
            <ClockForm v-model="model" />
          </BasicPanel>
          <BasicPanel :collapsible="true" :startCollapsed="true">
            <template #header>Alarms</template>
            <ClockAlarms />
          </BasicPanel>
          <BasicPanel :collapsible="true" :startCollapsed="true">
            <template #header>delete</template>
            <div class="flex flex-row justify-center w-full">
              <BasicButton @click="deleteClock" type="danger" size="sm" class="my-2">
                Delete
              </BasicButton>
            </div>
          </BasicPanel>
        </div>
      </VDropdown>
    </div>
  </SlideTransition>
</template>