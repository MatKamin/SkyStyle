<template>
    <header class="p-3 text-white">
      <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
          <!-- Logo Section -->
          <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
            <img class="logo" src="../assets/Logo.svg">
            <span class="mr-6">SkyStyle</span>
          </a>
  
          <!-- Navigation Links -->
          <ul class="nav me-auto mb-2 justify-content-center mb-md-0">
            <li><a href="#" class="nav-link px-3 text-white fs-5 d-inline-block align-middle">Features</a></li>
            <li><a href="#" class="nav-link px-3 text-white fs-5 d-inline-block align-middle">About Us</a></li>
          </ul>
  
          <!-- Right-side Icons and Buttons -->
          <div class="text-end">
            <span class="fs-5 me-4 d-inline-block align-middle">Log In</span>
            <button type="button" class="fs-5 btn btn-custom rounded-pill">Sign Up</button>
          </div>
        </div>
      </div>
    </header>
  </template>
  
  <style scoped>
    header {
      position: fixed;
      width: 100%;
      top: 0;
      left: 0;
    }
  
    a.d-flex.align-items-center {
        margin-right: 3rem;
    }

    img.logo {
      height: 60px;
      width: auto;
      vertical-align: middle;
    }

    .btn-custom {
      background-color: #00000062;
      border-color: #00000062;
      color: white;
    }
  
    .nav-link {
      padding-left: 1rem;
      padding-right: 1rem;
    }
  
    .text-end > span {
      margin-right: 2rem;
    }
  </style>
  