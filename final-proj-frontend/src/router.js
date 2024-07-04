import {createRouter, createWebHistory } from 'vue-router';

/*importazione delle pagine/rotte */
import AppHome from './pages/AppHome.vue';
import AppAdvancedSearch from './pages/AppAdvancedSearch.vue';
import AppMenu from './pages/AppMenu.vue';
import NotFound from './pages/NotFound.vue';


const routes = [
    {
        path: '/', name:'home', component: AppHome
    },
    {
        path: '/search', name:'search', component: AppAdvancedSearch
    },
    {
        path: '/search/:slug', name: 'type', component: AppAdvancedSearch, props: true
    },
    {
        path: '/menu/:slug', name: 'menu', component: AppMenu, props: true
    },
    {
        path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound
    },
]


const router = createRouter({

    history: createWebHistory(),

    routes: routes
  
})
export default router
