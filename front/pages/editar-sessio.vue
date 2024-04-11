<template>
    <div>
      <h1>Editar Sesión</h1>
      <form @submit.prevent="submitForm">
        <label for="pelicula">Película:</label>
        <select id="pelicula" v-model="pelicula.id" required>
          <option v-for="movie in peliculas" :key="movie.id" :value="movie.id">{{ movie.titol }}</option>
        </select>
  
        <label for="hora">Hora:</label>
        <input type="time" id="hora" v-model="hora" required>
  
        <label for="dia">Día:</label>
        <input type="date" id="dia" v-model="dia" required>
  
        <button type="submit">Guardar</button>
        <button type="button" @click="eliminarSesion">Eliminar Sesión</button> <!-- Botón para eliminar la sesión -->
      </form>
    </div>
  </template>
  
  <script>
  import { userStore } from '~/store/store.js';
  
  export default {
    data() {
      return {
        pelicula: {
          id: null,
        },
        hora: '',
        dia: '',
        sesionId: '',
        sesiones: [],
        peliculas: [],
      };
    },
    async mounted() {
      this.sesionId = userStore().sessionId;
      await this.fetchSesiones();
      await this.fetchPeliculas();
      this.loadSessionData();
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
      async fetchPeliculas() {
        try {
          const response = await fetch('http://127.0.0.1:8000/api/peliculas');
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          this.peliculas = await response.json();
        } catch (error) {
          console.error("Could not fetch movies: ", error);
        }
      },
      loadSessionData() {
        const sesion = this.sesiones.find(sesion => sesion.id === this.sesionId);
        if (sesion) {
          this.pelicula.id = sesion.pelicula.id;
          this.hora = sesion.hora;
          this.dia = sesion.dia;
        } else {
          console.error(`Session with id ${this.sesionId} not found.`);
        }
      },
      submitForm() {
        const sessionData = {
          hora: this.hora,
          dia: this.dia,
          pelicula_id: this.pelicula.id,
          id: this.sesionId
        };
  
        fetch(`http://127.0.0.1:8000/api/modificar-sessio/${this.sesionId}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(sessionData)
        })
        .then(response => {
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          return response.json();
        })
        .then(data => {
          console.log('Session updated successfully', data);
          // Aquí puedes realizar cualquier acción adicional, como redireccionar a otra página
        })
        .catch(error => {
          console.error('Could not update session:', error);
          // Aquí puedes manejar el error, como mostrar un mensaje de error al usuario
        });
      },
      eliminarSesion() {
  fetch(`http://127.0.0.1:8000/api/eliminar-sessio/${this.sesionId}`, {
    method: 'DELETE'
  })
  .then(response => {
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    console.log('Session deleted successfully');
    // Redirigir a la página anterior
    this.$router.go(-1);
  })
  .catch(error => {
    console.error('Could not delete session:', error);
    // Aquí puedes manejar el error, como mostrar un mensaje de error al usuario
  });
}
    }
  };
  </script>
  
  <style scoped>
  label {
    display: block;
    margin-top: 1rem;
  }
  </style>