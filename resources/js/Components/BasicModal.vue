<script setup>
const model = defineModel({
  type: Boolean,
  default: false
})


const hasClass = (e, c) => {
  for (let i = 0; i < e.classList.length; i++) {
    if (e.classList[i] == c) {
      return true
    }
  }
  return false
}

const closeModal = (e) => {
  if (!e || (e && hasClass(e.target, "close-modal-on-click"))) {
    model.value = false
  }
}
</script>

<template>
  <transition name="fade">
    <div v-if="model" tabindex="-1"
      class="close-modal-on-click overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-40 md:inset-0 h-modal h-full bg-black bg-opacity-30 dark:bg-opacity-60 flex justify-center items-center"
      @click="closeModal($event)">
      <div class="relative p-4 m-auto w-full max-w-md lg:max-w-2xl h-auto z-50">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
          <!-- Modal header -->
          <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
            <slot name="header" />
            <button type="button"
              class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
              @click="closeModal()">
              <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                  clip-rule="evenodd"></path>
              </svg>
              <span class="sr-only">Close modal</span>
            </button>
          </div>
          <!-- Modal body -->
          <div class="p-6 space-y-6">
            <slot />
          </div>
          <!-- Modal footer -->
          <div class="flex items-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
            <slot name="footer" />
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
