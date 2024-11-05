<template>
    <div class="container">
        <h2>User List</h2>
        <div v-if="message" class="alert alert-success">{{ message }}</div>
        <form @submit.prevent="searchUsers" class="form-inline mb-3">
            <input v-model="search" type="text" class="form-control mr-2" placeholder="Search by name or username" />
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users.data" :key="user.id">
                <td>{{ user.id }}</td>
                <td>{{ user.username }}</td>
                <td>{{ user.first_name }}</td>
                <td>{{ user.last_name }}</td>
                <td>
                    <button @click="deleteUser(user.id)" class="btn btn-danger btn-sm">Delete</button>
                </td>
            </tr>
            <tr v-if="!users.data.length">
                <td colspan="5">No users found.</td>
            </tr>
            </tbody>
        </table>
        <!-- Pagination -->
        <nav v-if="users.meta.last_page > 1">
            <ul class="pagination">
                <li class="page-item" :class="{ disabled: users.meta.current_page === 1 }">
                    <a class="page-link" href="#" @click.prevent="changePage(users.meta.current_page - 1)">Previous</a>
                </li>
                <li class="page-item" :class="{ active: page === users.meta.current_page }" v-for="page in users.meta.last_page" :key="page">
                    <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
                </li>
                <li class="page-item" :class="{ disabled: users.meta.current_page === users.meta.last_page }">
                    <a class="page-link" href="#" @click.prevent="changePage(users.meta.current_page + 1)">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
import axios from '../../axios';

export default {
    data() {
        return {
            users: {
                data: [],
                meta: {},
            },
            search: '',
            message: null,
        };
    },
    created() {
        this.fetchUsers();
    },
    methods: {
        async fetchUsers(page = 1) {
            try {
                const response = await axios.get('/users', {
                    params: {
                        search: this.search,
                        page,
                    },
                });
                this.users.data = response.data.data;
                this.users.meta = response.data.meta;
            } catch (error) {
                console.error(error);
            }
        },
        async searchUsers() {
            await this.fetchUsers();
        },
        async deleteUser(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                try {
                    await axios.delete(`/users/${id}`);
                    this.message = 'User deletion scheduled.';
                    this.fetchUsers();
                } catch (error) {
                    console.error(error);
                }
            }
        },
        changePage(page) {
            if (page >= 1 && page <= this.users.meta.last_page) {
                this.fetchUsers(page);
            }
        },
    },
};
</script>

<style scoped>
/* Add component-specific styles here */
</style>
