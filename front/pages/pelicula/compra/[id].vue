<template>
    <div class="seat-selection">
      <h1>Selecciona tu butaca</h1>
      <div class="seat-map">
        <div v-for="(fila, indexFila) in filas" :key="indexFila" class="fila">
          <div v-for="(butaca, indexButaca) in fila" :key="indexButaca" class="butaca">
            <input type="checkbox" :id="`seat-${indexFila}-${indexButaca}`" v-model="butacaSeleccionada">
            <label :for="`seat-${indexFila}-${indexButaca}`"></label>
          </div>
        </div>
      </div>
      <button @click="confirmarSeleccion">Confirmar selección</button>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        filas: [],
        butacaSeleccionada: [],
      };
    },
    mounted() {
      // Generar las filas y butacas
      for (let fila = 1; fila <= 10; fila++) {
        const butacas = [];
        for (let butaca = 1; butaca <= 12; butaca++) {
          butacas.push({ numero: butaca });
        }
        this.filas.push(butacas);
      }
    },
    methods: {
      confirmarSeleccion() {
        const butacasSeleccionadas = [];
        this.filas.forEach((fila, indexFila) => {
          fila.forEach((butaca, indexButaca) => {
            if (this.butacaSeleccionada[indexFila][indexButaca]) {
              butacasSeleccionadas.push(`Fila ${indexFila + 1}, Butaca ${indexButaca + 1}`);
            }
          });
        });
        console.log('Butacas seleccionadas:', butacasSeleccionadas);
        // Aquí puedes enviar las butacas seleccionadas a través de una llamada API o hacer lo que necesites con ellas
      }
    }
  };
  </script>
  
  <style scoped>
  .seat-selection {
    max-width: 800px;
    margin: auto;
    padding: 20px;
    font-family: 'Arial', sans-serif;
  }
  
  .seat-map {
    display: flex;
    flex-wrap: wrap;
  }
  
  .fila {
    display: flex;
  }
  
  .butaca {
    margin: 5px;
  }
  
  input[type="checkbox"] {
    display: none;
  }
  
  label {
    display: block;
    width: 20px;
    height: 20px;
    background-color: #ccc;
    border: 1px solid #888;
    cursor: pointer;
  }
  
  input[type="checkbox"]:checked + label {
    background-color: #007bff;
  }
  </style>
  