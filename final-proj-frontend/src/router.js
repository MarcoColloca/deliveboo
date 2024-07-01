import {createRouter, createWebHistory } from 'vue-router';

/*importazione delle pagine/rotte */
import AppHome from './pages/AppHome.vue';
import AppAdvancedSearch from './pages/AppAdvancedSearch.vue';



const routes = [
    {
        path: '/', name:'home', component: AppHome
    },
    {
        path: '/search', name:'search', component: AppAdvancedSearch
    },
    {
        path: '/search/:slug', name: 'type', component: AppAdvancedSearch, props: true
    }
]


const router = createRouter({

    history: createWebHistory(),

    routes: routes
  
})
export default router