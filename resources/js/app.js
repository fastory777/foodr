import './bootstrap';
import { createApp } from 'vue';
import App from './components/App.vue';
import Header from './components/Header.vue';
import Body from './components/Body.vue';
import Footer from './components/Footer.vue';

const app = createApp(App);

app.component('header', Header)
    .component('body', Body)
    .component('footer', Footer)

app.mount('#app');
