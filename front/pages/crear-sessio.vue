<template>
    <div>
      <h1>Crear Sesión</h1>
      <form @submit.prevent="submitForm">
        <label for="dia">Día:</label>
        <input type="date" id="dia" v-model="dia" required>
  
        <label for="hora">Hora:</label>
        <input type="time" id="hora" v-model="hora" required>
  
        <label for="pelicula_id">Película:</label>
        <select v-model="pelicula_id" required>
          <option v-for="pelicula in peliculas" :key="pelicula.id" :value="pelicula.id">{{ pelicula.titol }}</option>
        </select>
  
        <button type="submit">Guardar</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        dia: '',
        hora: '',
        pelicula_id: null,
        peliculas: []
      };
    },
    mounted() {
      this.fetchPeliculas();
    },
    methods: {
      fetchPeliculas() {
        fetch('http://127.0.0.1:8000/api/peliculas')
          .then(response => {
            if (!response.ok) {
              throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
          })
          .then(data => {
            this.peliculas = data;
          })
          .catch(error => {
            console.error('Could not fetch movies:', error);
            // Manejar el error, como mostrar un mensaje de error al usuario
          });
      },
      submitForm() {
        const sessionData = {
          dia: this.dia,
          hora: this.hora,
          pelicula_id: this.pelicula_id
        };
  
        fetch('http://127.0.0.1:8000/api/crear-sessio', {
          method: 'POST',
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
          console.log('Session saved successfully', data);
          // Aquí puedes realizar cualquier acción adicional, como redireccionar a otra página
        })
        .catch(error => {
          console.error('Could not save session data:', error);
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

  option {
    color: #000; /* Cambia el color a tu preferencia */
  }
  </style>
  