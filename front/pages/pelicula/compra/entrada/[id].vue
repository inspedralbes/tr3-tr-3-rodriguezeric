<template>
    <div>
      <h1>Detalles de la entrada</h1>
      <div v-if="entrada">
        <p>ID: {{ entrada.id }}</p>
        <p>Nombre: {{ entrada.nombre }}</p>
        <p>Precio: {{ entrada.precio }}</p>
        <!-- Agrega más campos de la entrada que desees mostrar -->
  
        <!-- Campo de entrada de correo electrónico -->
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" v-model="correoElectronico">
  
        <!-- Botón para enviar la entrada al correo -->
        <button @click="enviarEntradaPorCorreo">Enviar al correo</button>
      </div>
      <div v-else>
        <p>Cargando...</p>
      </div>
    </div>
  </template>
  

<script>
export default {
    data() {
    return {
      entrada: null,
      correoElectronico: '' // Nuevo campo para almacenar el correo electrónico
    };
  },
    mounted() {
        // Obtén la ID de la entrada desde los parámetros de la URL
        const id = this.$route.params.id;

        // Realiza el fetch a la tabla "entrades" usando la ID
        fetch(`/api/entrades/${id}`)
            .then(response => response.json())
            .then(data => {
                this.entrada = data;
            })
            .catch(error => {
                console.error(error);
            });
    },
    enviarEntradaPorCorreo() {
      // Realiza una solicitud POST al servidor Laravel para enviar la entrada al correo
      fetch(`/entradas/${id}/enviar-correo`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          entrada: this.entrada,
          correoElectronico: this.correoElectronico
        })
      })
        .then(response => {
          if (!response.ok) {
            throw new Error('Error al enviar la entrada por correo.');
          }
          // Manejar la respuesta del servidor, si es necesario
          return response.json();
        })
        .then(data => {
          console.log('Entrada enviada por correo:', data);
          // Aquí puedes mostrar un mensaje de éxito al usuario, o redirigirlo a otra página, etc.
        })
        .catch(error => {
          console.error('Error al enviar la entrada por correo:', error);
          // Aquí puedes mostrar un mensaje de error al usuario, si es necesario
        });
    }
  
};
</script>