<template>
  <button
    class="inline-flex items-center justify-center font-medium rounded-full text-center glossy"
    :class="`${buttonClass} ${sizeClass}`"
    :type="buttonType"
    :name="name ? name : type"
    :value="value"
    :disabled="disabled"
  >
    <slot></slot>
  </button>
</template>

<script>
export default {
  name: "basic-button",
  props: {
    type: {
      type: String,
      required: false,
      default: "standard",
      validator: (value) =>
        [
          "button",
          "save",
          "submit",
          "standard",
          "new",
          "warning",
          "danger",
          "cancel",
          "reset",
        ].indexOf(value) !== -1,
    },
    name: {
      type: String,
      required: false,
      default: "",
    },
    value: {
      required: false,
      default: true,
    },
    size: {
      type: String,
      default: "md",
      validator: (value) => ["xs", "sm", "md", "lg", "xl"].indexOf(value) !== -1,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    let typeClass = "";
    let buttonType = "";
    switch (this.type) {
      case "button":
        typeClass =
          "bg-gray-200 hover:bg-gray-300 focus:ring-gray-200 dark:bg-gray-800 dark:hover:bg-gray-600 dark:focus:ring-gray-800 border-1 border-gray-500 border-solid disabled:bg-gray-300 dark:disabled:bg-gray-600";
        break;
      case "save":
      case "submit":
        buttonType = "submit";
      case "standard":
        typeClass =
          "text-white bg-blue-700 hover:bg-blue-800 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 disabled:bg-blue-800 dark:disabled:bg-blue-700";
        break;
      case "new":
        typeClass =
          "text-white bg-green-700 hover:bg-green-800 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 disabled:bg-green-800 dark:disabled:bg-green-700";
        break;
      case "warning":
        typeClass =
          "text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-yellow-300 dark:focus:ring-yellow-900 disabled:bg-yellow-500";
        break;
      case "reset":
        buttonType = "reset";
      case "danger":
      case "cancel":
        typeClass =
          "text-white bg-red-700 hover:bg-red-800 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 disabled:bg-red-800 dark:disabled:bg-red-700";
        break;

      default:
        break;
    }
    let sizeClass = "";
    switch (this.size) {
      case "xs":
        sizeClass = "text-xs px-1 py-1";
        break;
      case "sm":
        sizeClass = "text-sm px-1 py-1";
        break;
      case "md":
        sizeClass = "text-md px-2 py-2";
        break;
      case "lg":
        sizeClass = "text-lg px-4 py-2";
        break;
      case "xl":
        sizeClass = "text-xl px-5 py-2";
        break;
      default:
        sizeClass = "text-md px-2 py-2";
        break;
    }
    return {
      visible: true,
      buttonClass: typeClass,
      sizeClass,
      buttonType: buttonType,
    };
  },
};
</script>
