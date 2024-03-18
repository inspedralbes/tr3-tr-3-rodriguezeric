<template>
    <div>
        <h1>Detalles de la entrada</h1>
        <div v-if="entrada">
            <p>ID: {{ entrada.id }}</p>
            <p>Nombre: {{ entrada.nombre }}</p>
            <p>Precio: {{ entrada.precio }}</p>
            <!-- Agrega aquí más campos de la entrada que desees mostrar -->
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
            entrada: null
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
    }
};
</script>