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
        <div class="titel-description">
            <p>{{ titel.synopsis }}</p>
        </div>
        <div class="title-video">
            <iframe v-if="titel.trailer && titel.trailer.embed_url" :src="titel.trailer.embed_url" class="h-100%" frameborder="0" width="100%" height="auto" scrolling="no" allowfullscreen 
            allow="accelerometer *; autoplay *; clipboard-write *; encrypted-media *; gyroscope *; picture-in-picture *; fullscreen *"></iframe>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                titel: {},
            };
        },
        async mounted() {
        const mal_id = this.$route.params.mal_id;
        try {
            const response = await fetch(`/api/titel/${mal_id}`);
            const data = await response.json();
            this.titel = data.data;
        } catch (error) {
            console.error('Ошибка:', error);
        }
    },
    }
</script>