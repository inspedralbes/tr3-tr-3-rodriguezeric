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
