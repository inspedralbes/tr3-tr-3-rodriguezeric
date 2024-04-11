<template>
  <Header />
  <div class="cinema-home">
    <h1>Sesiones de Cine</h1>
    <div class="sesion-list">
      <div v-for="sesion in sesiones" :key="sesion.id" class="movie-card-container">
        <nuxt-link :to="'/pelicula/' + sesion.pelicula.id">
          <div class="movie-card">
            <div class="poster"><img :src="sesion.pelicula.poster" alt="Poster" /></div>
            <h2 class="titol-cartellera">{{ sesion.pelicula.titol }}</h2>
            <p class="showtime">{{ sesion.dia }}</p>
          </div>
        </nuxt-link>
      </div>
    </div>
  </div>
  <Footer />
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
body {
  margin: 0;
  padding: 0;

}

.cinema-home {
  font-family: 'Arial', sans-serif;
  text-align: center;
  padding: 20px;
  margin-bottom: 300px;
}

h1 {
  font-size: 2em;
  color: #fff;
  margin-bottom: 20px;
}

.sesion-list {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
  justify-content: center;
}

.movie-card-container {
  max-width: 400px;
}

.movie-card {
  background-color: #2065ce;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s ease-in-out;
  padding-bottom: 10px;
}

.poster {
  height: 300px;
  overflow: hidden;
}

.poster img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.movie-card:hover {
  transform: translateY(-5px);
}

.titol-cartellera {
  color: #ffffff;
  margin: 10px 0;
  font-size: 1.5em;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}

.showtime {
  font-size: 1.2em;
  color: #ffffff;
  margin-top: 8px;
}

@media screen and (max-width: 600px) {
  .poster {
    height: 500px; /* Ajustar la altura de la imagen del póster */
  }

  .movie-card-container {
    max-width: none;
    width: calc(80% - 10px); /* Resta el margen izquierdo y derecho */
    margin: 0 auto 20px; /* Alinea al centro y agrega margen inferior */
  }
}
</style>
