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
  default_bg: model.value && model.value.background == 'default',
  default_text: model.value && model.value.text == 'default',
  background: model.value ? (model.value.background == 'default' ? '#000000' : model.value.background) : '#000000',
  text: model.value ? (model.value.text == 'default' ? '#ffffff' : model.value.text) : '#ffffff',
  enabled: model.value ? Boolean(model.value.enabled) : true,
})

const submitForm = () => {
  if (form.id) {
    const url = route('colors.update', {color: form.id})
    form.put(url, {
      preserveScroll: true,
    })
  }
  else {
    const url = route('colors.store')
    form.post(url, {
      preserveScroll: true,
    })
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
        <TimeInput id="time" label="Time" v-model="form.time" :use_12hr="clock.use_12hr" class="flex-grow" />
      </div>
      <div class="flex flex-row w-72 justify-start">
        <Checkbox id="default_bg" label="Default Background" v-model="form.default_bg" />
      </div>
      <div v-if="!form.default_bg" class="flex flex-row w-72 justify-start">
        <TextInput id="background" label="Background" type="color" v-model="form.background" inputClass="w-8 p-1" />
      </div>
      <div class="flex flex-row w-72 justify-start">
        <Checkbox id="default_text" label="Default Text" v-model="form.default_text" />
      </div>
      <div v-if="!form.default_text" class="flex flex-row w-72 justify-start">
        <TextInput id="text" label="Text Color" type="color" v-model="form.text" inputClass="w-8 p-1" />
      </div>
      <div class="flex flex-row w-72 justify-start">
        <Checkbox id="enabled" label="Enable" v-model="form.enabled" />
      </div>
      <div class="flex flex-row w-72 justify-end">
        <BasicButton type="submit" @click="submitForm">Submit</BasicButton>
      </div>
    </div>
  </form>
</template>