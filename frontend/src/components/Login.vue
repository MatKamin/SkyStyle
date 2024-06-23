<template>
    <div>
      <NavigationBar></NavigationBar>
      <div class="d-flex justify-content-center align-items-center min-vh-100">
        <b-card class="w-50 p-3 card-custom text-white">
          <h1 class="text-center mb-4 login-header">Log In</h1>
          <b-form @submit.prevent="onSubmit" class="form-custom" novalidate>
            <b-form-group
              label="Email"
              label-for="email"
              class="form-group-custom"
              :state="emailState"
              invalid-feedback="Please enter a valid email."
            >
              <b-form-input
                id="email"
                v-model="form.email"
                type="email"
                placeholder="Enter email"
                required
                class="input-custom text-white"
                :state="emailState"
              ></b-form-input>
            </b-form-group>
            <b-form-group
              label="Password"
              label-for="password"
              class="form-group-custom"
              :state="passwordState"
              invalid-feedback="Password is required."
            >
              <b-form-input
                id="password"
                v-model="form.password"
                type="password"
                placeholder="Enter password"
                required
                class="input-custom text-white"
                :state="passwordState"
              ></b-form-input>
            </b-form-group>
            <b-button type="submit" variant="primary" class="mt-3 w-100">Log In</b-button>
            <div v-if="serverErrors" class="alert alert-danger mt-3">
              <ul>
                <li v-for="(error, index) in serverErrors" :key="index">{{ error }}</li>
              </ul>
            </div>
          </b-form>
          <p class="text-center mt-3">
            Don't have an account? <a href="/register" class="text-primary">Sign Up here</a>
          </p>
        </b-card>
      </div>
    </div>
  </template>
  
  <script setup>
  import { reactive, computed, ref } from 'vue';
  import NavigationBar from './NavigationBar.vue';
  import axios from '../axiosConfig';
  import { useStore } from 'vuex';
  import { useRouter } from 'vue-router';
  
  const form = reactive({
    email: '',
    password: ''
  });
  
  const serverErrors = ref(null);
  const formSubmitted = ref(false);
  
  const emailState = computed(() => {
    if (!formSubmitted.value) return null;
    if (!form.email) return false;
    return /.+@.+\..+/.test(form.email) ? true : false;
  });
  
  const passwordState = computed(() => {
    if (!formSubmitted.value) return null;
    return form.password ? true : false;
  });
  
  const store = useStore();
  const router = useRouter();
  
  const onSubmit = async () => {
    formSubmitted.value = true;
    serverErrors.value = null;
    if (emailState.value && passwordState.value) {
      try {
        const response = await axios.post('/login', {
          email: form.email,
          password: form.password
        });
        const token = response.data.token;
        store.commit('setAuthToken', token);
        console.log('Token saved in the store:', store.state.authToken);
        console.log('Form submitted:', response.data);
  
        router.push({ name: 'Dashboard' });
      } catch (error) {
        if (error.response) {
          if (error.response.status === 401) {
            serverErrors.value = [error.response.data.error || 'An error occurred. Please try again.'];
          } else if (error.response.status === 422) {
            serverErrors.value = Object.values(error.response.data.errors).flat();
          } else {
            serverErrors.value = [error.response.data.message || 'An unexpected error occurred. Please try again later.'];
          }
        } else {
          console.error('Error submitting form:', error);
          serverErrors.value = ['An unexpected error occurred. Please try again later.'];
        }
      }
    }
  };
  </script>
  
  
  
  <style scoped>
  .min-vh-100 {
    min-height: 100vh;
  }
  
  .card-custom {
    background-color: hsla(0, 0%, 100%, 0.144);
    box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
  }
  
  ::placeholder {
    color: hsla(0, 0%, 100%, 0.648);
  }
  
  .form-group-custom {
    width: 100%;
    margin-bottom: 1.5rem;
    margin-left: auto;
    margin-right: auto;
  }
  
  .login-header {
    font-size: 2.5rem;
  }
  
  @media (max-width: 1200px) {
    .w-50 {
      width: 70% !important;
    }
  
    .form-group-custom {
      width: 80%;
    }
  
    .login-header {
      font-size: 2rem;
    }
  }
  
  @media (max-width: 768px) {
    .w-50 {
      width: 90% !important;
    }
  
    .form-group-custom {
      width: 90%;
    }
  
    .login-header {
      font-size: 1.75rem;
    }
  }
  
  @media (max-width: 480px) {
    .w-50 {
      width: 95% !important;
    }
  
    .form-group-custom {
      width: 95%;
    }
  
    .login-header {
      font-size: 1.5rem;
    }
  }
  </style>
  