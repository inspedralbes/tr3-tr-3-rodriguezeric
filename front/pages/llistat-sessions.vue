<template>
  <div>
    <h1>Sesiones de Cine</h1>
    <div class="sesion-list">
      <div v-for="sesion in sesiones" :key="sesion.id" >
        <NuxtLink :to="'/editar-sessio' " @click="saveSessionId(sesion.id)" class="sesion">
          <div class="movie-info">{{ sesion.pelicula.titol }}</div>
          <div class="movie-info">{{ sesion.pelicula.duracio }}</div>
          <div class="movie-info">{{ sesion.dia }}</div>
          <div class="movie-info">{{ sesion.hora }}</div>
          <div class="movie-info">Recaudación total: {{ formatTotalRecaudado(sesion) }}</div>
          <div class="movie-info">Entradas de la sesión:</div>
          <div v-for="entrada in getEntradasPorSesion(sesion)" :key="entrada.id">
            <div class="movie-info">{{ entrada }}</div>
          </div>
        </NuxtLink>
      </div>
    </div>
  </div>
</template>

<script>
import { userStore } from '~/store/store.js';

export default {
  data() {
    return {
      sesiones: [],
      entradas: [],
    };
  },
  async mounted() {
    await this.fetchSesiones();
    await this.fetchEntradas();
  },
  methods: {
    async fetchSesiones() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/sesiones');
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        this.sesiones = await response.json();
      } catch (error) {
        console.error("Could not fetch sessions: ", error);
      }
    },
    async fetchEntradas() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/entradas');
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        this.entradas = await response.json();
      } catch (error) {
        console.error("Could not fetch entradas: ", error);
      }
    },
    getEntradasPorSesion(sesion) {
      return this.entradas.filter(entrada => entrada.sesion_id === sesion.id);
    },
    saveSessionId(sessionId) {
      userStore().setCurrentSessionId(sessionId);
    },
    calcularTotalRecaudado(sesion) {
      const entradasSesion = this.getEntradasPorSesion(sesion);
      return entradasSesion.reduce((total, entrada) => total + entrada.total_amount, 0);
    },
    formatTotalRecaudado(sesion) {
      const totalRecaudado = this.calcularTotalRecaudado(sesion);
      return totalRecaudado.toLocaleString('es-ES', { style: 'currency', currency: 'EUR' });
    }
  }
};
</script>

<style scoped>
.cinema-home {
  text-align: center;
  width: 90%;
  margin: auto;
  padding: 20px;
  font-family: 'Arial', sans-serif;
}

.sesion-list {
  display: grid;
  grid-gap: 10px;
  margin: auto;
}

.sesion {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  /* 4 columnas */
  border: 1px solid #ccc;
  /* Añadido borde para separar las filas */
  text-decoration: none;
  /* Elimina el subrayado del enlace */
  color: #333;
  /* Color del texto del enlace */
}

.sesion:hover {
  background-color: #f0f0f0;
  /* Cambia el color de fondo al pasar el ratón sobre el enlace */
}

.movie-info {
  padding: 10px;
  text-align: center;
}
</style>
