<template>
  <div>
    <div class="cinema" v-if="!showConfirmation">
      <Row v-for="(row, index) in rows" :key="index" :seats="row" :occupiedSeats="occupiedSeats"
        @toggle-select="toggleSelect" />
    </div>

    <h1 v-if="!showConfirmation">Asientos seleccionados: {{ selectedSeats.join(', ') }}</h1>
    <!-- Muestra el importe total aquí -->
    <h2 v-if="!showConfirmation">Importe total: {{ totalAmount }}€</h2>
    <button @click="goBack">Volver</button>

    <button v-if="!showConfirmation" @click="confirmPurchase">Confirmar compra</button>
    
    <div v-if="showConfirmation">
      <h3>Datos de confirmación:</h3>
      <p>Sesión: {{ entryData.sessionId }}</p>
      <p>Título de la película: {{ entryData.movieTitle }}</p>
      <p>Asientos seleccionados: {{ entryData.selectedSeats.join(', ') }}</p>
      <p>Importe total: {{ entryData.totalAmount }}€</p>
    
    <!-- Campo de entrada de correo electrónico -->
    <label for="email">Correo electrónico:</label>
    <input type="email" id="email" v-model="correoElectronico">

    <!-- Botón para enviar la entrada al correo -->
    <button @click="enviarEntradaPorCorreo">Enviar al correo</button>
    
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
      occupiedSeats: [], // Array para almacenar los asientos ocupados
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
      return this.selectedSeats.length * 6;
    },
  },
  async mounted() {
    await this.fetchSesiones();
    this.setSession();
    this.fetchEntradas(); // Llama a la función para obtener las entradas al cargar la página
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
          .filter(entrada => entrada.session_id === this.sesion.id) // Filtra las entradas por la sesión actual
          .flatMap(entrada => {
            // Ajustar los asientos ocupados restando 1 al número de fila y asiento
            return entrada.selected_seats.split(', ').map(seat => {
              const [row, number] = seat.split('-').map(val => parseInt(val));
              return `${row - 1}-${number - 1}`;
            });
          });

        console.log('Asientos ocupados:', this.occupiedSeats);
      } catch (error) {
        console.error("Could not fetch entradas: ", error);
      }
    },

    goBack() {
      // Usa this.$router.go(-1) para volver a la página anterior
      this.$router.go(-1);
    },

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

      // Verifica si el asiento está ocupado; si lo está, no permite seleccionarlo
      if (this.isSeatOccupied(seat)) {
        alert("Este asiento está ocupado y no se puede seleccionar.");
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

    isSeatOccupied(seat) {
      // Verifica si el asiento está en la lista de asientos ocupados
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
      const entryData = {
        session_id: this.sesion.id,
        movie_title: this.sesion.pelicula.titol,
        selected_seats: this.selectedSeats.join(', '), // Convertir a cadena de texto
        total_amount: this.totalAmount
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
    enviarEntradaPorCorreo() {
  // Verifica que se haya ingresado un correo electrónico
  if (!this.correoElectronico) {
    alert('Por favor, ingresa un correo electrónico.');
    return;
  }

  // Crea un objeto con los datos de la entrada y el correo electrónico
  const datosCorreo = {
    entryData: this.entryData,
    correoElectronico: this.correoElectronico
  };

  // Realiza una solicitud POST al servidor Laravel para enviar los datos por correo
  fetch(`http://127.0.0.1:8000/api/entradas/1/enviar-correo`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(datosCorreo)
  })
    .then(response => {
      if (!response.ok) {
        throw new Error('Error al enviar los datos por correo.');
      }
      // Manejar la respuesta del servidor, si es necesario
      return response.json();
    })
    .then(data => {
      console.log('Datos enviados por correo:', data);
      // Aquí puedes mostrar un mensaje de éxito al usuario, o redirigirlo a otra página, etc.
      alert('Los datos se han enviado por correo electrónico con éxito.');
    })
    .catch(error => {
      console.error('Error al enviar los datos por correo:', error);
      // Aquí puedes mostrar un mensaje de error al usuario, si es necesario
      alert('Ocurrió un error al enviar los datos por correo. Por favor, intenta de nuevo.');
    });
},
  },
};
</script>
