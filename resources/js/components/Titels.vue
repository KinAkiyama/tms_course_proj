<template>
    <div class="container py-3">
        <div v-if="!isAuthenticated">Unauthenticated</div>
        <div v-else>Authenticated</div>
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
    </div>
</template>

<!-- <script>
import axios from 'axios';

export default {
    data() {
        return {
            titels: [],
            hoveredTitleId: null,
        };
    },
    mounted() {
        this.fetchTitels();
    },
    methods: {
        async fetchTitels() {
            try {
                const response = await axios.get('/api/home');
                this.titels = response.data.data;
            } catch (error) {
                console.error('Loading error: ', error);
            }
        },
        addToFavorites (titel) {
            //////////
        },
        handleMouseEnter (titel) {
            this.hoveredTitleId = titel.mal_id;
        },
        handleMouseLeave() {
            this.hoveredTitleId = null;
        }
    }
};
</script> -->

<script>
import axios from 'axios';

export default {
  data() {
    return {
      titels: [],
      hoveredTitleId: null,
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
    async fetchTitels() {
      try {
        const response = await axios.get('/api/home', {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        });
        this.titels = response.data.data;
      } catch (error) {
        console.error('Loading error: ', error);
      }
    },
    addToFavorites(titel) {
      //////////
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