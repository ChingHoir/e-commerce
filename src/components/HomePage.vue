<template>
  <div class="home-page">
    <!-- Categories Section -->
    <h2 class="section-title">Categories</h2>
    <div class="category-list">
      <div
        v-for="category in categories"
        :key="category.id"
        class="category-item"
        :style="{ backgroundColor: category.color }"
      >
        <img :src="category.image" :alt="category.name" />
        <h4>{{ category.name }}</h4>
        <p>{{ category.productCount }} items</p>
      </div>
    </div>

    <!-- Promotions Section -->
    <h2 class="section-title">Promotions</h2>
    <div class="promo-list">
      <PromoCards
        v-for="promo in promotions"
        :key="promo.id"
        :promotion="promo"
        :style="{ backgroundColor: promo.color }"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import axios from 'axios'
import PromoCards from './PromoCards.vue'

type Category = {
  id: number
  name: string
  productCount: number
  color: string
  image: string
}

type Promotion = {
  id: number
  title: string
  buttonColor: string
  color:string
  image: string
}

export default defineComponent({
  name: 'HomePage',
  components: { PromoCards },
  data() {
    return {
      categories: [] as Category[],
      promotions: [] as Promotion[],
    }
  },
  methods: {
    async loadCategories() {
      try {
        const res = await axios.get<Category[]>('http://localhost:3000/api/categories')
        this.categories = res.data.map(c => ({
          ...c,
          color: c.color.replace(/"/g, '').trim().startsWith('#')
            ? c.color.replace(/"/g, '').trim()
            : '#' + c.color.replace(/"/g, '').trim(),
          image: `http://localhost:3000/${c.image.replace(/\\/g, '/')}`
        }))
      } catch (err) {
        console.error('Error fetching categories:', err)
      }
    },
    async loadPromotions() {
      try {
        const res = await axios.get<Promotion[]>('http://localhost:3000/api/promotions')
        this.promotions = res.data.map(p =>({
          ...p,
          buttonColor: p.buttonColor.replace(/"/g, '').trim().startsWith('#')
            ? p.buttonColor.replace(/"/g, '').trim()
            : '#' + p.buttonColor.replace(/"/g, '').trim(),
          color: p.color.replace(/"/g, '').trim().startsWith('#')
            ? p.color.replace(/"/g, '').trim()
            : '#' + p.color.replace(/"/g, '').trim(),
          image: `http://localhost:3000/${p.image.replace(/\\/g, '/')}`
        }))
      } catch (err) {
        console.error('Error fetching promotions:', err)
      }
    },
  },
  mounted() {
    this.loadCategories()
    this.loadPromotions()
  },
})
</script>

<style scoped>
.home-page {
  padding: 40px;
}

.section-title {
  font-size: 1.75rem;
  font-weight: 700;
  margin-bottom: 20px;
}

/* Category List */
.category-list {
  display: flex;
  flex-wrap: nowrap;
  overflow-x: auto;
  gap: 12px;
  padding-bottom: 10px;
  width: 100%;
  scroll-behavior: smooth;
}

.category-list::-webkit-scrollbar {
  height: 6px;
}

.category-list::-webkit-scrollbar-thumb {
  background-color: #ccc;
  border-radius: 4px;
}

.category-item {
  flex: 0 0 130px;
  height: 140px;
  border-radius: 14px;
  padding: 10px;
  text-align: center;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  transition: transform 0.25s ease;
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
  font-size: 0.8rem;
  color: #666;
}

/* Promo List */
.promo-list {
  display: flex;
  flex-wrap: nowrap;
  overflow-x: auto;
  gap: 20px;
  width: 100%;
  padding-bottom: 10px;
  scroll-behavior: smooth;
}

.promo-list::-webkit-scrollbar {
  height: 8px;
}

.promo-list::-webkit-scrollbar-thumb {
  background-color: #ccc;
  border-radius: 4px;
}
</style>
