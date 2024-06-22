import { createStore } from 'vuex';
import axios from '../axiosConfig';

const store = createStore({
  state: {
    authToken: localStorage.getItem('authToken') || null,
    user: JSON.parse(localStorage.getItem('user')) || null
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
    setUser(state, user) {
      state.user = user;
      localStorage.setItem('user', JSON.stringify(user));
    },
    clearUser(state) {
      state.user = null;
      localStorage.removeItem('user');
    },
    setLocation(state, location) {
      if (state.user) {
        state.user.location = location;
        localStorage.setItem('user', JSON.stringify(state.user));
      }
    }
  },
  actions: {
    async fetchUser({ commit, state }) {
      if (state.authToken) {
        try {
          const response = await axios.get('/user', {
            headers: {
              Authorization: `Bearer ${state.authToken}`
            }
          });
          const user = response.data;
          if (!state.user || !state.user.location) {
            commit('setUser', user);
          }
        } catch (error) {
          console.error('Error fetching user data:', error);
        }
      }
    },
    async fetchCoordinates({ commit, state }, city) {
      try {
        const response = await axios.get('/get-coords-for-city', {
          params: { city },
          headers: {
            Authorization: `Bearer ${state.authToken}`
          }
        });
        const { lat, lon } = response.data;
        const location = { city, lat, lon };
        commit('setLocation', location);
      } catch (error) {
        console.error('Error fetching coordinates:', error);
        if (error.response && error.response.status === 422) {
          console.error('Validation error:', error.response.data.errors);
        }
      }
    },

    async reverseGeocode({ commit, state }, { lat, lon }) {
      try {
        const response = await axios.get('/get-city-from-coords', {
          headers: {
            Authorization: `Bearer ${state.authToken}`
          },
          params: { lat, lon }
        });
        const city = response.data.city;
        const location = { city, lat, lon };
        commit('setLocation', location);
      } catch (error) {
        console.error('Error reverse geocoding:', error);
        if (error.response && error.response.status === 422) {
          console.error('Validation error:', error.response.data.errors);
        }
      }
    },
    async logout({ state, commit }) {
      if (state.authToken) {
        try {
          await axios.post('/logout', {}, {
            headers: {
              Authorization: `Bearer ${state.authToken}`,
            },
          });
          commit('clearAuthToken');
          commit('clearUser');
        } catch (error) {
          console.error('Error during logout:', error);
        }
      }
    },
  },
});

export default store;
