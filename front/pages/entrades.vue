<template>
  <Header />
  <div class="cinema-home">
    <h2>Lista de Entradas</h2>
    <div class="entrades-table">
      <div class="table-header">
        <div>Película</div>
        <div>Asientos</div>
      </div>
      <div v-if="filteredEntrades.length === 0" class="no-entrades">No hay entradas disponibles.</div>
      <div v-else class="table-body">
        <div v-for="entrada in filteredEntrades" :key="entrada.id" class="table-row">
          <div>{{ entrada.movie_title }}</div>
          <div>{{ entrada.selected_seats }}</div>
        </div>
      </div>
    </div>
  </div>
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
        const response = await fetch('http://127.0.0.1:8000/api/entradas');
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        this.entrades = data;
      } catch (error) {
        console.error("Could not fetch entrades: ", error);
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

.entrades-table {
  display: grid;
  grid-template-columns: auto auto;
  border: 1px solid #ccc;
  border-collapse: collapse;
  margin: auto;
}

.table-header {
  background-color: #f2f2f2;
  font-weight: bold;
  padding: 8px;
  border-bottom: 1px solid #ccc;
}

.table-row {
  border-bottom: 1px solid #ccc;
}

.table-row:last-child {
  border-bottom: none;
}

.table-row div {
  padding: 8px;
}

.no-entrades {
  margin-top: 20px;
}

</style>
