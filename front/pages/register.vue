<template>
    <h2>Register</h2>
    <form @submit.prevent="register">
        <input type="text" v-model="name" placeholder="Name" required>
        <input type="email" v-model="email" placeholder="Email" required>
        <input type="password" v-model="password" placeholder="Password" required>
        <input type="password" v-model="passwordConfirmation" placeholder="Confirm Password" required>
        <button type="submit">Register</button>
    </form>


</template>

<script>
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
                console.log(data);
                console.log('Usuario registrado:', data.user);
            } catch (error) {
                console.error('Error al registrarse:', error);
                this.errorMessage = error.message || 'Error al registrarse';
            }
        }
    }
};
</script>