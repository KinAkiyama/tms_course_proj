<template>
    <div class="container">
        <div class="d-flex justify-content-end align-items-center py-2 border-bottom">
            <form role="search" @submit.prevent="searchAnime">
                <input 
                    class="form-control" type="search" placeholder="Search" aria-label="Search" 
                    v-model="searchQuery" @input="searchAnime"
                />
            </form>
            <div v-if="isAuthenticated">
                <ul class="nav nav-pills fs-4">
                    <li class="nav-item m-2">
                        <router-link :to="`/user/${user.id}`"  class="text-decoration-none text-black">{{ user.username }}</router-link>
                    </li>
                </ul>
            </div>
            <div v-else>
                <ul class="nav nav-pills">
                    <li class="nav-item m-2">
                        <router-link to="/login" class="text-decoration-none text-black">Login</router-link>
                    </li>
                    <li class="nav-item m-2">
                        <router-link to="/register" class="text-decoration-none text-black">Register</router-link>
                    </li>
                </ul>
            </div>
        </div>
        <div v-if="searchResults.length" class=" container search-results-dropdown">
            <ul class="list-group">
                <li v-for="anime in searchResults" :key="anime.mal_id" class="list-group-item">
                    <router-link :to="`/anime/${anime.mal_id}`" class="text-decoration-none text-black">{{ anime.title }}</router-link>
                </li>
            </ul>
        </div>
        <div v-else-if="searchQuery.length > 0">
            <p>No results found.</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user: JSON.parse(localStorage.getItem('user')) || {},
            isAuthenticated: !!localStorage.getItem('token'),
            searchQuery: '',
            searchResults: [],
        }
    },
    methods: {
    async searchAnime() {
        console.log('Search query:', this.searchQuery);
        if (this.searchQuery.length < 3) {
        this.searchResults = [];
        return;
        }

    try {
      const response = await axios.get(`https://api.jikan.moe/v4/anime`, {
        params: {
          q: this.searchQuery,
        },
      });
      this.searchResults = response.data.data;
    } catch (error) {
      console.error('Error fetching anime: ', error);
    }
    },
    },
};
</script>