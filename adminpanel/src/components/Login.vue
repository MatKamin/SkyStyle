<template>
    <section class="section">
      <div class="container">
        <div class="column is-4 is-offset-4">
          <h1 class="title">Login</h1>
          <form @submit.prevent="login">
            <div class="field">
              <label class="label">Email</label>
              <div class="control">
                <input class="input" type="email" v-model="email" required>
              </div>
            </div>
  
            <div class="field">
              <label class="label">Password</label>
              <div class="control">
                <input class="input" type="password" v-model="password" required>
              </div>
            </div>
  
            <div class="field">
              <div class="control">
                <button class="button is-primary" type="submit">Login</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
  </template>
  
  <script>
  import axios from 'axios'
  
  export default {
    data() {
      return {
        email: '',
        password: ''
      }
    },
    methods: {
      async login() {
        try {
          const response = await axios.post('http://127.0.0.1:8000/api/login', {
            email: this.email,
            password: this.password
          })
          localStorage.setItem('token', response.data.token)
          this.$router.push('/admin')
        } catch (error) {
          console.error(error)
        }
      }
    }
  }
  </script>
  