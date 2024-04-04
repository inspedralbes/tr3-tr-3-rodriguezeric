<template>
  <div class="cinema-home">
    <h1>Sesiones de Cine</h1>
    <div class="sesion-list">
      <div v-for="sesion in sesiones" :key="sesion.id">
        <nuxt-link :to="'/pelicula/' + sesion.pelicula.id">
          <div class="movie-card">
            <h2>{{ sesion.pelicula.titol }}</h2>
            <img :src="sesion.pelicula.poster" alt="Poster" />
            <p>Día: {{ sesion.dia }}</p>
            <p>Hora: {{ sesion.hora }}</p>
          </div>
        </nuxt-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      sesiones: [],
    };
  },
  async mounted() {
    await this.fetchSesiones();
  },
  methods: {
    async fetchSesiones() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/sesiones');
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        this.sesiones = data;
      } catch (error) {
        console.error("Could not fetch sessions: ", error);
      }
    }
  }
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
