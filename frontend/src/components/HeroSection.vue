<template>
    <div class="hero-section">
      <h1>Perfect <span class="highlight">Outfits for Any Forecast</span></h1>
      <p class="fs-4 m-top">The wardrobe you love, on a platform designed to help you dress smartly and quickly.</p>
      <br/><br/><br/>
      <button class="btn btn-primary rounded-pill btn-custom btn-lg" @click="goToRegister">Join Now!</button>
    </div>
  </template>
  
  <script>
    import { useRouter } from 'vue-router';

    export default {
      setup() {
        const router = useRouter();
          
        const goToRegister = () => {
          router.push('/register');
        };
    
        const goToLogin = () => {
          router.push('/login');
        };

        return {
          goToRegister,
          goToLogin
        };
      }
    }
  </script>
  <style scoped>
  .hero-section {
    color: white;
    text-align: center;
    position: relative;
    margin-top: 10vh;
    display: block;
  }

  h1 {
    font-size: 4rem;
    line-height: normal;
  }

  p {
    font-size: 24px;
    margin-left: 1em;
    margin-right: 1em;
  }

  .btn-custom {
      background-color: #23b6f5ac;
      border: none;
      color: white;
      padding: 0.65rem 1.3rem;
      font-size: 2rem;
    }

  .highlight {
    color: #23b6f5ac;
  }

  .m-top {
    margin-top: 2em;
  }
  
  @media (max-width: 1200px) {
  .hero-content h1 {
    font-size: 3.5rem; /* Medium screen font size */
  }
  
  .hero-content p {
    font-size: 1.125rem; /* Medium screen font size */
  }
  
  .hero-content button {
    padding: 0.65rem 1.3rem; /* Medium screen button size */
    font-size: 2rem; /* Medium screen button font size */
  }
}

@media (max-width: 768px) {
  .hero-content h1 {
    font-size: 3.1rem; /* Small screen font size */
  }
  
  .hero-content p {
    font-size: 1rem; /* Small screen font size */
  }
  
  .hero-content button {
    padding: 0.5rem 1rem; /* Small screen button size */
    font-size: 2rem; /* Small screen button font size */
  }
}

@media (max-width: 480px) {
  .hero-content h1 {
    font-size: 2.3rem; /* Extra small screen font size */
  }
  
  .hero-content p {
    font-size: 0.8rem; /* Extra small screen font size */
  }
  
  .hero-content button {
    padding: 0.5rem 1rem; /* Extra small screen button size */
    font-size: 1.5rem; /* Extra small screen button font size */
  }
}

  </style>
  