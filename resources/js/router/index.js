import { createRouter, createWebHistory } from 'vue-router';

// Import components
import Login from '../components/auth/Login.vue';
import Register from '../components/auth/Register.vue';
import UserList from '../components/users/UserList.vue';

// Define routes
const routes = [
    { path: '/login', name: 'login', component: Login, meta: { guest: true } },
    { path: '/register', name: 'register', component: Register, meta: { guest: true } },
    { path: '/users', name: 'users', component: UserList, meta: { requiresAuth: true } },
    { path: '/', redirect: '/login' },
];

// Create router instance
const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Navigation guards
router.beforeEach((to, from, next) => {
    const isAuthenticated = !!localStorage.getItem('token');

    if (to.meta.requiresAuth && !isAuthenticated) {
        next('/login');
    } else if (to.meta.guest && isAuthenticated) {
        next('/users');
    } else {
        next();
    }
});

export default router;
