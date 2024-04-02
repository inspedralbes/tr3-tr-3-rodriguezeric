<template>
  <div class="pantallaCompra">
    <div class="infoCompra">
      <h1 v-if="!showConfirmation">Asientos seleccionados: {{ selectedSeats.join(', ') }}</h1>
      <!-- Muestra el importe total aquí -->
      <h2 v-if="!showConfirmation">Importe total: {{ totalAmount }}€</h2>
      <button @click="goBack">Volver</button>

      <!-- Agregar campo de entrada de correo electrónico antes de confirmar la compra -->
      <div v-if="!showConfirmation">
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" v-model="email">
        <button @click="confirmPurchase">Confirmar compra</button>
      </div>
    </div>




    <div class="cinema" v-if="!showConfirmation">
      <Row v-for="(row, index) in rows" :key="index" :seats="row" :occupiedSeats="occupiedSeats"
        @toggle-select="toggleSelect" />
    </div>





    <div v-if="showConfirmation">
      <h3>Datos de confirmación:</h3>
      <p>Sesión: {{ entryData.sessionId }}</p>
      <p>Título de la película: {{ entryData.movieTitle }}</p>
      <p>Asientos seleccionados: {{ entryData.selectedSeats.join(', ') }}</p>
      <p>Importe total: {{ entryData.totalAmount }}€</p>

    </div>
  </div>
</template>

<script>
import Row from '~/components/Row.vue';
import { useMovieStore } from '~/store/store.js';

export default {
  components: { Row },
  data() {
    return {
      rows: this.generateSeats(10, 12),
      selectedSeats: [],
      showConfirmation: false,
      occupiedSeats: [],
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
        totalAmount: this.totalAmount,
        email: this.email // Incluir el correo electrónico en entryData
      };
    },
    totalAmount() {
      return this.selectedSeats.length * 6;
    },
  },
  async mounted() {
    await this.fetchSesiones();
    this.setSession();
    this.fetchEntradas();
    const idParam = parseInt(this.$route.params.id);
    useMovieStore().setCurrentMovieId(idParam);
  },
  methods: {
    async fetchEntradas() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/entradas');
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const entradas = await response.json();
        this.occupiedSeats = entradas
          .filter(entrada => entrada.session_id === this.sesion.id)
          .flatMap(entrada => {
            return entrada.selected_seats.split(', ').map(seat => {
              const [row, number] = seat.split('-').map(val => parseInt(val));
              return `${row - 1}-${number - 1}`;
            });
          });
      } catch (error) {
        console.error("Could not fetch entradas: ", error);
      }
    },

    goBack() {
      this.$router.go(-1);
    },

    setSession() {
      if (this.sesionesFiltradas && this.sesionesFiltradas.length > 0) {
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
      if (seat.selected) {
        seat.selected = false;
        this.updateSelectedSeats();
        return;
      }

      if (this.isSeatOccupied(seat)) {
        alert("Este asiento está ocupado y no se puede seleccionar.");
        return;
      }

      if (this.selectedSeats.length < 10) {
        seat.selected = true;
        this.updateSelectedSeats();
      } else {
        alert("No puedes seleccionar más de 10 asientos.");
      }
    },

    isSeatOccupied(seat) {
      return this.occupiedSeats.includes(`${seat.row - 1}-${seat.number - 1}`);
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
        alert('Sesión no definida.');
        return;
      }
      // Antes de confirmar la compra, asegúrate de que se haya ingresado un correo electrónico
      if (!this.email) { // Corrige el acceso al campo de correo electrónico
        alert('Por favor, ingresa un correo electrónico.');
        return;
      }
      const entryData = {
        session_id: this.sesion.id,
        movie_title: this.sesion.pelicula.titol,
        selected_seats: this.selectedSeats.join(', '), // Convertir a cadena de texto
        total_amount: this.totalAmount,
        email: this.email // Agregar el correo electrónico al objeto entryData
      };
      fetch('http://127.0.0.1:8000/api/entrada', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(entryData)
      })
        .then(response => {
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          return response.json();
        })
        .then(data => {
          console.log('Entry data saved successfully', data);
          this.showConfirmation = true;
        })
        .catch(error => {
          console.error('Could not save entry data:', error);
          alert('Ocurrió un error al guardar los datos de la entrada. Por favor, intenta de nuevo.');
        });
    },



  },
};
</script>


<style scoped>
.pantallaCompra {
  margin-top: 30px;
  display: grid;
  grid-template-columns: .5fr 1fr;
  grid-gap: 20px;
}

.infoCompra {
  width: 30%;
  margin: auto;
}

.cinema {
  margin: auto;
  width: 60%;
}
</style>