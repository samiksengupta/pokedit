import { createRouter, createWebHistory } from 'vue-router';
import Home from '../../vue/Home.vue';
import PokeApiImporter from '../../vue/PokeApiImporter.vue';
import Editor from '../../vue/Editor.vue';

const routes = [
    { 
        path: '/', 
        name: 'Home', 
        component: Home 
    },
    {
        path: '/importer/pokeapi',
        name: 'PokeApi Importer',
        component: PokeApiImporter,
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
