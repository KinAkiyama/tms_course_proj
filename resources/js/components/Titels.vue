<template>
    <div class="container py-3">
        <ul class="titels-list row p-0">
            <li v-for="titel in titels" :key="titel.mal_id" class="titel-item col-2 col-mb-2 px-3 pb-4">
                <router-link :to="`/titel/${titel.mal_id}`" class="titel-item-container" @mouseenter="handleMouseEnter(titel)" @mouseleave="handleMouseLeave">
                    <div class="titel-item-imageSection">
                        <img :src="titel.images.jpg.image_url" alt="title image" />
                        <div class="titel-item-overlay" v-if="hoveredTitleId === titel.mal_id">
                            <div class="titel-item-info">
                                <div class="score-info">{{ titel.score }}</div>
                                <div class="">{{ titel.type }} {{ titel.year }}</div>
                                <div class="">{{ titel.themes.name }}</div>
                            </div>
                            <button class="btn" @click="addToFavorites(titel)">Watch later</button>
                        </div>
                    </div>
                    <div class="titel-item-textSection mt-2">
                        {{ titel.title_english }}
                    </div>
                </router-link>
            </li>
        </ul>
        <button @click="loadMore" v-if="hasNextPage">Show more</button>
    </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      titels: [],
      hoveredTitleId: null,
      currentPage: 1,
      hasNextPage: true,
    };
  },
  computed: {
    isAuthenticated() {
      return !!localStorage.getItem('token');
    },
  },
  mounted() {
    if (this.isAuthenticated) {
      this.fetchTitels();
    }
  },
  methods: {
    async fetchTitels(page = 1) {
      try {
        const response = await axios.get(`/api/home?page=${page}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        });
        if (page === 1) {
          this.titels = response.data.data;
        } else {
          this.titels.push(...response.data.data);
        }
        this.hasNextPage = response.data.pagination.has_next_page;
      } catch (error) {
        console.error('Loading error: ', error);
      }
    },
    loadMore() {
      this.currentPage++;
      this.fetchTitels(this.currentPage);
    },
    async addToFavorites(titel) {
      if (!this.isAuthenticated) {
        alert('You need to be logged in to add favorites.');
        return;
      }

      try {
        await axios.post('/api/favorites', { mal_id: titel.mal_id }, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        });
        alert('Added to favorites!');
      } catch (error) {
        console.error('Error adding to favorites:', error);
        alert('Could not add to favorites. Please try again.');
      }
    },
    handleMouseEnter(titel) {
      this.hoveredTitleId = titel.mal_id;
    },
    handleMouseLeave() {
      this.hoveredTitleId = null;
    },
  },
};
</script>