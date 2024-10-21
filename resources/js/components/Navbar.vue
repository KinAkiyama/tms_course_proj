<template>
    <div class="container">
        <div class="d-flex justify-content-end py-2 border-bottom">
            <div v-if="isAuthenticated">
                <ul class="nav nav-pills">
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
    </div>
</template>

<script>
export default {
    data() {
        return {
            user: JSON.parse(localStorage.getItem('user')) || {},
            isAuthenticated: !!localStorage.getItem('token'),
        }
    },
};
</script>