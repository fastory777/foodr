<template>
    <Layout>
        <section class="text-gray-600 body-font">
            <div class="container px-5 py-24 mx-auto">
                <Link href="/" class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
                    <span class="mb-4 text-sm text-gray-500">← Back to All Dishes</span>
                </Link>
                <div class="flex flex-col text-center w-full mb-20">
                    <h2 class="text-xs text-indigo-500 tracking-widest font-medium title-font mb-1">DISH DETAILS</h2>
                    <h1 class="sm:text-3xl text-2xl font-medium title-font text-gray-900">{{ dish.name }}</h1>
                </div>

                <!-- Code for showing a dish goes here -->
                <!-- Tab navigation -->

                <div id="scroll-bar" class="fixed top-0 left-0 w-0 h-1 bg-blue-500 z-50"></div>

                <div>
                    <ul class="text-l font-medium mb-4 text-indigo-500">
                        <li><a href="#overview" class="hover:underline">- Overview </a></li>
                        <li><a href="#ingredients" class="hover:underline">- Ingredients </a></li>
                        <li><a href="#preparation" class="hover:underline">- Preparation</a></li>
                        <li><a href="#tips-story" class="hover:underline">- Tips & Story</a></li>
                    </ul>
                </div>

                <section id="overview" class="mb-8">
                    <h2 class="text-xl font-bold mb-2">Overview</h2>
                    <p>{{ dish.description }}</p>
                </section>

                <section id="ingredients" class="mb-8">
                    <h2 class="text-xl font-bold mb-2">Ingredients</h2>
                    <ul>
                        <li v-for="ingredient in dish.ingredients" :key="ingredient.id">• {{ ingredient.name }}</li>
                    </ul>
                </section>

                <section id="preparation" class="mb-8">
                    <h2 class="text-xl font-bold mb-4">🍳 Preparation</h2>
                    <ol class="list-decimal pl-6 space-y-4">
                        <li v-for="step in dish.preparation_steps" :key="step.step_number">
                            <p class="font-medium">
                                Step {{ step.step_number }}<span v-if="step.duration_minutes"> — ⏱ {{ step.duration_minutes }} min</span>:
                            </p>
                            <p>{{ step.instruction }}</p>
                        </li>
                    </ol>
                </section>

                <section id="tips-story" class="mb-8">
                    <h2 class="text-xl font-bold mb-2">Tips & Story</h2>
                    <p>{{ dish.tips }}</p>
                    <p class="mt-4">{{ dish.history }}</p>
                </section>



                <Link href="/"
                      class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Back to dishes
                </Link>
            </div>
        </section>
    </Layout>
</template>

<script>
import Layout from '../Layout.vue';
import { Link } from '@inertiajs/vue3';
import { onMounted, onUnmounted } from 'vue'
import {Utensils} from "lucide-vue-next";

export default {
    components: {
        Utensils,
        Layout,
        Link
    },

    props: {
        dish: {
            type: Object,
            required: true
        }
    },
    setup() {
        function updateScrollBar() {
            const winScroll = document.documentElement.scrollTop || document.body.scrollTop
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight
            const scrolled = (winScroll / height) * 100
            const el = document.getElementById('scroll-bar')
            if (el) {
                el.style.width = scrolled + '%'
            }
        }

        onMounted(() => {
            window.addEventListener('scroll', updateScrollBar)
        })

        onUnmounted(() => {
            window.removeEventListener('scroll', updateScrollBar)
        })
    }
}

</script>
