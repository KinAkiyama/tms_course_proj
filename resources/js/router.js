import { createRouter, createWebHistory } from 'vue-router';
import Register from './components/Register.vue';
import Login from './components/Login.vue';
import Titels from './components/Titels.vue';
import TitelDetail from './components/TitelDetail.vue';

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
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
