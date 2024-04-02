<template>
  <Header />
  <div class="cinema-home">
    <h1>Sesiones de Cine</h1>
    <div class="sesion-list">
      <div v-for="sesion in sesiones" :key="sesion.id">
        <nuxt-link :to="'/pelicula/' + sesion.pelicula.id">
          <div class="movie-card">
            <div class="poster"><img :src="sesion.pelicula.poster" alt="Poster" /></div>
            <h2 id="titol_cartellera">{{ sesion.pelicula.titol }}</h2>
            
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
body{
  margin: 0;
  padding: 0;
}




.cinema-home {
  text-align: center;
  width: 90%;
  margin: auto;
  padding: 20px;
  font-family: 'Arial', sans-serif;
}

.sesion-list {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr 1fr;
  grid-gap: 10px;
  margin: auto;
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
  text-align: center;
  width: 400px;
  border-radius: 8px;
  transition: transform 0.2s ease-in-out;
  background-color: #2e048f;
  margin: auto;
  padding-bottom: 8px;
}

.poster{
  margin: auto;
  border-radius: 8px;

}

.poster img{
  width: 100%;
  border-radius: 8px 8px 0 0;
}

.movie-card:hover {
  transform: scale(1.05);
}


#titol_cartellera{
  color: white;
  margin: 10px 0;
  font-size: 1.3em;
}
</style>
