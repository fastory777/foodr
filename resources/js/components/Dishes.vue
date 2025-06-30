<template>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-20">
                <h2 class="text-xs text-indigo-500 tracking-widest font-medium title-font mb-1">DISHES</h2>
                <h1 class="sm:text-3xl text-2xl font-medium title-font text-gray-900">View our selection of delish dishes</h1>
            </div>
            <div class="flex flex-wrap -m-4 mr-10 ml-10">
                <!-- loading -->
                <h1 class="text-3xl" v-if="loading">Loading...</h1>

                <!-- fail message if loading is over, but dishes are not loaded -->
                <p v-if="!loading && dishes.length === 0" class="text-red-400 text-bold">Something went horribly horribly wrong.</p>

                <!-- dishes list -->
                <Dish
                    v-for="dish in dishes"
                    :key="dish.id || dish.name"
                    :dish="dish"
                />
            </div>
        </div>
    </section>
</template>

<script>
import Dish from './Dish.vue';

export default {
    name: 'Dishes',
    components: { Dish },

    data() {
        return {
            loading: false,
            dishes: [],
        }
    },

    mounted() {
        this.loading = true;

        fetch('api/dishes')
            .then(res => res.json())
            .then(({data}) => {
                console.log('RECEIVED DATA:', data);
                this.dishes = data;
            })
            .catch(err => {
                console.log(err);
                this.dishes = [];
            })
            .finally(() => {
                this.loading = false;
            });
    }
}
</script>
