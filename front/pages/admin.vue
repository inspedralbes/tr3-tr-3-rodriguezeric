<template>
  <Header />

  <div class="cinema-home">
    <div class="links-container">
      <NuxtLink to="/crear-pelicula/" class="link">Crear Pel·lícula</NuxtLink>
      <NuxtLink to="/crear-sessio" class="link">Crear Sessió</NuxtLink>
      <NuxtLink to="/llistat-sessions" class="link">Llista de Sessions</NuxtLink>
    </div>
    <p class="total-recaudado">Recaudació total del cine: €{{ totalRecaudadoFormatted }}</p>
  </div>
</template>

<script>
import { userStore } from '~/store/store.js';
import Header from '~/components/Header.vue';

export default {
  components: {
    Header
  },
  data() {
    return {
      entrades: [],
    };
  },
  async mounted() {
    await this.fetchEntrades();
  },
  computed: {
    totalRecaudadoFormatted() {
      let total = 0;
      for (let i = 0; i < this.entrades.length; i++) {
        total += this.entrades[i].total_amount;
      }
      return total.toLocaleString('es-ES', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
      });
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
        console.log('Entrades:', data )
      } catch (error) {
        console.error("Could not fetch entrades: ", error);
      }
    }
  }
};
</script>

<style scoped>
.cinema-home {
  width: 90%;
  margin: auto;
  padding: 20px;
  font-family: 'Arial', sans-serif;
}

.links-container {
  display: flex;
  justify-content: center;
  gap: 20px;
  margin-bottom: 20px;
}

.link {
  padding: 10px 20px;
  background-color: #007bff;
  color: white;
  text-decoration: none;
  border-radius: 4px;
  transition: background-color 0.3s ease;
}

.link:hover {
  background-color: #0056b3;
}

.total-recaudado {
  text-align: center;
  font-size: 18px;
  font-weight: bold;
}

</style>
