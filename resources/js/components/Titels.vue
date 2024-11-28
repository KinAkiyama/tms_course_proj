<template>
    <div class="container py-3">
      <div class="carousel-container">
        <h3 class="p-2 rounded-top carousel-title">This season top anime</h3>
        <carousel :items-to-show="6" :wrap-around="true" :items-to-scroll="6" class="mb-3">
          <slide v-for="title in thisSeasontitels" :key="title.mal_id" >
            <router-link :to="`/titel/${title.mal_id}`" class="carousel-titel-item-container" @mouseenter="handleMouseEnter(title)" @mouseleave="handleMouseLeave">
              <div class="carousel-titel-item-imageSection">
                  <img :src="title.images.jpg.image_url" alt="title image" />
                  <div class="titel-item-overlay" v-if="hoveredTitleId === title.mal_id">
                      <div class="titel-item-info">
                          <div class="score-info">{{ title.score }}</div>
                          <div class="">{{ title.type }} {{ title.year }}</div>
                          <div class="">{{ title.themes.name }}</div>
                      </div>
                      <button class="btn text-white" @click.prevent="addToFavorites(title)">Watch later</button>
                  </div>
              </div>
              <div v-if="title.title_english" class="titel-item-textSection mt-2">
                  {{ title.title_english }}
              </div>
              <div v-else class="titel-item-textSection mt-2">
                  {{ title.title }}
              </div>
            </router-link>
          </slide>

          <template #addons>
            <navigation />
            <pagination />
          </template>
        </carousel>
      </div>
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
                            <button class="btn text-white" @click.prevent="addToFavorites(titel)">Watch later</button>
                        </div>
                    </div>
                    <div v-if="titel.title_english" class="titel-item-textSection mt-2">
                        {{ titel.title_english }}
                    </div>
                    <div v-else class="titel-item-textSection mt-2">
                        {{ titel.title }}
                    </div>
                </router-link>
            </li>
        </ul>
        <button @click="loadMore" v-if="hasNextPage" class="show-more-btn btn w-100 fs-6 fw-semibold">Show more</button>
    </div>
</template>

<script>
import axios from 'axios';
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel';


export default {
  components: {
    Carousel,
    Slide,
    Pagination,
    Navigation,
  },
  data() {
    return {
      titels: [],
      thisSeasontitels: [],
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
    this.fetchTitels();
    this.fetchSeasonTitels();
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
    async fetchSeasonTitels() {
      try {
        const response = await axios.get(`/api/home/season`);
        this.thisSeasontitels = response.data.data;
        console.log(this.thisSeasontitels);
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