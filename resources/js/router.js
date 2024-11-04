import { createRouter, createWebHistory } from 'vue-router';
import Register from './components/Register.vue';
import Login from './components/Login.vue';
import Titels from './components/Titels.vue';
import TitelDetail from './components/TitelDetail.vue';
import User from './components/User.vue';

const routes = [
    {
        path: '/register',
        name: 'Register',
        component: Register,
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
    },
    {
        path: '/home',
        name: 'Home',
        component: Titels,
    },
    {
        path: '/titel/:mal_id',
        name: 'Titel',
        component: TitelDetail,
    },
    {
        path: '/user/:id',
        name: 'User',
        component: User,
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
