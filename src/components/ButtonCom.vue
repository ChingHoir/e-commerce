<template>
  <button
    class="shop-button"
    :style="{ backgroundColor: color }"
    @click="$emit('shop-click')"
  >
    {{ label }}
  </button>
</template>

<script lang="ts">
export default {
  name: 'ButtonCom',
  emits: ['shop-click'],
  props: {
    label: {
      type: String,
      default: 'Shop Now',
    },
    color: {
      type: String,
      default: '#4CAF50',
    },
  },
}
</script>

<style scoped>
.shop-button {
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  font-weight: 600;
  transition: background-color 0.2s ease, transform 0.2s ease;
}

.shop-button:hover {
  opacity: 0.9;
  transform: translateY(-2px);
}
</style>
