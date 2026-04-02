import { createRouter, createWebHistory } from 'vue-router';
import Home from '../../vue/Home.vue';
import PokeApiImporter from '../../vue/PokeApiImporter.vue';
import Editor from '../../vue/Editor.vue';
import DataManager from '../../vue/DataManager.vue';
import Settings from '../../vue/Settings.vue';

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
    { 
        path: '/data-manager', 
        name: 'Data Manager', 
        component: DataManager 
    },
    { 
        path: '/settings', 
        name: 'Settings', 
        component: Settings 
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
