<script setup>
import { computed } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import TextInput from '@/Components/TextInput.vue'
import TimeInput from '@/Components/TimeInput.vue';
import BasicButton from '@/Components/BasicButton.vue';
import Checkbox from '@/Components/Checkbox.vue';

const model = defineModel()

const emit = defineEmits(['submit', 'update:model-value'])

const page = usePage()
const clock = computed(() => page.props.clock)

const form = useForm({
  id: model.value ? model.value.id : null,
  clock_id: clock.value.id,
  name: model.value ? model.value.name : '',
  time: {
    hour: model.value ? model.value.hour : 8,
    minute: model.value ? model.value.minute : 0,
  },
  snooze_length: model.value ? model.value.snooze_length : 10,
  enabled: model.value ? Boolean(model.value.enabled) : true,
  sunday: model.value ? Boolean(model.value.sunday) : false,
  monday: model.value ? Boolean(model.value.monday) : true,
  tuesday: model.value ? Boolean(model.value.tuesday) : true,
  wednesday: model.value ? Boolean(model.value.wednesday) : true,
  thursday: model.value ? Boolean(model.value.thursday) : true,
  friday: model.value ? Boolean(model.value.friday) : true,
  saturday: model.value ? Boolean(model.value.saturday) : false,
})

const submitForm = () => {
  if (form.id) {
    const url = route('alarms.update', {alarm: form.id})
    form.put(url)
  }
  else {
    const url = route('alarms.store')
    form.post(url)
  }
  emit('submit')
}
</script>

<template>
  <form @submit.prevent="submit">
    <div class="flex flex-col w-fit m-auto">
      <div class="flex flex-row w-72 justify-start">
        <TextInput id="name" label="Name" v-model="form.name" class="flex-grow" inputClass="w-60" />
      </div>
      <div class="flex flex-row w-72 justify-start">
        <!-- <span class="font-medium py-2 mr-2">Time</span> -->
        <TimeInput id="time" label="Time" v-model="form.time" :use_12hr="clock.use_12hr" class="flex-grow" />
      </div>
      <div class="flex flex-row w-72 justify-start">
        <TextInput id="snooze_length" label="Sleep Length" v-model="form.snooze_length" type="number" step="1" min="1"
          inputClass="w-16" />
      </div>
      <div class="flex flex-row w-72 justify-start">
        <Checkbox id="enabled" label="Enable" v-model="form.enabled" />
      </div>
      <div class="flex flex-row w-72 justify-start">
        <Checkbox id="sunday" label="Sun" v-model="form.sunday" position="top" />
        <Checkbox id="monday" label="Mon" v-model="form.monday" position="top" />
        <Checkbox id="tuesday" label="Tue" v-model="form.tuesday" position="top" />
        <Checkbox id="wednesday" label="Wed" v-model="form.wednesday" position="top" />
        <Checkbox id="thursday" label="Thu" v-model="form.thursday" position="top" />
        <Checkbox id="friday" label="Fri" v-model="form.friday" position="top" />
        <Checkbox id="saturday" label="Sat" v-model="form.saturday" position="top" />
      </div>
      <div class="flex flex-row w-72 justify-end">
        <BasicButton type="submit" @click="submitForm">Submit</BasicButton>
      </div>
    </div>
  </form>
</template>