<template>
    <Header />
    <div class="register-container">
      <h2>Register</h2>
      <form @submit.prevent="register" class="register-form">
        <input type="text" v-model="name" placeholder="Name" required>
        <input type="email" v-model="email" placeholder="Email" required>
        <input type="password" v-model="password" placeholder="Password" required>
        <input type="password" v-model="passwordConfirmation" placeholder="Confirm Password" required>
        <button type="submit" class="register-button">Register</button>
      </form>
      <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
    </div>
    <Footer />
  </template>
  
  <script>
  import { userStore } from '~/store/store.js';

  export default {
    data() {
      return {
        name: '',
        email: '',
        password: '',
        passwordConfirmation: '',
        errorMessage: ''
      };
    },
    mounted() {
        this.logged = userStore().logged;
        this.email = userStore().email;
        this.name = userStore().name;
        this.type = userStore().type;
    },
    methods: {
      async register() {
        try {
          const response = await fetch('http://127.0.0.1:8000/api/register', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({
              name: this.name,
              email: this.email,
              password: this.password,
              password_confirmation: this.passwordConfirmation
            })
          });
  
          if (!response.ok) {
            throw new Error('Error al registrarse');
          }
  
          const data = await response.json();
          console.log('Usuario registrado:', data.user);
          userStore().setEmail(this.email); // Guardar email en el store
                userStore().setName(data.name); // Guardar name en el store
                userStore().setLogged(true); // Marcar como logueado
                this.name = userStore().name; // Actualizar el nombre del usuario
                userStore().setAdmin(data.type);
          // Redireccionar al home después del registro
          this.$router.push('/');
        } catch (error) {
          console.error('Error al registrarse:', error);
          this.errorMessage = error.message || 'Error al registrarse';
        }
      }
    }
  };
  </script>
  
  <style scoped>
  .register-container {
    max-width: 400px;
    margin: auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }
  
  .register-form {
    display: flex;
    flex-direction: column;
  }
  
  input {
    margin-bottom: 10px;
    padding: 8px;
  }
  
  button.register-button {
    padding: 8px 16px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .error-message {
    color: red;
  }
  </style>
  