<script setup>
import { computed, onMounted, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import BasicModal from '@/Components/BasicModal.vue'
import BasicButton from '@/Components/BasicButton.vue';
import AlarmForm from './AlarmForm.vue';
import Icon from '@/Components/Icon.vue';
import LinkButton from '@/Components/LinkButton.vue';

const openNewModal = ref(false)
const openEditModal = ref()
const page = usePage()
const clock = computed(() => (page.props.clock))

const days = ref(['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'])
const daysShort = ref(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'])

onMounted(() => {
  openEditModal.value = []
  clock.value.alarms.forEach(alarm => {
    openEditModal.value[alarm.id] = false
  });
})
</script>

<template>
  <div class="flex flex-col w-full py-1">
    <div class="flex flex-row justify-around w-full my-1">
      <BasicButton class="mx-auto" type="new" @click="openNewModal = true" size="sm">Add New Alarm</BasicButton>
    </div>
    <div v-if="openEditModal" v-for="(alarm, i) in clock.alarms" :key="alarm.id"
      class="flex flex-col bg-gray-200 dark:bg-gray-800 rounded-lg mx-2 my-1 p-2">
      <div class="flex flex-row justify-start">
        <span class="mr-1">
          {{ alarm.name }}
        </span>
        <BasicButton type="standard" size="sm" class="ml-1" @click="openEditModal[alarm.id] = true">
          <Icon icon="edit" size="sm" />
        </BasicButton>
      </div>
      <div class="flex flex-row justify-start">
        <div class="mr-l">
          <LinkButton v-if="alarm.enabled" method="put" :href="route('alarms.disable', { alarm: alarm.id })" as="button"
            type="good" size="sm" preserve-scroll>
            <Icon icon="check" size="sm" />
          </LinkButton>
          <LinkButton v-else method="put" :href="route('alarms.enable', { alarm: alarm.id })" as="button" type="bad"
            size="sm" preserve-scroll>
            <Icon icon="x" size="sm" />
          </LinkButton>
        </div>
        <div class="mx-1">
          <span v-if="clock.use_12hr">
            {{ alarm.hour % 12 == 0 ? '12' : (alarm.hour % 12) }}:{{ alarm.minute < 10 ? `0${alarm.minute}` :
              alarm.minute }} {{ alarm.hour > 11 ? 'PM' : 'AM' }}
          </span>
          <span v-else>
            {{ alarm.hour }}:{{ alarm.minute < 10 ? `0${alarm.minute}` : alarm.minute }} </span>
        </div>
        <div class="ml-1">
          <LinkButton method="delete" :href="route('alarms.destroy', { alarm: alarm.id })" as="button" type="danger"
            size="sm" preserve-scroll>
            <Icon icon="trash" size="sm" />
          </LinkButton>
        </div>
      </div>
      <div class="flex flex-row justify-start">
        <div v-for="(day, j) in days">
          <LinkButton v-if="alarm[day]" method="put" :href="route('alarms.disableDay', { alarm: alarm.id, day: day })"
            as="button" type="good" size="sm" preserve-scroll>
            {{ daysShort[j] }}
          </LinkButton>
          <LinkButton v-else method="put" :href="route('alarms.enableDay', { alarm: alarm.id, day: day })" as="button"
            type="bad" size="sm" preserve-scroll>
            {{ daysShort[j] }}
          </LinkButton>
        </div>
      </div>
      <BasicModal v-model="openEditModal[alarm.id]">
        <template #header>
          <div class="my-auto">
            <h3>
              Edit Alarm
            </h3>
          </div>
        </template>
        <AlarmForm v-model="clock.alarms[i]" @submit="openEditModal[alarm.id] = false" />
      </BasicModal>
    </div>
  </div>

  <BasicModal v-model="openNewModal">
    <template #header>
      <div class="my-auto">
        <h3>
          Add New Alarm
        </h3>
      </div>
    </template>
    <AlarmForm @submit="openNewModal = false" />
  </BasicModal>
</template>