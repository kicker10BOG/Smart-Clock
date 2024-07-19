<template>
  <div
    class="panel flex flex-col w-full overflow-y-visible"
    :class="this.class"
    :style="style"
  >
    <div
      class="panel-header w-full text-center flex flex-row z-0"
      :class="headerClass"
      :style="headerStyle + ' align-items:center'"
    >
      <div class="flex flex-shrink">
        <svg
          v-if="isCollapsible && shouldShowToggle"
          @click="toggle(rowIndex)"
          class="h-8 w-8 my-auto mx-0 p-2 cursor-pointer"
          :class="show ? '' : '-rotate-90'"
          version="1.1"
          id="Capa_1"
          xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink"
          fill="currentColor"
          x="0px"
          y="0px"
          viewBox="0 0 20.633 20.633"
          style="enable-background: new 0 0 20.633 20.633"
          xml:space="preserve"
        >
          <g>
            <path
              d="M10.79,15.617l9.648-9.646c0.133-0.131,0.195-0.301,0.195-0.473s-0.062-0.344-0.195-0.473l-0.012-0.012
    c-0.125-0.127-0.295-0.195-0.472-0.195h-4.682c-0.18,0-0.348,0.068-0.473,0.195l-4.48,4.479l-4.48-4.479
    C5.711,4.886,5.54,4.818,5.366,4.818H0.684c-0.182,0-0.349,0.068-0.475,0.195L0.196,5.025C0.068,5.148,0,5.322,0,5.498
    c0,0.176,0.068,0.348,0.196,0.473l9.648,9.646C10.108,15.88,10.53,15.88,10.79,15.617z"
            />
          </g>
        </svg>
      </div>
      <div
        :class="
          'flex flex-grow pr-4' +
          (isCollapsible && shouldShowToggle ? '' : ' justify-center') +
          (isCollapsible && isTitleClickable ? ' cursor-pointer' : '')
        "
        :style="headerStyle"
        @click="titleClick"
      >
        {{ title }}
        <slot name="header"></slot>
      </div>
    </div>
    <div
      v-if="show"
      class="panel-body flex overflow-x-auto overflow-y-visible w-full z-10"
      :class="bodyClass"
      :style="bodyStyle"
    >
      <slot></slot>
    </div>
    <div class="panel-footer flex w-full" :class="footerClass" :style="footerStyle">
      <slot name="footer"></slot>
    </div>
  </div>
</template>

<script>
export default {
  name: "basic-panel",
  props: {
    class: {
      type: String,
      default: "rounded p-1 mx-auto my-1 shadow-sm bg-gray-200 dark:bg-gray-800",
    },
    style: {
      type: String,
      default: "",
    },
    headerClass: {
      type: String,
      default: "font-medium glossy",
    },
    headerStyle: {
      type: String,
      default: "",
    },
    bodyClass: {
      type: String,
      default: "flex-grow bg-gray-100 dark:bg-gray-900 max-w-full overflow-x-auto",
    },
    bodyStyle: {
      type: String,
      default: "",
    },
    footerClass: {
      type: String,
      default: "text-center",
    },
    footerStyle: {
      type: String,
      default: "",
    },
    collapsible: {
      default: false,
    },
    startCollapsed: {
      default: false,
    },
    titleClickable: {
      default: true,
    },
    showToggle: {
      default: true,
    },
    title: {
      default: "",
    },
  },
  data() {
    return {
      show: JSON.parse(this.collapsible) ? !JSON.parse(this.startCollapsed) : true,
      isCollapsible: JSON.parse(this.collapsible),
      isTitleClickable: JSON.parse(this.titleClickable),
      shouldShowToggle: JSON.parse(this.showToggle),
    };
  },
  methods: {
    toggle() {
      if (this.collapsible) {
        this.show = !this.show;
      }
    },
    titleClick() {
      if (this.titleClickable) {
        this.toggle();
      }
    },
  },
};
</script>
