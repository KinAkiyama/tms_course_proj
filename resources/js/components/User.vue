<template>
    <div class="container">
        <h2>User Profile</h2>
        <div class="">
            <div class="d-flex">
                <p><strong>Username:</strong> {{ user.username }}</p>
                <button @click="logout">Logout</button>
            </div>
                <input v-model="newUsername" placeholder="Update your username" />
                <button @click="updateUser(user.id)" placeholder="{{user.id}}">Update Username</button>
        </div>
        <h3>Your Favorites</h3>
        <ul>
            <li v-for="favorite in favorites" :key="favorite.mal_id">
                {{ favorite.mal_id }}
            </li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            user: {},
            newUsername: '',
            favorites: [],
        };
    },
    mounted() {
        const userId = this.$route.params.id;
        this.fetchUser(userId);
        this.fetchFavorites(userId);
    },
    methods: {
        async logout() {
            const token = localStorage.getItem('token');
            if (!token) {
                console.error('No token found, user is not logged in.');
                return;
            }
            
            try {
                await axios.post('http://127.0.0.1:8000/api/logout', {}, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    }
                });
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                this.$router.push('/home');
            } catch (error) {
                console.error('Logout error:', error);
            }
        },
        async fetchUser(id) {
            try {
                const response = await axios.get(`/api/user/${id}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    },
                });
                this.user = response.data;
            } catch (error) {
                console.error('Error fetching user:', error);
            }
        },
        async updateUser(id) {
            // const id = this.user.id; 
            try {
                const response = await axios.put(`/api/user/${id}/update`, {
                    username: this.newUsername,
                }, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    },
                });
                localStorage.setItem('user', JSON.stringify(response.data.user));
                // this.$emit('user-updated', response.data.user);
                // this.user = response.data.user;
                this.newUsername = '';
            } catch (error) {
                console.log('Error updating user: ', error);
            }
        },
        async fetchFavorites(id) {
            try {
                const response = await axios.get(`/api/user/${id}/favorites`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    },
                });
                this.favorites = response.data;
            } catch (error) {
                console.error('Error fetching favorites:', error);
            }
        },
    },
};
</script>