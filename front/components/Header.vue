<template>
    <header class="header">
        <div class="logo">
            <!-- Add your cinema logo here -->
            <h1>LOGO</h1>
        </div>
        <div class="actions">
            <button class="login-register-button" @click="toggleLoginForm">Login/Register</button>
        </div>

        <!-- Agregar el formulario de inicio de sesión aquí -->
        <div v-if="showLoginForm" class="login-form">
            <input type="text" placeholder="Correo electrónico" v-model="email">
            <input type="password" placeholder="Contraseña" v-model="password">
            <button @click="login">Iniciar sesión</button>
        </div>
    </header>
</template>

<script>
export default {
    data() {
        return {
            showLoginForm: false,
            email: '',
            password: ''
        };
    },
    methods: {
        toggleLoginForm() {
            this.showLoginForm = !this.showLoginForm;
        },
        login() {
            // Aquí puedes agregar la lógica para enviar los datos de inicio de sesión al servidor
            // Puedes utilizar Axios u otra librería para hacer la solicitud HTTP
            console.log('Correo electrónico:', this.email);
            console.log('Contraseña:', this.password);
            
            // Después de enviar los datos, podrías redirigir al usuario a otra página o realizar alguna otra acción
        }
    }
};
</script>

<style>
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    background-color: #f2f2f2;
}

.logo img {
    width: 100px;
    height: auto;
}

.actions button {
    padding: 8px 16px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

/* Estilos del formulario de inicio de sesión */
.login-form {
    position: absolute;
    top: 50px; /* Ajusta según sea necesario */
    right: 10px; /* Ajusta según sea necesario */
    background-color: #fff;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
.login-form input {
    display: block;
    margin-bottom: 10px;
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
.login-form button {
    padding: 8px 16px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
</style>
