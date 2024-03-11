<template>
  <Header />
  <div class="cinema-home">
    <div class="movie-of-the-day">
      <h1>{{ todayMovie.title }}</h1>
      <p class="showtime">{{ todayMovie.showtime }}</p>
      <p class="description">{{ todayMovie.description }}</p>
    </div>

    <div class="upcoming-sessions">
      <h2>Próximas Sesiones</h2>
      <div v-for="movie in upcomingMovies" :key="movie.id">
        <movie-card :movie="movie" />
      </div>
    </div>
  </div>
</template>

<script>
import MovieCard from '/components/MovieCard.vue';
import Header from '/components/Header.vue';

export default {
  components: {
    MovieCard,
    Header,
  },
  data() {
    return {
      todayMovie: {}, // Se inicializa vacío
      upcomingMovies: [], // Se inicializa vacío
    };
  },
  mounted() {
    this.fetchMovies();
  },
  methods: {
    async fetchMovies() {
  try {
    const response = await fetch('http://127.0.0.1:8000/api/peliculas');
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    const data = await response.json();
    console.log(data); // Corregido para mostrar los datos en consola correctamente
    // Asigna los datos a todayMovie y upcomingMovies según la estructura de tu respuesta de API
    // Por ejemplo, si 'data' ya es el array que necesitas:
    // this.todayMovie = data[0]; // Asumiendo que el primero es la película del día
    // this.upcomingMovies = data.slice(1); // El resto son las próximas sesiones
  } catch (error) {
    console.error("Could not fetch movies: ", error);
  }
}

  },
};
</script>


<style scoped>
.cinema-home {
  max-width: 800px;
  margin: auto;
  padding: 20px;
  font-family: 'Arial', sans-serif;
}

.movie-of-the-day {
  background-color: #f8f8f8;
  padding: 20px;
  border-radius: 8px;
  margin-bottom: 20px;
}

.showtime {
  font-size: 1.2em;
  color: #333;
  margin-bottom: 10px;
}

.description {
  color: #555;
}

.upcoming-sessions h2 {
  font-size: 1.5em;
  color: #333;
  margin-bottom: 10px;
}

/* Apply styles to MovieCard component */
.movie-card {
  border: 1px solid #ccc;
  padding: 15px;
  margin: 10px;
  border-radius: 8px;
  transition: transform 0.2s ease-in-out;
}

.movie-card:hover {
  transform: scale(1.05);
}
</style>
