<template>
  <div class="cinema">
    <Row v-for="(row, index) in rows" :key="index" :seats="row" @toggle-select="toggleSelect" />
  </div>

  <h1>Asientos seleccionados: {{ selectedSeats.join(', ') }}</h1>
  <!-- Muestra el importe total aquí -->
  <h2>Importe total: {{ totalAmount }}€</h2>

  <button @click="confirmPurchase">Confirmar compra</button>
</template>


<script>
import Row from '~/components/Row.vue';
import { usePurchaseStore } from '~/store/store.js';


export default {
  components: { Row },
  data() {
    return {
      rows: this.generateSeats(10, 12),
      selectedSeats: [], // Mantiene un registro de los asientos seleccionados
    };
  },
  computed: {
    sesionesFiltradas() {
      const idParam = parseInt(this.$route.params.id);
      return this.sesiones.filter(sesion => sesion.id === idParam);
    },
    entryData() {
      return {
        sessionId: this.sesion.id,
        movieTitle: this.sesion.pelicula.titol,
        selectedSeats: this.selectedSeats,
        totalAmount: this.totalAmount
      };
    },
    totalAmount() {
      // Calcula el importe total multiplicando el número de asientos seleccionados por 6€
      return this.selectedSeats.length * 6;
    },
  },
  async mounted() {
    await this.fetchSesiones();
    this.setSession();
  },
  methods: {
    setSession() {
      if (this.sesionesFiltradas && this.sesionesFiltradas.length > 0) {
        // Asumiendo que `sesionesFiltradas` siempre contiene al menos un elemento y es el correcto
        this.sesion = this.sesionesFiltradas[0];
      }
    },
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
    generateSeats(rows, seatsPerRow) {
      let allRows = [];
      for (let i = 0; i < rows; i++) {
        let row = [];
        for (let j = 0; j < seatsPerRow; j++) {
          row.push({ id: `${i}-${j}`, number: j + 1, occupied: false, selected: false });
        }
        allRows.push(row);
      }
      return allRows;
    },
    toggleSelect(seat) {
      // Verifica si el asiento ya está seleccionado; si lo está, permite deseleccionarlo
      if (seat.selected) {
        seat.selected = false;
        this.updateSelectedSeats();
        return;
      }
      // Verifica el límite de asientos seleccionados antes de seleccionar otro
      if (this.selectedSeats.length < 10) {
        seat.selected = true;
        this.updateSelectedSeats();
      } else {
        // Opcional: Muestra un mensaje de alerta si se intenta seleccionar más de 10 asientos
        alert("No puedes seleccionar más de 10 asientos.");
      }
    },
    updateSelectedSeats() {
      let newSelectedSeats = [];
      this.rows.forEach((row, rowIndex) => {
        row.forEach((seat) => {
          if (seat.selected && !seat.occupied) {
            newSelectedSeats.push(`${rowIndex + 1}-${seat.number}`);
          }
        });
      });
      this.selectedSeats = newSelectedSeats;
    },

    confirmPurchase() {
      if (!this.sesion) {
        console.error('Sesión no definida.');
        return;
      }

      const entryData = {
        sessionId: this.sesion.id,
        movieTitle: this.sesion.pelicula.titol,
        selectedSeats: this.selectedSeats,
        totalAmount: this.totalAmount
      };
      
      // Aquí es donde guardamos los datos en Pinia
      const purchaseStore = usePurchaseStore();
      purchaseStore.saveEntryData(entryData);
      
      console.log('Confirmar compra:', entryData);
      
      // Aquí podrías redirigir al usuario a otra página si es necesario
    },
  },



};
</script>
