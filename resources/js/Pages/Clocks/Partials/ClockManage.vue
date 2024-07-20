<script setup>
import VDropdown from '@/Components/VDropdown.vue'
import SlideTransition from '@/Components/SlideTransition.vue'
import BasicButton from '@/Components/BasicButton.vue'
import BasicPanel from '@/Components/BasicPanel.vue'
import Icon from '@/Components/Icon.vue'
import ClockForm from './ClockForm.vue'
import ClockAlarms from './ClockAlarms.vue'
import showNav from '@/Stores/showNav.js'
import LinkButton from '@/Components/LinkButton.vue'

const model = defineModel()
</script>

<template>
  <SlideTransition direction="up">
    <div v-if="showNav" class="fixed right-0 bottom-0">
      <VDropdown direction="left" placement="right" vertPlacement="top" subHeight="130" opacity="0.95"
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
              <LinkButton :href="route('clocks.destroy', { 'clock': model.id })" type="danger" method="delete" class="my-2"
                as="button">Delete
              </LinkButton>
            </div>
          </BasicPanel>
        </div>
      </VDropdown>
    </div>
  </SlideTransition>
</template>