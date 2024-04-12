<template>
  <Header />
  <div class="cinema-home">
    <h2>Lista de Entradas</h2>
    <div class="entrades-table">
      <div class="table-header">
        <div class="header-item">Película</div>
        <div class="header-item">Asientos</div>
      </div>
      <div v-if="filteredEntrades.length === 0" class="no-entrades">No hay entradas disponibles.</div>
      <div v-else class="table-body">
        <div v-for="entrada in filteredEntrades" :key="entrada.id" class="table-row">
          <div class="row-item">{{ entrada.movie_title }}</div>
          <div class="row-item">{{ formatSeats(entrada.selected_seats) }}</div>
        </div>
      </div>
    </div>
  </div>
  <Footer />
</template>

<script>
import { userStore } from '~/store/store.js';

export default {
  data() {
    return {
      entrades: [],
    };
  },
  async mounted() {
    await this.fetchEntrades();
  },
  computed: {
    userEmail() {
      return userStore().email;
    },
    filteredEntrades() {
      return this.entrades.filter(entrada => entrada.email === this.userEmail);
    }
  },
  methods: {
    async fetchEntrades() {
      try {
        const response = await fetch('http://tr3.a22erirodnos.daw.inspedralbes.cat/laravel/public/api/entradas');
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        this.entrades = data;
      } catch (error) {
        console.error("Could not fetch entrades: ", error);
      }
    },
    formatSeats(seatsString) {
      // Formatear la cadena de asientos para que sea más legible
      return seatsString.split(', ').join(', ');
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

.entrades-table {
  width: 100%;
  border-collapse: collapse;
  border: 1px solid #ccc;
  border-radius: 5px;
  overflow: hidden;
}

.table-header {
  background-color: #eeff00;
  font-weight: bold;
  color: #474747;
  display: grid;
  grid-template-columns: 1fr 2fr; /* Hacer que la primera columna sea más ancha */
}

.header-item {
  padding: 10px;
  border: 1px solid #007bff;
}

.table-body {
  background-color: #003c7c;
}

.table-row {
  display: grid;
  grid-template-columns: 1fr 2fr; /* Hacer que la primera columna sea más ancha */
}

.row-item {
  padding: 10px;
  border: 1px solid #ccc;
}

.no-entrades {
  margin-top: 20px;
  color: #777;
}
</style>
