<template>
    <Layout>
        <section class="text-gray-600 body-font">
            <div class="container px-5 py-24 mx-auto">
                <div class="flex flex-col text-center w-full mb-20">
                    <h2 class="text-xs text-indigo-500 tracking-widest font-medium title-font mb-1">DISH DETAILS</h2>
                    <h1 class="sm:text-3xl text-2xl font-medium title-font text-gray-900">{{ dish.name }}</h1>
                </div>

                <!-- Code for showing a dish goes here -->

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

export default {
    components: {
        Layout,
        Link
    },

    props: {
        dish: {
            type: Object,
            required: true
        }
    }
}
</script>
