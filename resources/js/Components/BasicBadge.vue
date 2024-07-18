<template>
  <span
    class="inline-flex items-center justify-center px-2 py-1 my-1 font-bold leading-none rounded-full glossy"
    :class="`${this.class} ${textClass}`"
    :title="title"
  >
    <slot></slot>
  </span>
</template>

<script>
export default {
  name: "basic-badge",
  props: {
    type: {
      type: String,
      required: false,
      default: "standard",
      validator: (value) =>
        ["standard", "good", "success", "warning", "danger"].indexOf(value) !== -1,
    },
    textSize: {
      type: String,
      default: "sm",
      validator: (value) => ["xs", "sm", "md", "lg", "xl"].indexOf(value) !== -1,
    },
    title: {
      default: "",
    },
  },
  data() {
    return {
      textClass: "",
      class: "",
    };
  },
  mounted() {
    switch (this.textSize) {
      case "xs":
        this.textClass = "text-xs";
        break;
      case "sm":
        this.textClass = "text-sm";
        break;
      case "md":
        this.textClass = "text-md";
        break;
      case "lg":
        this.textClass = "text-lg";
        break;
      case "xl":
        this.textClass = "text-xl";
        break;
      default:
        this.textClass = "text-sm";
        break;
    }
    switch (this.type) {
      case "standard":
        this.class = "bg-gray-300 dark:bg-gray-600";
        break;
      case "good":
      case "success":
        this.class = "text-black bg-green-600";
        break;
      case "warning":
        this.class = "text-black bg-yellow-400";
        break;
      case "danger":
        this.class = "text-white bg-red-700";
        break;
      default:
        break;
    }
  },
};
</script>
