<template>
    <div class="flex flex-col body-font h-screen">
        <header class="text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-900">
            <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
                <Link href="/" class="flex title-font font-medium items-center text-gray-900 dark:text-white mb-4 md:mb-0">
                    <div class="rounded-full bg-indigo-500 p-2 text-white">
                        <Utensils />
                    </div>
                    <span class="ml-3 text-2xl brand-name">Foodr</span>
                </Link>
                <nav class="md:ml-auto md:mr-auto flex flex-wrap items-center text-base justify-center">
                    <Link href="/"
                          class="mr-5 hover:text-gray-900 dark:hover:text-white">All dishes
                    </Link>
                    <a class="mr-5 hover:text-gray-900 dark:hover:text-white">Forum</a>
                    <a class="mr-5 hover:text-gray-900 dark:hover:text-white">For Creators</a>
                    <a class="mr-5 hover:text-gray-900 dark:hover:text-white">About Us</a>
                </nav>

                <!-- a possible switch button between themes (not working now)
                <button @click="toggleTheme" class="p-2 rounded bg-indigo-500 text-white cursor-pointer">
                    <component :is="theme === 'dark' ? Moon : SunMedium" class="w-5 h-5" />
                </button>
                -->


                <Link
                    :href="`/dish/create`"
                    class="inline-flex items-center bg-gray-100 dark:bg-gray-700 border-0 py-1 px-3 focus:outline-none hover:bg-gray-200 dark:hover:bg-gray-600 rounded text-base mt-4 md:mt-0 cursor-pointer dark:text-white">
                    New Dish
                    <svg fill="none"
                         stroke="currentColor"
                         stroke-linecap="round"
                         stroke-linejoin="round"
                         stroke-width="2"
                         class="w-4 h-4 ml-1"
                         viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </Link>
            </div>
        </header>

        <div class="flex-grow">
            <slot></slot>
        </div>

        <footer class="text-gray-600 dark:text-gray-400">
            <div class="bg-gray-100 dark:bg-gray-800">
                <div class="container mx-auto py-4 px-5 flex flex-wrap flex-col sm:flex-row">
                    <p class="text-gray-500 dark:text-gray-400 text-sm text-center sm:text-left">© 2025 Foodr</p>

                    <span class="inline-flex sm:ml-auto sm:mt-0 mt-2 justify-center sm:justify-start">
                    <a class="text-gray-500 dark:text-gray-400">
                        <svg fill="currentColor"
                             stroke-linecap="round"
                             stroke-linejoin="round"
                             stroke-width="2"
                             class="w-5 h-5"
                             viewBox="0 0 24 24">
                            <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
                        </svg>
                    </a>

                    <a class="ml-3 text-gray-500 dark:text-gray-400">
                        <svg fill="currentColor"
                             stroke-linecap="round"
                             stroke-linejoin="round"
                             stroke-width="2"
                             class="w-5 h-5"
                             viewBox="0 0 24 24">
                        <path
                            d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path>
                        </svg>
                    </a>
                    <a class="ml-3 text-gray-500 dark:text-gray-400">
                        <svg fill="none"
                             stroke="currentColor"
                             stroke-linecap="round"
                             stroke-linejoin="round"
                             stroke-width="2"
                             class="w-5 h-5"
                             viewBox="0 0 24 24">
                        <rect width="20"
                              height="20"
                              x="2"
                              y="2"
                              rx="5"
                              ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"></path>
                        </svg>
                    </a>
                    <a class="ml-3 text-gray-500 dark:text-gray-400">
                        <svg fill="currentColor"
                             stroke="currentColor"
                             stroke-linecap="round"
                             stroke-linejoin="round"
                             stroke-width="0"
                             class="w-5 h-5"
                             viewBox="0 0 24 24">
                        <path stroke="none"
                              d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"></path>
                        <circle cx="4"
                                cy="4"
                                r="2"
                                stroke="none"></circle>
                        </svg>
                    </a>
                </span>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
import { Utensils, SunMedium, Moon } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';

export default {
    components: {
        Utensils, SunMedium, Moon,
        Link
    },
    data() {
        return {
            theme: 'light',
        };
    },
    mounted() {
        const saved = localStorage.getItem('theme');

        if (saved) {
            this.theme = saved;
        } else {
            this.theme = 'light';
            localStorage.setItem('theme', this.theme);
        }

        this.applyTheme(); //
    },

    methods: {
        toggleTheme() {
            this.theme = this.theme === 'dark' ? 'light' : 'dark';
            localStorage.setItem('theme', this.theme);
            this.applyTheme();
        },
        applyTheme() {
            console.log('Applying theme:', this.theme);
            const html = document.documentElement;

            html.classList.remove('dark'); // reset
            if (this.theme === 'dark') {
                html.classList.add('dark');
            }
        }
    }
}
</script>

<style>
.brand-name {
    font-family: 'Alexandria', sans-serif;
}
</style>
