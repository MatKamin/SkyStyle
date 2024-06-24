<template>
    <section class="section">
      <div class="container">
        <h1 class="title">Admin Panel</h1>
        <button class="button is-danger custom-margin" @click="logout">Logout</button>
        <div class="box" v-if="sortedUsers.length">
          <h2 class="subtitle">Users</h2>
          <table class="table is-fullwidth">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in sortedUsers" :key="user.id">
                <td>{{ user.id }}</td>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>
                  <button class="button is-info" @click="editUser(user)">Edit</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div v-else>
          <p>No users found.</p>
        </div>
  
        <!-- Display Joke -->
        <div class="joke" v-if="joke">
          <p>{{ joke }}</p>
        </div>
  
        <!-- Edit User Modal -->
        <div class="modal" :class="{ 'is-active': showModal }">
          <div class="modal-background"></div>
          <div class="modal-card">
            <header class="modal-card-head">
              <p class="modal-card-title">Edit User</p>
              <button class="delete" aria-label="close" @click="closeModal"></button>
            </header>
            <section class="modal-card-body">
              <div class="field">
                <label class="label">Name</label>
                <div class="control">
                  <input class="input" type="text" v-model="selectedUser.name">
                </div>
              </div>
              <div class="field">
                <label class="label">Email</label>
                <div class="control">
                  <input class="input" type="email" v-model="selectedUser.email">
                </div>
              </div>
            </section>
            <footer class="modal-card-foot">
              <button class="button is-success" @click="updateUser">Save changes</button>
              <button class="button" @click="closeModal">Cancel</button>
            </footer>
          </div>
        </div>
      </div>
    </section>
  </template>
  
  <script>
  import axios from 'axios'
  
  export default {
    data() {
      return {
        users: [],
        showModal: false,
        selectedUser: {},
        originalUser: {},
        joke: ''
      }
    },
    created() {
      this.fetchUsers()
      this.fetchJoke()
    },
    computed: {
      sortedUsers() {
        return this.users.slice().sort((a, b) => a.id - b.id)
      }
    },
    methods: {
      async fetchUsers() {
        const token = localStorage.getItem('token')
        try {
          const response = await axios.get('http://127.0.0.1:8000/api/users', {
            headers: { 'Authorization': `Bearer ${token}` }
          })
          this.users = response.data
        } catch (error) {
          console.error(error)
          if (error.response && error.response.status === 401) {
            this.$router.push({ name: 'Login' })
          }
        }
      },
      async fetchJoke() {
        try {
          const response = await axios.get('https://v2.jokeapi.dev/joke/Any?type=single')
          this.joke = response.data.joke
        } catch (error) {
          console.error(error)
        }
      },
      editUser(user) {
        this.selectedUser = { ...user }
        this.originalUser = { ...user }
        this.showModal = true
      },
      async updateUser() {
        const token = localStorage.getItem('token')
        const updatedFields = {}
  
        // Compare selectedUser with originalUser to identify updated fields
        for (const key in this.selectedUser) {
          if (this.selectedUser[key] !== this.originalUser[key]) {
            updatedFields[key] = this.selectedUser[key]
          }
        }
  
        try {
          await axios.patch(`http://127.0.0.1:8000/api/users/${this.selectedUser.id}`, updatedFields, {
            headers: { 'Authorization': `Bearer ${token}` }
          })
          this.fetchUsers()
          this.closeModal()
        } catch (error) {
          console.error(error)
        }
      },
      closeModal() {
        this.showModal = false
      },
      logout() {
        localStorage.removeItem('token')
        this.$router.push({ name: 'Login' })
      }
    }
  }
  </script>
  
  <style scoped>
  .modal-card {
    width: 100%;
    max-width: 600px;
  }
  
  .custom-margin {
    margin-bottom: 25px;
  }
  
  .joke {
    text-align: center;
    margin-top: 20px;
    font-size: 1.2em;
    color: #3273dc;
  }
  </style>
  