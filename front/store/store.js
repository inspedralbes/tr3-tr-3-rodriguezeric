// stores/movie.js
import { defineStore } from 'pinia';

export const useMovieStore = defineStore({
  id: 'movie',
  state: () => ({
    currentMovieId: null,
  }),
  actions: {
    setCurrentMovieId(id) {
      this.currentMovieId = id;
    },
  },
});

export const userStore = defineStore({
  id: 'user',
  state: () => ({
    email: '',
    name: '', // Añadir el campo name
    logged: false,
  }),
  actions: {
    setEmail(email) {
      this.email = email;
    },
    setName(name) {
      this.name = name; // Añadir el método setName para establecer el nombre
    },
    setLogged(logged) {
      this.logged = logged;
    },
  },
});
