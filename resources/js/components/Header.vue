<template>
    <header class="text-gray-600 body-font">
        <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
            <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
                <div class="rounded-full bg-indigo-500 p-2 text-white">
                    <Utensils />
                </div>
                <span class="ml-3 text-2xl brand-name">Foodr</span>
            </a>
            <nav class="md:ml-auto md:mr-auto flex flex-wrap items-center text-base justify-center">
                <a class="mr-5 hover:text-gray-900">All dishes</a>
                <a class="mr-5 hover:text-gray-900">Forum</a>
                <a class="mr-5 hover:text-gray-900">For Creators</a>
                <a class="mr-5 hover:text-gray-900">About Us</a>
            </nav>
            <button class="inline-flex items-center bg-gray-100 border-0 py-1 px-3 focus:outline-none hover:bg-gray-200 rounded text-base mt-4 md:mt-0">Upload
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-1" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7"></path>
                </svg>
            </button>


        </div>
    </header>
</template>

<script>
import { Utensils } from 'lucide-vue-next';

export default {
    name: 'Header',
    components: { Utensils },
}
</script>

<style>
.brand-name {
    font-family: 'Alexandria', sans-serif;
}
</style>
