<template>
    <Header />
    <Body :dishes="dishes" :loading="loading" />
    <Footer />
</template>

<script>
import axios from 'axios'
import Header from './Header.vue';
import Body from './Body.vue';
import Footer from './Footer.vue';

export default {
    name: 'App',
    components: {
        Header,
        Body,
        Footer
    },

    data() {
        return {
            loading: false,
            dishes: [], // dishes from server
        }
    },

    mounted() {
        this.loading = true;

        fetch('api/dishes') // get zapros k laravel po adresu
            .then(res => res.json()) // kogda poluchen otvet delat ego v json
            .then(({data}) => {
                this.dishes = data; // sohranyaem poluchenniye bluda v peremennuyu "dishes"
            })
            .catch(err => console.log(err))
            .finally(() => {
                this.loading = false;
            });
    }
}
</script>
