<template>
  <Header />
  <div class="cinema-home">
    <div class="sesion-list">
      <nuxt-link to="/" class="back-button">Volver a la página inicial</nuxt-link>

      <div v-for="sesion in sesionesFiltradas" :key="sesion.id">
        <div class="background-overlay" :style="{ backgroundImage: 'url(' + sesion.pelicula.poster + ')' }">
          <div class="gradient-overlay"></div>
        </div>
        <h2>{{ sesion.pelicula.titol }}</h2>
        <img id="poster" :src="sesion.pelicula.poster" alt="Poster" />
      </div>
    </div>
  </div>
  <div v-for="sesion in sesionesFiltradas" :key="sesion.id">
    <div id="info">
      <h4>Día: {{ sesion.dia }}</h4>
      <h5>Hora: {{ sesion.hora }}</h5>
      <p id="sinopsis">{{ sesion.pelicula.sinopsis }}</p>
      <a @click="comprarEntrada(sesion.id)" class="buy-button">Comprar entrada</a>
    </div>
  </div>
  <Footer />

</template>

<script>
import { userStore, useMovieStore } from '~/store/store.js';

export default {
  data() {
    return {
      sesiones: [],
    };
  },
  async mounted() {
    await this.fetchSesiones();
    this.logged = userStore().logged;
    this.email = userStore().email;
    this.name = userStore().name;
    this.type = userStore().type;
  },
  computed: {
    sesionesFiltradas() {
      const idParam = parseInt(this.$route.params.id);
      return this.sesiones.filter(sesion => sesion.id === idParam);
    },
    userEmail() {
      return userStore().email;
    },
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
    },
    comprarEntrada(peliculaId) {
      // Guardar el ID de la película en el store de Pinia
      useMovieStore().setCurrentMovieId(peliculaId);
      // Redireccionar a la página de compra de entradas
      this.$router.push(`/pelicula/compra/${peliculaId}`);
    }
  }
};
</script>

<style scoped>
.cinema-home {
  position: relative;
  max-width: 80%;
  height: 50%;
  margin: auto;
  padding: 20px;
  font-family: 'Arial', sans-serif;
}

.background-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-size: cover;
  background-position: center;
  opacity: 0.2;
  z-index: -1;
}

.gradient-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(to top, var(--fons) 0%, rgba(255, 255, 255, 0) 50%);
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

.back-button {
  display: inline-block;
  padding: 8px;
  font-size: .8em;
  background-color: #eeff00;
  color: #474747;
  text-decoration: none;
  border-radius: 2px;
  margin-top: 10px;
}

.back-button:hover {
  background-color: #0056b3;
}

.buy-button {
  display: inline-block;
  padding: 10px;
  background-color: #007bff;
  color: #fff;
  text-decoration: none;
  border-radius: 5px;
  margin-top: 10px;
}

#poster {
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
  height: 411px;
}

#info {
  position: relative;
  background-color: var(--fons);
  margin: auto;
  padding: 20px;
  width: 80%;
  color: #949494;

}

#sinopsis {
  font-size: .9em;
  line-height: 1.5em;
}
</style>
