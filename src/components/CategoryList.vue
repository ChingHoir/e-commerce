<template>
  <div class="category-list">
    <div
      v-for="(cat, index) in categories"
      :key="index"
      class="category-item"
      :style="{ backgroundColor: cat.bg }"
    >
      <img :src="cat.image" :alt="cat.name" />
      <h4>{{ cat.name }}</h4>
      <p>{{ cat.count }} items</p>
    </div>
  </div>
</template>

<script lang="ts">
import type { PropType } from 'vue'

type Category = {
  name: string
  image: string
  count: number
  bg: string
}

export default {
  name: 'CategoryList',
  props: {
    categories: {
      type: Array as PropType<Category[]>,
      required: true,
    },
  },
}
</script>

<style scoped>
.category-list {
  display: flex;
  flex-wrap: nowrap;            /* single row */
  overflow-x: auto;             /* horizontal scroll */
  width: 100%;                  /* full width of container */
  gap: 12px;                    /* space between cards */
  padding: 10px 0;
  scroll-behavior: smooth;      /* smooth scroll effect */
  scrollbar-width: thin;        /* Firefox scrollbar style */
}

/* For Chrome/Edge scrollbar */
.category-list::-webkit-scrollbar {
  height: 8px;
}
.category-list::-webkit-scrollbar-thumb {
  background-color: #ccc;
  border-radius: 4px;
}

.category-item {
  flex: 0 0 130px;              /* fixed width for each card */
  height: 140px;
  border-radius: 14px;
  padding: 10px;
  text-align: center;
  color: #333;
  background-color: #fff;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  transition: transform 0.25s ease;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.category-item:hover {
  transform: translateY(-4px);
}

.category-item img {
  width: 60px;
  height: 60px;
  object-fit: contain;
}

.category-item h4 {
  margin: 8px 0 2px;
  font-size: 0.9rem;
  font-weight: 600;
}

.category-item p {
  color: #666;
  font-size: 0.8rem;
}
</style>
