<template>
    <div>
        <header class="header">
            <div class="logo">
                <!-- Add your cinema logo here -->
                <h1></h1>
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
    </header>
</template>

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
</style>