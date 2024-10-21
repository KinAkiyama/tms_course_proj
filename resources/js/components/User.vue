<template>
    <div class="container py-3">
        <h2 class="text-center py-3">User Profile</h2>
        <div class="">
            <div class="d-flex justify-content-between align-items-center my-3">
                <strong>Username:</strong>
                <button @click="logout" class="btn logout-btn border-danger fw-semibold">Logout</button>
            </div>
            <div class="username-update d-flex mb-3">
                <input v-model="newUsername" placeholder="Update your username" class="form-control"/>
                <button class="btn show-more-btn fw-semibold ms-2" @click="updateUser(user.id)">Update Username</button>
            </div>
        </div>
        <h3>Your Favorites</h3>
        <ul class="titels-list row p-0">
            <li v-for="favorite in favorites" :key="favorite.mal_id" class="titel-item col-2 col-mb-2 px-3 pb-4">
                <router-link :to="`/titel/${favorite.mal_id}`" class="titel-item-container" @mouseenter="handleMouseEnter(favorite)" @mouseleave="handleMouseLeave">
                    <div class="titel-item-imageSection">
                        <img :src="favorite.images.jpg.image_url" alt="title image" />
                        <div class="titel-item-overlay" v-if="hoveredTitleId === favorite.mal_id">
                            <div class="titel-item-info">
                                <div class="score-info">{{ favorite.score }}</div>
                                <div class="">{{ favorite.type }} {{ favorite.year }}</div>
                                <div class="">{{ favorite.themes.name }}</div>
                            </div>
                            <button class="btn" @click="addToFavorites(favorite)">Watch later</button>
                        </div>
                    </div>
                    <div class="titel-item-textSection mt-2">
                        {{ favorite.title_english }}
                    </div>
                </router-link>
            </li>
        </ul>
        <button class="btn w-100 bg-danger fw-semibold" @click="deleteUser(user.id)">Delete Account</button>
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
      hoveredTitleId: null,
    };
  },
  mounted() {
    this.fetchFavorites();
    const userId = this.$route.params.id;
    this.fetchUser(userId);
    this.fetchFavorites(userId);
  },
  methods: {
    async fetchFavorites() {
      try {
        const response = await axios.get('/api/favorites', {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        });
        this.favorites = response.data;
      } catch (error) {
        console.error('Error fetching favorites: ', error);
      }
    },
    handleMouseEnter(favorite) {
      this.hoveredTitleId = favorite.mal_id;
    },
    handleMouseLeave() {
      this.hoveredTitleId = null;
    },
    async deleteUser(id) {
        try {
            await axios.delete(`/api/user/${id}`, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`,
                }
            });
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            this.$router.push('/home');
            alert('User deleted successfully');
        } catch (error) {
            console.error('Delete user error:', error);
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
        try {
            const response = await axios.put(`/api/user/${id}/update`, {
                username: this.newUsername,
            }, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`,
                },
            });
            localStorage.setItem('user', JSON.stringify(response.data.user));
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