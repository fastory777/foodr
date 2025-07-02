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

        <!-- Popup AI bot -->
        <div
            v-if="showPopup"
            class="fixed bottom-6 right-6 z-50"
        >
            <div class="bg-white p-4 rounded-xl shadow-lg w-80 animate-slide-up relative border border-gray-200">
                <button
                    @click="showPopup = false"
                    class="absolute top-2 right-3 text-gray-400 hover:text-black text-lg cursor-pointer"
                >
                    ✖
                </button>
                <img
                    src="/storage/app/public/assets/chef.png"
                    alt="Chef"
                    class="w-90 mt-7"
                />
                <h2 class="text-xl font-bold mb-1">Tired of choosing a recipe?</h2>
                <p class="text-base text-gray-600">Try our AI assistant — get a tasty dinner idea in seconds!</p>
            </div>
        </div>

    </Layout>
</template>

<script>
import Layout from '../Layout.vue';
import { Link } from '@inertiajs/vue3'
import { onMounted, ref } from 'vue'

export default {
    components: {
        Layout,
        Link,
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
@keyframes slideUp {
    from {
        opacity: 1;
        transform: translateY(300px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-slide-up {
    animation: slideUp 0.8s ease-out;
}

</style>
