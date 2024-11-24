<template>
    <div class="container">
        <form @submit.prevent="createComment">
            <div class="form-group">
                <textarea v-model="description" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <button class="btn fs-4 fw-bold w-100 py-2 mt-2" type="submit">Comment</button>
        </form>
        <div class="comment-container">
            <div v-for="comment in comments" :key="comment.id" class="comment">
                <div class="comment-top">
                    <div class="comment-head">
                        <router-link :to="`/user/${comment.user.id}`" class="text-decoration-none text-black">
                            {{ comment.user.username }}
                        </router-link>
                        <div class="time">
                            {{ formatDate(comment.created_at) }}
                        </div>
                    </div>
                    <div class="comment-stats">
                        <span class="likes far fa-thumbs-up text-success">
                            {{ comment.likes }}
                        </span>
                        <span class="dislikes far fa-thumbs-down text-danger">
                            {{ comment.dislikes }}
                        </span>
                    </div>
                </div>
                <div class="comment-body">
                    <div class="comment-text">
                        <div class="username-update d-flex mb-3">
                            <input v-model="comment.description" placeholder="Edit comment" class="form-control"/>
                            <button class="btn show-more-btn fw-semibold ms-2" @click="updateComment(comment)">Save</button>
                            <button class="btn show-more-btn fw-semibold ms-2" @click="deleteComment(comment)">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            comment: {},
            comments: [],
            description: '',
            mal_id: this.$route.params.mal_id,
        };
    },
    mounted() {
        this.fetchComments();
    },
    computed: {
        isAuthenticated() {
            return !!localStorage.getItem('token');
        }
    },
    methods:{
        formatDate(date) {
            const d = new Date(date);
            const options = { month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            return d.toLocaleString('en-US', options);
        },
        async fetchComments() {
            try {
                const response = await axios.get(`/api/title/${this.mal_id}/comments`);
                this.comments = response.data;
            } catch (error) {
                console.error('Error fetching comments:', error);
            }
        },
        async createComment() {
            try {
                const response = await axios.post(`/api/title/${this.mal_id}/comments`, {
                    description: this.description,
                },
                {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    }
                }
            );

                if (response.status == 200) {
                    this.comments.push(response.data);
                    this.description = '';
                    alert('Comment created!');
                    await this.fetchComments();
                } else {
                    this.error = response.data.message || 'Response error';
                }
            } catch (error){
                console.error(error);
                if (error.response && error.response.data.errors) {
                    this.error = error.response.data.errors;
                } else {
                    this.error = 'Network error';
                }
            }
        },
        async updateComment (comment) {
            try {
                const response = await axios.put(`/api/title/${this.mal_id}/comments/${comment.id}/update`, {
                    description: comment.description,
                },
                {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    }
                });
                if (response.status == 200) {
                    alert('Comment updated!');
                    await this.fetchComments();
                } else {
                    this.error = response.data.message || 'Response error';
                }
            } catch (error) {
                console.error(error);
                if (error.response && error.response.data.errors) {
                    this.error = error.response.data.errors;
                } else {
                    this.error = 'Network error';
                }
            }
        },
        async deleteComment (comment) {
            try {
                const response = await axios.delete(`/api/title/${this.mal_id}/comments/${comment.id}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    }
                });
                if (response.status == 204) {
                    const index = this.comments.findIndex(c => c.id === comment.id);
                    if (index !== -1) {
                        this.comments.splice(index, 1);
                    }
                    alert('Comment deleted!');
                    await this.fetchComments();
                } else {
                    this.error = response.data.message || 'Response error';
                }
            } catch (error) {
                console.error(error);
                if (error.response && error.response.data.errors) {
                    this.error = error.response.data.errors;
                } else {
                    this.error = 'Network error';
                }
            }
        }
    },
}
</script>