import './bootstrap';
import { createApp } from 'vue';
import App from './components/App.vue';
import Dishes from './components/Dishes.vue';
import Dish from './components/Dish.vue';

// Create and mount the main app
const app = createApp({});

app.component('dish', Dish)
    .component('dishes', Dishes);

app.mount('#app');

