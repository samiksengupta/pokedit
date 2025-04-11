import { createRouter, createWebHistory } from 'vue-router';
import Home from '../../vue/Home.vue';
import Downloader from '../../vue/Downloader.vue';
import Editor from '../../vue/Editor.vue';

const routes = [
    { 
        path: '/', 
        name: 'Home', 
        component: Home 
    },
    {
        path: '/downloader',
        name: 'Downloader',
        component: Downloader,
    },
    { 
        path: '/editor', 
        name: 'Editor', 
        component: Editor 
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
