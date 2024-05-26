<template>
    <div class="feature-cards-container">
      <div class="card">
        <img src="../assets/feature1-icon.svg" alt="Feature 1">
        <h3>Feature 1 Title</h3>
        <p>Description of feature 1.</p>
      </div>
      <div class="card">
        <img src="../assets/feature2-icon.svg" alt="Feature 2">
        <h3>Feature 2 Title</h3>
        <p>Description of feature 2.</p>
      </div>
      <!-- More cards as needed -->
    </div>
  </template>
  
  <style scoped>
  .feature-cards-container {
    display: flex;
    justify-content: space-around;
    padding: 20px;
    background: #000; /* Optional */
  }
  .card {
    width: 300px;
    background: #333;
    color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  }
  .card img {
    width: 100%;
    margin-bottom: 20px;
  }
  </style>
  