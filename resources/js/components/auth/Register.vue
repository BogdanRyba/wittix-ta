<template>
    <div class="container">
        <h2>Register</h2>
        <div v-if="error" class="alert alert-danger">{{ error }}</div>
        <form @submit.prevent="register">
            <div class="form-group">
                <label for="username">Username</label>
                <input v-model="form.username" id="username" type="text" class="form-control" required />
            </div>
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input v-model="form.first_name" id="first_name" type="text" class="form-control" required />
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input v-model="form.last_name" id="last_name" type="text" class="form-control" required />
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input v-model="form.password" id="password" type="password" class="form-control" required />
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input v-model="form.password_confirmation" id="password_confirmation" type="password" class="form-control" required />
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</template>

<script>
import axios from '../../axios';

export default {
    data() {
        return {
            form: {
                username: '',
                first_name: '',
                last_name: '',
                password: '',
                password_confirmation: '',
            },
            error: null,
        };
    },
    methods: {
        async register() {
            try {
                await axios.post('/register', this.form);
                this.$router.push({ name: 'login' });
            } catch (error) {
                const errors = error.response.data.errors;
                this.error = errors ? Object.values(errors).join(' ') : 'An error occurred.';
            }
        },
    },
};
</script>

<style scoped>
/* Add component-specific styles here */
</style>
