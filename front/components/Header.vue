<template>
    <div>
        <header class="header">
            <div class="logo">
                <!-- Add your cinema logo here -->
                <h1>LOGO</h1>
            </div>
            <div class="actions">
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
export default {
    data() {
        return {
            showLoginForm: false,
            email: '',
            password: '',
            errorMessage: ''
        };
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
                        password: this.password
                    })
                });

                if (!response.ok) {
                    throw new Error('Credenciales inválidas');
                }

                const data = await response.json();
                console.log(data);
                console.log('Usuario autenticado:', data.user);
            } catch (error) {
                console.error('Error al iniciar sesión:', error);
                this.errorMessage = error.message || 'Error al iniciar sesión';
            }
        },


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

p {
    color: red;
}

.register-button {
    color: #007bff;
    text-decoration: none;
    margin-left: 10px;
}
</style>
