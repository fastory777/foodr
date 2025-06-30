<template>
    <Layout>
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

                    <div v-for="(dish, i) in dishes"
                         :key="i"
                         class="p-4 md:w-1/3">
                        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
                            <img
                                v-if="dish.image_url"
                                :src="dish.image_url"
                                alt=""
                                class="w-full h-48 object-cover"
                            />

                            <div class="p-5">
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

                                <Link :href="`/dish/${dish.id}`"
                                      class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Read more
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </Layout>
</template>

<script>
import Layout from '../Layout.vue';
import { Link } from '@inertiajs/vue3'

export default {
    components: {
        Layout,
        Link,
    },

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
