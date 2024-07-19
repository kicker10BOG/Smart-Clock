<script setup>
import VDropdown from '@/Components/VDropdown.vue'
import SlideTransition from '@/Components/SlideTransition.vue';
import BasicButton from '@/Components/BasicButton.vue'
import Icon from '@/Components/Icon.vue';
import ClockForm from './ClockForm.vue';
import showNav from '@/Stores/showNav.js'

const model = defineModel()
</script>

<template>
  <SlideTransition direction="up">
    <div v-if="showNav" class="absolute right-1 bottom-1">
      <VDropdown direction="left" placement="right" vertPlacement="top" subHeight="130" opacity="0.95"
        :clickAwayToClose="false" :makeFixed="true" fixedBottom="85" fixedRight="12">
        <template #button>
          <div class="fixed bottom-10 right-2">
          <BasicButton type="button">
            <Icon icon="gear" />
          </BasicButton>
          </div>
        </template>
        <div class="w-72">
          <ClockForm v-model="model" />
        </div>
      </VDropdown>
    </div>
  </SlideTransition>
</template>