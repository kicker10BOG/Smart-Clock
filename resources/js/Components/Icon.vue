<script setup>
import { ref } from 'vue'
const props = defineProps({
  icon: {
    default: "x",
  },
  iconClass: {
    default: "inline-block",
  },
  iconSize: {
    default: "md",
  },
  extraClass: {
    default: "",
  },
})
const iconSizeClasses = ref('w-6 h-6')
if (props.iconSize == 'sm') {
  iconSizeClasses.value = 'w-4 h-4'
}
else if (props.iconSize == 'lg') {
  iconSizeClasses.value = 'w-8 h-8'
}
</script>

<template>
  <svg v-if="icon == 'x'" :class="`${iconSizeClasses} inline-block m-auto ${iconClass} ${extraClass}`" viewBox="5 5 14 14" fill="currentColor"
    xmlns="http://www.w3.org/2000/svg">
    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
    <g id="SVGRepo_iconCarrier">
      <path
        d="M6.99486 7.00636C6.60433 7.39689 6.60433 8.03005 6.99486 8.42058L10.58 12.0057L6.99486 15.5909C6.60433 15.9814 6.60433 16.6146 6.99486 17.0051C7.38538 17.3956 8.01855 17.3956 8.40907 17.0051L11.9942 13.4199L15.5794 17.0051C15.9699 17.3956 16.6031 17.3956 16.9936 17.0051C17.3841 16.6146 17.3841 15.9814 16.9936 15.5909L13.4084 12.0057L16.9936 8.42059C17.3841 8.03007 17.3841 7.3969 16.9936 7.00638C16.603 6.61585 15.9699 6.61585 15.5794 7.00638L11.9942 10.5915L8.40907 7.00636C8.01855 6.61584 7.38538 6.61584 6.99486 7.00636Z">
      </path>
    </g>
  </svg>
  <svg v-else-if="icon == 'check'" :class="`${iconSizeClasses} inline-block m-auto ${iconClass} ${extraClass}`" fill="currentColor"
    viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
    <g id="SVGRepo_iconCarrier">
      <path
        d="M28.998 8.531l-2.134-2.134c-0.394-0.393-1.030-0.393-1.423 0l-12.795 12.795-6.086-6.13c-0.393-0.393-1.029-0.393-1.423 0l-2.134 2.134c-0.393 0.394-0.393 1.030 0 1.423l8.924 8.984c0.393 0.393 1.030 0.393 1.423 0l15.648-15.649c0.393-0.392 0.393-1.030 0-1.423z">
      </path>
    </g>
  </svg>
  <svg v-if="icon == 'arrow'" :class="`${iconSizeClasses} inline-block m-auto ${iconClass} ${extraClass}`"
    fill="currentColor" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20.633 20.633">
    <g>
      <path d="M10.79,15.617l9.648-9.646c0.133-0.131,0.195-0.301,0.195-0.473s-0.062-0.344-0.195-0.473l-0.012-0.012
    c-0.125-0.127-0.295-0.195-0.472-0.195h-4.682c-0.18,0-0.348,0.068-0.473,0.195l-4.48,4.479l-4.48-4.479
    C5.711,4.886,5.54,4.818,5.366,4.818H0.684c-0.182,0-0.349,0.068-0.475,0.195L0.196,5.025C0.068,5.148,0,5.322,0,5.498
    c0,0.176,0.068,0.348,0.196,0.473l9.648,9.646C10.108,15.88,10.53,15.88,10.79,15.617z" />
    </g>
  </svg>
  <svg v-if="icon == 'plane'" :class="`${iconSizeClasses} m-auto inline-block ${iconClass} ${extraClass}`"
    fill="currentColor" stroke="currentColor" version="1.1" viewBox="-1 -1 25 25" xmlns="http://www.w3.org/2000/svg">
    <g id="SVGRepo_bgCarrier" stroke-width="1px"></g>
    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
    <g id="SVGRepo_iconCarrier">
      <path fill-rule="evenodd"
        d="M21,2 C20.3597108,2 19.7456461,2.25435391 19.2928932,2.70710678 L16.4003571,5.59964294 C16.1519767,5.84802329 15.7914897,5.94787242 15.4507147,5.86267866 L4,3 L2.98105825,4.01894175 C2.59053396,4.40946604 2.59053396,5.04263102 2.98105825,5.43315531 C3.05705957,5.50915663 3.14481653,5.57240826 3.24095144,5.62047572 L12,10 L8,14 L3.61803399,14 C3.23926193,14 2.89299881,14.2140024 2.7236068,14.5527864 L2,16 L2,16 L6,18 L6,18 L8,22 L9.4472136,21.2763932 C9.78599762,21.1070012 10,20.7607381 10,20.381966 L10,16 L14,12 L18.3795243,20.7590486 C18.6265135,21.2530271 19.2271866,21.4532514 19.7211651,21.2062622 C19.8173,21.1581947 19.9050569,21.0949431 19.9810583,21.0189417 L21,20 L18.1373213,8.54928535 C18.0521276,8.20851033 18.1519767,7.84802329 18.4003571,7.59964294 L21.2928932,4.70710678 C21.7456461,4.25435391 22,3.64028925 22,3 C22,2.44771525 21.5522847,2 21,2 Z">
      </path>
    </g>
  </svg>
  <svg v-if="icon == 'sun'" :class="`${iconSizeClasses} inline-block m-auto ${iconClass} ${extraClass}`" version="1.1"
    id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
    viewBox="0 0 207.628 207.628" fill="currentColor" style="enable-background: new 0 0 207.628 207.628"
    xml:space="preserve">
    <circle cx="103.814" cy="103.814" r="45.868" />
    <path d="M103.814,157.183c-29.427,0-53.368-23.941-53.368-53.368s23.941-53.368,53.368-53.368s53.368,23.941,53.368,53.368
	S133.241,157.183,103.814,157.183z M103.814,65.446c-21.156,0-38.368,17.212-38.368,38.368s17.212,38.368,38.368,38.368
	s38.368-17.212,38.368-38.368S124.97,65.446,103.814,65.446z" />
    <path d="M103.814,39.385c-4.142,0-7.5-3.358-7.5-7.5V7.5c0-4.142,3.358-7.5,7.5-7.5s7.5,3.358,7.5,7.5v24.385
	C111.314,36.027,107.956,39.385,103.814,39.385z" />
    <path d="M103.814,207.628c-4.142,0-7.5-3.358-7.5-7.5v-24.385c0-4.142,3.358-7.5,7.5-7.5s7.5,3.358,7.5,7.5v24.385
	C111.314,204.271,107.956,207.628,103.814,207.628z" />
    <path d="M200.128,111.314h-24.385c-4.142,0-7.5-3.358-7.5-7.5s3.358-7.5,7.5-7.5h24.385c4.142,0,7.5,3.358,7.5,7.5
	S204.271,111.314,200.128,111.314z" />
    <path d="M31.885,111.314H7.5c-4.142,0-7.5-3.358-7.5-7.5s3.358-7.5,7.5-7.5h24.385c4.142,0,7.5,3.358,7.5,7.5
	S36.027,111.314,31.885,111.314z" />
    <path
      d="M154.676,60.452c-1.919,0-3.839-0.732-5.303-2.197c-2.929-2.929-2.929-7.678,0-10.606l17.243-17.242
	c2.929-2.929,7.678-2.93,10.606,0c2.929,2.929,2.929,7.678,0,10.606l-17.243,17.242C158.515,59.72,156.595,60.452,154.676,60.452z" />
    <path d="M35.709,179.419c-1.919,0-3.839-0.732-5.303-2.197c-2.929-2.929-2.929-7.678,0-10.606l17.243-17.243
	c2.929-2.929,7.678-2.929,10.606,0c2.929,2.929,2.929,7.678,0,10.606l-17.243,17.243C39.548,178.687,37.629,179.419,35.709,179.419z
	" />
    <path d="M171.918,179.419c-1.919,0-3.839-0.732-5.303-2.197l-17.243-17.243c-2.929-2.929-2.929-7.678,0-10.606
	c2.929-2.929,7.678-2.929,10.606,0l17.243,17.243c2.929,2.929,2.929,7.678,0,10.606
	C175.757,178.687,173.838,179.419,171.918,179.419z" />
    <path
      d="M52.952,60.452c-1.919,0-3.839-0.732-5.303-2.197L30.406,41.013c-2.929-2.929-2.929-7.677,0-10.606
	c2.929-2.929,7.678-2.93,10.606,0l17.243,17.242c2.929,2.929,2.929,7.677,0,10.606C56.791,59.72,54.872,60.452,52.952,60.452z" />
  </svg>
  <svg v-if="icon == 'moon'" :class="`${iconSizeClasses} inline-block m-auto ${iconClass} ${extraClass}`" version="1.1"
    id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
    viewBox="0 0 512 512" fill="currentColor" enable-background="new 0 0 64 64" xml:space="preserve">
    <path d="M301.425,256c0-98.198,71.422-179.704,165.15-195.435C421.963,22.807,364.312,0,301.425,0c-141.16,0-256,114.84-256,256
            s114.84,256,256,256c62.887,0,120.538-22.807,165.15-60.565C372.848,435.704,301.425,354.2,301.425,256z" />
  </svg>


  <svg v-if="icon == 'menu'" :class="`${iconSizeClasses} inline-block m-auto ${iconClass} ${extraClass}`" viewBox="0 0 24 24"
    fill="none" xmlns="http://www.w3.org/2000/svg">
    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
    <g id="SVGRepo_iconCarrier">
      <path d="M4 6H20M4 12H20M4 18H20" stroke="currentColor" stroke-width="2" stroke-linecap="round"
        stroke-linejoin="round"></path>
    </g>
  </svg>



</template>
