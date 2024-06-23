
<template>
    <div v-if="show" class="invalid-feedback d-block">
      <slot></slot>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      show: {
        type: Boolean,
        default: false
      }
    }
  };
  </script>
  
  <style scoped>
  .invalid-feedback {
    color: #dc3545;
  }
  </style>
  