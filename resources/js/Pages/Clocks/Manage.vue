<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import { flash } from '@/Stores/flashMessages';
import ClockForm from './Partials/ClockForm.vue'
import ClockDisplay from './Partials/ClockDisplay.vue'
import BasicPanel from '@/Components/BasicPanel.vue';
import ClockAlarms from './Partials/ClockAlarms.vue';
import LinkButton from '@/Components/LinkButton.vue';
import Icon from '@/Components/Icon.vue';
import BasicButton from '@/Components/BasicButton.vue';
import BasicModal from '@/Components/BasicModal.vue';

const props = defineProps({
  clock: {
    required: true,
    type: Object,
  }
})
const page = usePage()
const clock = computed(() => props.clock)
const clockElement = ref(null)
const delModalRef = ref(null)

function deleteClock() {
  delModalRef.value.closeModal()
  setTimeout(() => {
    router.delete(route('clocks.destroy', { 'clock': clock.value }), {
      preserveScroll: true,
    })
  }, 300)
}

onMounted(() => {
  window.Echo.channel(`clock.${clock.value.id}`)
    .listen('ClockUpdated', (e) => {
      flash("Clock Updated").add()
      page.props.clock = e.clock
    })
    .listen('AlarmUpdated', (e) => {
      flash("Alarm Updated").add()
      for (let i = 0; i < page.props.clock.alarms.length; i++) {
        if (page.props.clock.alarms[i].id == e.alarm.id) {
          page.props.clock.alarms[i] = e.alarm
          break
        }
      }
    })
    .listen('AlarmCreated', (e) => {
      flash("Alarm Created").add()
      page.props.clock.alarms.push(e.alarm)
    })
    .listen('AlarmDeleted', (e) => {
      flash("Alarm Deleted").add()
      for (let i = 0; i < page.props.clock.alarms.length; i++) {
        if (page.props.clock.alarms[i].id == e.alarm_id) {
          page.props.clock.alarms.splice(i, 1)
          break
        }
      }
    })
    .listen('AlarmSnoozed', (e) => {
      console.log('alarm snoozed', e)
      console.log(clockElement.value)
      console.log(clockElement.value.triggeredAlarm)
      console.log(clockElement.value.$data)
      console.log(clockElement.value.$data.triggeredAlarm)
      flash("Alarm Snoozed").add()
      if (clockElement.value) {
        clockElement.value.snoozeAlarm(false, e)
      }
    })
    .listen('AlarmDismissed', (e) => {
      console.log('alarm dismissed', e)
      console.log(clockElement.value)
      console.log(clockElement.value.$triggeredAlarm)
      console.log(clockElement.value.$data)
      console.log(clockElement.value.$data.triggeredAlarm)
      flash("Alarm Dismissed").add()
      if (clockElement.value) {
        clockElement.value.dismissAlarm(false)
      }
    })
})

onUnmounted(() => {
  window.Echo.leave(`clock.${clock.value.id}`)
})
</script>

<template>
  <div class="w-full">
    <div class="container mx-auto">
      <div class="flex flex-col w-full">
        <h3>
          Manage {{ clock.name }}
        </h3>
        <div class="flex flex-row flex-wrap gap-1 py-1">
          <LinkButton :href="route('clocks.show', { 'clock': clock.id })">
            <Icon icon="clock" />
            View
          </LinkButton>
          <BasicButton @click="delModalRef.openModal()" type="danger">
            <span>
              <Icon icon="trash" />
              Delete
            </span>
          </BasicButton>
        </div>
        <BasicPanel :collapsible="true" :startCollapsed="true">
          <template #header>Configuration</template>
          <ClockForm v-model="clock" />
        </BasicPanel>
        <BasicPanel :collapsible="true" :startCollapsed="true">
          <template #header>Alarms</template>
          <ClockAlarms />
        </BasicPanel>
        <BasicPanel :collapsible="true" :startCollapsed="true" class="z-0">
          <template #header>Preview</template>
          <div class="bg-white dark:bg-black w-full overflow-x-auto"
            :style="`min-width: ${clock.width}px; height: ${clock.height}px;`">
            <div class="m-auto" :style="`width: ${clock.width}px; height: ${clock.height}px;`">
              <ClockDisplay ref="clockElement" v-model="clock" />
            </div>
          </div>
        </BasicPanel>
      </div>
    </div>
    <BasicModal ref="delModalRef" :showCloseX="false">
      <div class="flex flex-col w-full">
        <div class="m-auto">
          Are you sure you want to delete <strong>{{ clock.name }}</strong>?
        </div>
        <div class="flex flex-row justify-around w-full">
          <BasicButton @click="deleteClock(clock)" type="danger">
            <Icon icon="trash" />
            Delete
          </BasicButton>
          <BasicButton @click="delModalRef.closeModal()">
            Cancel
          </BasicButton>
        </div>
      </div>
    </BasicModal>
  </div>
</template>