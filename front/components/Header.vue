
<template>
  <nav>
    <header class="header">
      <div class="logo">
        
        <h1><nuxt-link to="/"><span class="circle"></span>Blockbuster</nuxt-link></h1>
      </div>
      <div class="actions" v-if="!logged">
        <div class="dropdown" ref="dropdown">
          <button class="dropbtn" @click="toggleDropdown">Login</button>
          <div class="dropdown-content" :class="{ 'show-dropdown': showLoginForm }" @mousedown.stop>
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
        <nuxt-link to="/entrades" class="action-button">Entrades</nuxt-link>
        <!-- Mostrar el botón "Admin" solo si el usuario es un administrador -->
        <nuxt-link v-if="type === 'admin'" to="/admin" class="action-button">Admin</nuxt-link>
      </div>
    </header>
  </nav>
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
    document.addEventListener('mousedown', this.closeDropdown);
  },
  beforeDestroy() {
    document.removeEventListener('mousedown', this.closeDropdown);
  },
  methods: {
    toggleDropdown() {
      this.showLoginForm = !this.showLoginForm;
    },
    closeDropdown(event) {
      if (!this.$refs.dropdown.contains(event.target)) {
        this.showLoginForm = false;
      }
    },
    async login() {
      try {
        const response = await fetch('http://tr3.a22erirodnos.daw.inspedralbes.cat/laravel/public/api/login', {
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
        console.log('Admin: ', data.type);
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
        const response = await fetch('http://tr3.a22erirodnos.daw.inspedralbes.cat/laravel/public/api/logout', {
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

<style scoped>
/* Estilo base del header */
.header {
  font-family: 'Arial', sans-serif;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px;
  background-color: #00319c;
  color: #fff;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Añadido box-shadow */
  position: sticky; /* Hacer el header sticky */
  top: 0;
  z-index: 1000;
}
.circle {
  display: inline-block;
  width: 20px;
  height: 20px;
  background-color: #ffd700; /* Color amarillo */
  border-radius: 50%; /* Forma de círculo */
  margin-right: 10px; /* Espacio entre el círculo y el texto */
}
.logo h1 {
  margin: 0;
  font-size: 1.5rem;
}

.actions {
  margin-left: 20px;
}

.actions button {
  padding: 8px 16px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

/* Estilo del dropdown */
.dropdown-content {
  display: none;
  position: absolute;
  right: 1.5%;
  padding: 15px;
  border-radius: 5px;
  margin-top: 7px;
  background-color: #f9f9f9;
  color: #00319c;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
  z-index: 1;
}

.show-dropdown {
  display: block;
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
  font-size: .6em;
  text-align: center;
}

.action-button {
  padding: 8px 16px;
  background-color: #007bff;
  color

: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  text-decoration: none;
  margin-left: 10px; /* Añadido margen izquierdo */
}

/* Media queries */
@media screen and (max-width: 768px) {

  nav {
    position: relative;
  }

  .header {
    padding: 15px;
    position: sticky;
    top: 0;
    z-index: 1000;
  }

  .actions {
    margin: 10px 0;
  }

  .dropdown-content {
    right: 0;
  }

  .register-button {
    color: #007bff;
    text-decoration: none;
    font-size: .6em;
    text-align: center;
  }
}
</style>

