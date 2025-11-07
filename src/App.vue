<template>
  <div>
    <h1 class="Header">Welcome to the E-Commerce Tp01</h1>

    <!-- Category Section -->
    <div class="catagory-component">
      <!-- Peach -->
      <div class="cart1">
        <div class="fruit-img peach"></div>
        <div class="text">
          <h3>Peach</h3>
          <p>14 items</p>
        </div>
      </div>

      <!-- Red Apple -->
      <div class="cart2">
        <div class="fruit-img red-apple"></div>
        <div class="text">
          <h3>Red Apple</h3>
          <p>22 items</p>
        </div>
      </div>

      <!-- Green Apple -->
      <div class="cart3">
        <div class="fruit-img green-apple"></div>
        <div class="text">
          <h3>Green Apple</h3>
          <p>18 items</p>
        </div>
      </div>

      <!-- Grapes -->
      <div class="cart4">
        <div class="fruit-img grapes"></div>
        <div class="text">
          <h3>Grapes</h3>
          <p>25 items</p>
        </div>
      </div>

      <!-- Orange -->
      <div class="cart5">
        <div class="fruit-img orange"></div>
        <div class="text">
          <h3>Orange</h3>
          <p>16 items</p>
        </div>
      </div>

      <!-- Strawberry -->
      <div class="cart6">
        <div class="fruit-img strawberry"></div>
        <div class="text">
          <h3>Strawberry</h3>
          <p>30 items</p>
        </div>
      </div>

      <!-- Banana -->
      <div class="cart7">
        <div class="fruit-img banana"></div>
        <div class="text">
          <h3>Banana</h3>
          <p>27 items</p>
        </div>
      </div>

      <!-- Watermelon -->
      <div class="cart8">
        <div class="fruit-img watermelon"></div>
        <div class="text">
          <h3>Watermelon</h3>
          <p>12 items</p>
        </div>
      </div>

      <!-- Mango -->
      <div class="cart9">
        <div class="fruit-img mango"></div>
        <div class="text">
          <h3>Mango</h3>
          <p>20 items</p>
        </div>
      </div>

      <!-- Kiwi -->
      <div class="cart10">
        <div class="fruit-img kiwi"></div>
        <div class="text">
          <h3>Kiwi</h3>
          <p>10 items</p>
        </div>
      </div>
    </div>

    <!-- Promotion Section -->
    <div class="promotion-section">
      <div class="components-promotion">
        <div class="promotion-text">
          <h2>Everyday Fresh & Clean with Our Products</h2>
          <button class="btn">Shop Now →</button>
        </div>
        <div class="promotion-image">
          <img src="@/assets/onions.png" alt="Fresh Onions" />
        </div>
      </div>

      <div class="components-promotion">
        <div class="promotion-text">
          <h2>Natural & Organic Choices</h2>
          <button class="btn">Shop now →</button>
        </div>
        <div class="promotion-image">
          <img src="@/assets/organic.jpg" alt="Organic Products" />
        </div>
      </div>

      <div class="components-promotion">
        <div class="promotion-text">
          <h2>Healthy Snacks Delivered</h2>
          <button class="btn">Shop now →</button>
        </div>
        <div class="promotion-image">
          <img src="@/assets/snacks.png" alt="Healthy Snacks" />
        </div>
      </div>
    </div>
  </div>
</template>

<style>
html,
body,
#app {
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  font-family: 'Arial', sans-serif;
}

.app-root {
  min-height: 100%;
  gap: 16px;
  background: #f5f7fa;
}

/* Header */
.Header {
  text-align: center;
  margin: 20px;
  font-size: 3em;
  color: #333;
  font-style: italic;
}

/* Category Grid */
.catagory-component {
  display: grid;
  grid-template-columns: repeat(10, 1fr);
  gap: 20px;
  padding: 20px;
  justify-items: center;
}

/* Shared card styles */
.catagory-component > div {
  width: 120px;
  height: 140px;
  border: 1px solid #333;
  border-radius: 10px;
  background-color: #fff;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-around;
  transition:
    transform 0.2s ease,
    box-shadow 0.2s ease;
}

.catagory-component > div:hover {
  transform: scale(1.05);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

/* Fruit Image Box */
.fruit-img {
  width: 100px;
  height: 100px;
  background-size: cover;
  background-position: center;
  border-radius: 10%;
}

/* Text Section */
.text {
  text-align: center;
  font-size: 12px;
}

.text h3 {
  margin: 0;
  font-weight: bold;
}

/* Specific fruit images */
.peach {
  background-image: url('@/assets/peach.jpg');
}

.red-apple {
  background-image: url('@/assets/red_apple.jpg');
}

.green-apple {
  background-image: url('@/assets/green_apple.jpg');
}

.grapes {
  background-image: url('@/assets/grapes.jpg');
}

.orange {
  background-image: url('@/assets/orange.jpg');
}

.strawberry {
  background-image: url('@/assets/strawberry.jpg');
}

.banana {
  background-image: url('@/assets/banana.jpg');
}

.watermelon {
  background-image: url('@/assets/watermelon.jpg');
}

.mango {
  background-image: url('@/assets/mango.jpg');
}

.kiwi {
  background-image: url('@/assets/kiwi.jpg');
}

/* Promotion Section */
.promotion-section {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  padding: 20px;
  background-color: #ff00bf;
  margin-top: 25px;
  height: 350px;
}

.components-promotion {
  background-color: #000;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-weight: bold;
}
.promotion-section {
  display: flex;
  gap: 20px;
  padding: 20px;
  background-color: transparent; /* remove pink background */
  margin-top: 25px;
  justify-content: center;
  flex-wrap: wrap;
}

.components-promotion {
  background-color: #f6f2e7; /* beige background */
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 30px 25px;
  width: 300px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  transition: transform 0.3s ease;
  cursor: pointer;
}

.components-promotion:hover {
  transform: scale(1.05);
  box-shadow: 0 6px 18px rgba(0,0,0,0.15);
}

.promotion-text {
  max-width: 55%;
}

.promotion-text h2 {
  font-size: 1.3rem;
  color: #333;
  line-height: 1.3;
  margin-bottom: 15px;
  font-weight: 600;
}

.btn {
  background-color: #3CB371;
  color: white;
  border: none;
  padding: 10px 18px;
  font-size: 0.9rem;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btn:hover {
  background-color: #2e8b57;
}

.promotion-image img {
  width: 100px;
  height: auto;
  border-radius: 8px;
  object-fit: cover;
}

</style>
