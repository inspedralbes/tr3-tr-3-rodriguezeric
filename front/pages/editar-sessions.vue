<template>
    <Header />
    <div class="cinema-home">
      <h1>Sesiones de Cine</h1>
      <div class="sesion-list">
        <div class="sesion" v-for="sesion in sesiones" :key="sesion.id">
          <div class="movie-info">{{ sesion.pelicula.titol }}</div>
          <div class="movie-info">{{ sesion.pelicula.duracio }}</div>
          <div class="movie-info">{{ sesion.dia }}</div>
          <div class="movie-info">{{ sesion.hora }}</div>
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
    grid-template-columns: repeat(4, 1fr); /* 4 columnas */
    border: 1px solid #ccc; /* Añadido borde para separar las filas */
  }
  
  .movie-info {
    padding: 10px;
    text-align: center;
  }
  </style>
  