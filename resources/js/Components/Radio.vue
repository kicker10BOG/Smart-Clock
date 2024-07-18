<template>
  <div class="flex flex-row items-center my-1 w-fit">
    <input
      :id="id"
      :name="name"
      type="radio"
      :value="value"
      :disabled="disabled"
      v-model="modelValue"
      @update:modelValue="valueChanged()"
      class="text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
      :class="sizeClass"
    />
    <label
      :for="id"
      class="ml-2 font-medium text-gray-900 dark:text-gray-300"
      :class="textClass"
    >
      {{ label }}
      <slot />
    </label>
  </div>
</template>

<script>
export default {
  name: "checkbox",
  props: {
    modelValue: {},
    id: {
      required: true,
    },
    name: {
      required: true,
    },
    value: {
      default: 1,
    },
    label: {
      default: "",
    },
    disabled: {
      default: false,
    },
    size: {
      type: String,
      default: "md",
      validator: (value) => ["xs", "sm", "md", "lg", "xl"].indexOf(value) !== -1,
    },
  },
  data() {
    let sizeClass = "";
    let textClass = "";
    switch (this.size) {
      case "xs":
        sizeClass = "w-2 h-2";
        textClass = "text-xs";
        break;
      case "sm":
        sizeClass = "w-3 h-3";
        textClass = "text-sm";
        break;
      case "md":
        sizeClass = "w-4 h-4";
        textClass = "text-md";
        break;
      case "lg":
        sizeClass = "w-5 h-5";
        textClass = "text-lg";
        break;
      case "xl":
        sizeClass = "w-6 h-6";
        textClass = "text-xl";
        break;
      default:
        textClass = "text-md";
        break;
    }
    return {
      sizeClass,
      textClass,
    };
  },
  methods: {
    valueChanged() {
      this.$emit("update:modelValue", this.modelValue);
    },
  },
};
</script>
