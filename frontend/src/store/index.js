import { createStore } from 'vuex';


const store = createStore({
    state: {
      authToken: localStorage.getItem('authToken') || null,
    },
    mutations: {
      setAuthToken(state, token) {
        state.authToken = token;
        localStorage.setItem('authToken', token);
      },
      clearAuthToken(state) {
        state.authToken = null;
        localStorage.removeItem('authToken');
      },
    },
    actions: {
      async logout({ state, commit }) {
        if (state.authToken) {
          try {
            await axios.post('http://127.0.0.1:8000/api/logout', {}, {
              headers: {
                Authorization: `Bearer ${state.authToken}`,
              },
            });
            commit('clearAuthToken');
          } catch (error) {
            console.error('Error during logout:', error);
          }
        }
      },
    },
  });


  export default store;