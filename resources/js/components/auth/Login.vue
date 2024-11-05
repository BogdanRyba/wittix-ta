<template>
    <div class="container">
        <h2>Login</h2>
        <div v-if="error" class="alert alert-danger">{{ error }}</div>
        <form @submit.prevent="login">
            <div class="form-group">
                <label for="username">Username</label>
                <input v-model="form.username" id="username" type="text" class="form-control" required />
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input v-model="form.password" id="password" type="password" class="form-control" required />
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</template>

<script>
import axios from '../../axios.js';

export default {
    data() {
        return {
            form: {
                username: '',
                password: '',
            },
            error: null,
        };
    },
    methods: {
        async login() {
            try {
                const response = await axios.post('/login', this.form);
                localStorage.setItem('token', response.data.token);
                this.$router.push({ name: 'users' });
            } catch (error) {
                this.error = error.response.data.error || 'An error occurred.';
            }
        },
    },
};
</script>

<style scoped>
/* Add component-specific styles here */
</style>
