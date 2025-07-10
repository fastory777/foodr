<template>
    <Layout>
        <section class="text-gray-600 body-font">
            <div class="container px-5 py-24 mx-auto">
                <div class="flex flex-col text-center w-full mb-20">
                    <h2 class="text-xs text-indigo-500 dark:text-blue-400 tracking-widest font-medium title-font mb-1">DISHES</h2>
                    <h1 class="sm:text-3xl text-2xl font-medium title-font text-gray-900 dark:text-gray-100">View our selection of delish dishes</h1>
                </div>

                <div class="flex flex-wrap justify-center -m-4">
                    <!-- loading -->
                    <h1 class="text-3xl" v-if="loading">Loading...</h1>

                    <!-- fail message if loading is over, but dishes are not loaded -->
                    <p v-if="!loading && dishes.length === 0" class="text-red-400 text-bold">Something went horribly horribly wrong.</p>

                    <div v-for="(dish, i) in dishes"
                         :key="i"
                         class="p-4 m-4 w-full sm:w-1/2 md:w-1/3 xl:w-1/4"> <!-- md:w-1/3 -->
                        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden transition-transform duration-300 transform hover:scale-105 hover:shadow-xl">
                            <img
                                v-if="dish.image_url"
                                :src="dish.image_url"
                                alt=""
                                class="w-full h-48 object-cover"
                            />

                            <div class="p-6">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    {{ dish.name }}
                                </h5>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                                    {{ dish.description }}
                                </p>

                                <ul class="mb-3 text-sm text-gray-700 dark:text-gray-400">
                                    <li v-for="ingredient in dish.ingredients" :key="ingredient.id">
                                        • {{ ingredient.name }}
                                    </li>
                                </ul>

                                <AButton :href="`/dish/${dish.id}`">
                                    Read more
                                </AButton>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <AiPopupBot :show="showPopup" @close="showPopup = false" />

    </Layout>
</template>

<script>
import Layout from '../Layout.vue';
import { Link } from '@inertiajs/vue3'
import AButton from "../components/AButton.vue";
import AiPopupBot from "../components/AiPopupBot.vue"

export default {
    components: {
        Layout,
        Link,
        AButton,
        AiPopupBot,
    },

    data() {
        return {
            loading: false,
            dishes: [],
            showPopup: false,
        }
    },
    mounted() {
        this.loading = true;

        fetch('api/dishes')
            .then(res => res.json())
            .then((data) => {
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

        setTimeout(() => { this.showPopup = true; }, 3000)



    }
}
</script>

<style>
</style>
