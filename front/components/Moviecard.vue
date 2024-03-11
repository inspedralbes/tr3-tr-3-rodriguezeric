<template>
    <div class="movie-card">
      <h2>{{ movie.title }}</h2>
      <p>{{ movie.description }}</p>
      <p>{{ movie.showtime }}</p>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      movie: {
        type: Object,
        required: true,
      },
    },
  };
  </script>
  
  <style scoped>
  .movie-card {
    border: 1px solid #ccc;
    padding: 15px;
    margin: 10px;
  }
  </style>
  ./Moviecard.vue