<template>
    <div>
        <header class="header">
            <div class="logo">
                
                <h1><nuxt-link to="/">Home</nuxt-link></h1>
                
            </div>
            <div class="actions" v-if="!logged">
                <div class="dropdown">
                    <button class="dropbtn" @click="showLoginForm = !showLoginForm">Login</button>
                    <div class="dropdown-content" v-show="showLoginForm">
                        <h2>Login</h2>
                        <form @submit.prevent="login">
                            <input type="email" v-model="email" placeholder="Email" required>
                            <input type="password" v-model="password" placeholder="Password" required>
                            <button type="submit">Login</button>
                        </form>
                        <p v-if="errorMessage">{{ errorMessage }}</p>

                        <router-link to="/register" class="register-button">No tens compte? Registra't!</router-link>
                    </div>


                </div>

            </div>
            <div class="benvingut" v-if="logged">
                <p>Benvingut, {{ this.name }}</p>
                <button @click="logout">Logout</button>
                <nuxt-link to="/entrades">Entrades</nuxt-link>
                <nuxt-link to="/admin">Admin</nuxt-link>
            </div>
            
        </header>


        <div v-if="showRegisterForm">
            <h2>Register</h2>
            <form @submit.prevent="register">
                <input type="text" v-model="name" placeholder="Name" required>
                <input type="email" v-model="email" placeholder="Email" required>
                <input type="password" v-model="password" placeholder="Password" required>
                <input type="password" v-model="passwordConfirmation" placeholder="Confirm Password" required>
                <button type="submit">Register</button>
            </form>
            <p v-if="errorMessage">{{ errorMessage }}</p>
        </div>
    </div>
</template>

<script>
import { userStore } from '~/store/store.js';

export default {
    data() {
        return {
            showLoginForm: false,
            email: '',
            password: '',
            type: '', 
            errorMessage: '',
            logged: false,
            name: '', // Nuevo campo para almacenar el nombre del usuario
        };
    },
    mounted() {
        this.logged = userStore().logged;
        this.email = userStore().email;
        this.name = userStore().name;
        this.type = userStore().type;
    },
    

    methods: {
        async login() {
            try {
                const response = await fetch('http://127.0.0.1:8000/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        email: this.email,
                        password: this.password,
                        type: this.type,
                    })
                });

                if (!response.ok) {
                    throw new Error('Credenciales inválidas');
                }

                const data = await response.json();
                console.log('Usuario autenticado:', data);
                console.log('Admin: ',data.type);
                this.logged = true;
                userStore().setEmail(this.email); // Guardar email en el store
                userStore().setName(data.name); // Guardar name en el store
                userStore().setLogged(true); // Marcar como logueado
                this.name = userStore().name; // Actualizar el nombre del usuario
                userStore().setAdmin(data.type); // Marcar como administrador
            } catch (error) {
                console.error('Error al iniciar sesión:', error);
                this.errorMessage = error.message || 'Error al iniciar sesión';
            }
        },

        async logout() {
            try {
                const response = await fetch('http://127.0.0.1:8000/api/logout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                });
                this.logged = false;
                userStore().setEmail(''); // Limpiar email en el store
                userStore().setName(''); // Limpiar name en el store
                userStore().setLogged(false); // Marcar como no logueado
                userStore().setAdmin(''); // Marcar como no administrador
            } catch (error) {
                console.error('Error al cerrar sesión:', error);
            }
        },
    },
};
</script>

<style>
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    background-color: #bebebe;
    color: black;
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

.dropdown {
    position: relative;
    display: inline-block;
}

.dropbtn {
    padding: 8px 16px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
}

.dropdown-content h2 {
    margin-top: 0;
}

.dropdown-content form {
    margin-bottom: 0;
}

.dropdown-content p {
    margin-top: 5px;
    margin-bottom: 0;
}

.dropdown:hover .dropdown-content {
    display: block;
}

form {
    display: flex;
    flex-direction: column;
    margin-bottom: 20px;
}

input {
    margin-bottom: 10px;
    padding: 8px;
}

button {
    padding: 8px 16px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.benvingut {
    color: #007bff;
}

.register-button {
    color: #007bff;
    text-decoration: none;
    margin-left: 10px;
}
</style>