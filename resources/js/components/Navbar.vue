<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <router-link class="navbar-brand" to="/">
                {{ appName }}
            </router-link>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto"></ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    <li v-if="!isAuthenticated" class="nav-item">
                        <router-link class="nav-link" to="/login">Login</router-link>
                    </li>
                    <li v-if="!isAuthenticated" class="nav-item">
                        <router-link class="nav-link" to="/register">Register</router-link>
                    </li>
                    <li v-else class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            {{ userName }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#" @click.prevent="logout">
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';
import axios from '../axios';

export default {
    name: 'Navbar',
    setup() {
        const router = useRouter();
        const appName = 'Wittix';

        const isAuthenticated = computed(() => !!localStorage.getItem('token'));
        const userName = ref(localStorage.getItem('user_name') || 'User');

        const logout = async () => {
            try {
                await axios.post('/logout');
                localStorage.removeItem('token');
                localStorage.removeItem('user_name');
                router.push({name: 'login'});
            } catch (error) {
                console.error(error);
            }
        };

        return {
            appName,
            isAuthenticated,
            userName,
            logout,
        };
    },
};
</script>

<style scoped>
/* Add component-specific styles here */
</style>
