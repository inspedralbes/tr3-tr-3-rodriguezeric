<template>
  <Header />

  <div class="pantallaCompra">
    <div class="infoCompra">
      <h1 v-if="!showConfirmation" class="infoTitulo">Asientos seleccionados:</h1>
      <div v-if="!showConfirmation" class="selectedSeatsContainer">
        <span v-for="(seat, index) in selectedSeats" :key="index" class="selectedSeat">{{ seat }}</span>
      </div>
      <!-- Muestra el importe total aquí -->
      <h2 v-if="!showConfirmation" class="infoTotal">Importe total: {{ totalAmount }}€</h2>

      <!-- Agregar campo de entrada de correo electrónico antes de confirmar la compra -->
      <div v-if="!showConfirmation" class="infoCorreo">
        <label for="email" class="infoLabel">Correu electrònic:</label>
        <input type="email" id="email" v-model="email" class="infoInput">
        <button @click="confirmPurchase" class="infoBoton">Confirmar compra</button>
      </div>
      <button @click="goBack" id="tornar">Tornar</button>

    </div>

    <div class="cinema" v-if="!showConfirmation">
      <!-- Muestra el título de la película -->
      <h3 v-if="sesion" class="cinemaTitulo">{{ sesion.pelicula.titol }}</h3>
      <Row v-for="(row, index) in rows" :key="index" :seats="row" :occupiedSeats="occupiedSeats"
        @toggle-select="toggleSelect" />
    </div>

    <div v-if="showConfirmation" class="confirmacion">
      <h3 class="confirmacionTitulo">Datos de confirmación:</h3>
      <p>Sesión: {{ entryData.sessionId }}</p>
      <p>Título de la película: {{ entryData.movieTitle }}</p>
      <p>Asientos seleccionados: {{ entryData.selectedSeats.join(', ') }}</p>
      <p>Importe total: {{ entryData.totalAmount }}€</p>
    </div>
  </div>

  <Footer />
</template>

<script>
import Row from '~/components/Row.vue';
import { useMovieStore } from '~/store/store.js';
import { userStore } from '~/store/store.js';

export default {
  components: { Row },
  data() {
    return {
      rows: this.generateSeats(10, 12),
      selectedSeats: [],
      showConfirmation: false,
      occupiedSeats: [],
      sesion: null, // Agrega una variable para almacenar la sesión actual
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
    this.idParam = userMovieStore().setCurrentMovieId(idParam);
    this.logged = userStore().logged;
    this.email = userStore().email;
    this.name = userStore().name;
    this.type = userStore().type;
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
      if (!this.email) {
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
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* Utilizar un diseño de rejilla adaptable */
  grid-gap: 20px;
  padding: 20px;
}

.infoCompra {
  width: 100%;
}

.infoTitulo {
  font-size: 24px;
  margin-bottom: 10px;
}

.selectedSeatsContainer {
  margin-bottom: 10px;
}

.selectedSeat {
  display: inline-block;
  padding: 5px 10px;
  background-color: #007bff;
  color: #fff;
  border-radius: 5px;
  margin-right: 5px;
}

.infoTotal {
  font-size: 20px;
  margin-bottom: 10px;
}

.infoBoton {
  display: inline-block;
  padding: 10px;
  font-size: 1em;
  font-weight: bolder;
  background-color: #eeff00;
  color: #474747;
  text-decoration: none;
  border-radius: 5px;
  margin-top: 10px;
}

.infoBoton:hover {
  background-color: #eaf17d;
}

.infoCorreo {
  margin-top: 20px;
}

.infoLabel {
  font-size: 18px;
}

.infoInput {
  width: calc(100% - 120px);
  padding: 8px;
  margin-right: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.cinema {
  width: 100%;
}

.cinemaTitulo {
  font-size: 24px;
  margin-bottom: 20px;
}

.confirmacion {
  width: 100%;
}

.confirmacionTitulo {
  font-size: 24px;
  margin-bottom: 20px;
}

#tornar{
  display: inline-block;
  padding: 8px;
  font-size: .8em;
  background-color: #0056b3;
  color: #ffffff;
  text-decoration: none;
  border-radius: 2px;
  margin-top: 10px;
}


</style>
