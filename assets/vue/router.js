import FruitsList from './components/FruitsList.vue'
import FavoriteFruits from './components/FavoriteFruits.vue'
import { createRouter, createWebHistory } from 'vue-router'


const routes = [
    {
        name: 'FruitsList',
        component: FruitsList,
        path: '/'
    },
    {
        name: 'FavoriteFruits',
        component: FavoriteFruits,
        path: '/fav-fruits'
    },
]


const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;