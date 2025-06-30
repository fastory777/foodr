<template>
    <div class="p-4 md:w-1/3">
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

                <a href="#"
                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Read more
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Dish',
    props: ['dish']
}
</script>
