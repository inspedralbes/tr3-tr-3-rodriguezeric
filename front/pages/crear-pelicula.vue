<template>
    <div>
      <h1>Crear Pel·lícula</h1>
      <form @submit.prevent="submitForm">
        <label for="titol">Título:</label>
        <input type="text" id="titol" v-model="titol" required>
  
        <label for="duracio">Duración:</label>
        <input type="number" id="duracio" v-model="duracio" required>
  
        <label for="poster">Poster:</label>
        <input type="text" id="poster" v-model="poster" required>
  
        <label for="sinopsis">Sinopsis:</label>
        <textarea id="sinopsis" v-model="sinopsis" required></textarea>
  
        <button type="submit">Guardar</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        id: Math.floor(Math.random() * 1000),
        titol: '',
        duracio: null,
        poster: '',
        sinopsis: ''
      };
    },
    methods: {
      submitForm() {
        const peliculaData = {
            id: this.id,
          titol: this.titol,
          duracio: this.duracio,
          poster: this.poster,
          sinopsis: this.sinopsis
        };
  
        fetch('http://127.0.0.1:8000/api/crear-pelicula', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(peliculaData)
        })
        .then(response => {
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          return response.json();
        })
        .then(data => {
          console.log('Pelicula saved successfully', data);
          // Aquí puedes realizar cualquier acción adicional, como redireccionar a otra página
        })
        .catch(error => {
          console.error('Could not save pelicula data:', error);
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