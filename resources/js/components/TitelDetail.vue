<template>
    <div class="container">
        <div class="title-header-info pt-4">
            <div class="title-header-img">
                <img v-if="titel.images && titel.images.webp" :src="titel.images.webp.image_url" alt="title image" />
            </div>
            <div class="title-header-text">
                <h2>{{titel.title_english }}</h2>
                <ul class="title-info p-0 w-100">
                    <li class="title-info-text">
                        <span>Status:</span>
                        <div class="title-info-value"> {{ titel.status }}</div>
                    </li>
                    <li class="title-info-text">
                        <span>Type:</span>
                        <div class="title-info-value"> {{ titel.type }}</div>
                    </li>
                    <li class="title-info-text">
                        <span>Year:</span>
                        <div class="title-info-value"> {{ titel.year }}</div>
                    </li>
                    <li class="title-info-text">
                        <span>Rating:</span>
                        <div class="title-info-value"> {{ titel.rating }}</div>
                    </li>
                    <li class="title-info-text">
                        <span>Genres:</span>
                        <div v-if="titel.genres && titel.genres.length > 0" class="title-info-value">
                            {{ titel.genres.map(genre => genre.name).join(', ') }}
                        </div>
                    </li>
                    <li class="title-info-text">
                        <span>Studios:</span>
                        <div v-if="titel.studios && titel.studios.length > 0" class="title-info-value">
                            {{ titel.studios.map(studio => studio.name).join(', ') }}
                        </div>
                    </li>
                    <li class="title-info-text">
                        <span>Producers:</span>
                        <div v-if="titel.producers && titel.producers.length > 0" class="title-info-value">
                            {{ titel.producers.map(producer => producer.name).join(', ') }}
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="titel-description py-2">
            <p>{{ titel.synopsis }}</p>
        </div>
        <div class="episode-selector">
            <div class="episodes-selector-title">
                <h3>Episodes</h3>
            </div>
            <div class="row p-0">
                <div v-for="episode in episodes" :key="episode.mal_id" class="episode-item fw-semibold p-3 m-2">
                    <a href="#" @click.prevent="selectEpisode(episode.url)">{{ episode.mal_id }}</a>
                </div>
            </div>
        </div>
        <div class="title-video">
            <iframe v-if="selectedEpisodeUrl" :src="selectedEpisodeUrl" class="h-100%" frameborder="0" width="100%" height="auto" scrolling="no" allowfullscreen 
            allow="accelerometer *; clipboard-write *; encrypted-media *; gyroscope *; picture-in-picture *; fullscreen *"></iframe>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                titel: {},
                episodes: [],
                selectedEpisodeUrl: null,
            };
        },
        async mounted() {
        const mal_id = this.$route.params.mal_id;
        await this.fetchTitel(mal_id);
        await this.fetchEpisodes(mal_id);
        },
        methods: {
        async fetchTitel(mal_id) {
            try {
                const response = await fetch(`/api/titel/${mal_id}`);
                const data = await response.json();
                this.titel = data.data;
            } catch (error) {
                console.error('Ошибка:', error);
            }
        },
        async fetchEpisodes(mal_id) {
            try {
                const response = await fetch(`/api/titel/${mal_id}/episodes`);
                const data = await response.json();
                this.episodes = data.data;
            } catch (error) {
                console.error('Ошибка:', error);
            }
        },
        selectEpisode(url) {
            this.selectedEpisodeUrl = url;
        },
    },
    }
</script>