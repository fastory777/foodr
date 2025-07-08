<template>
    <Link
        :class="className"
        :type="type"
        :name="name"
        :form-name="computedClass"
    >
        <slot></slot>
    </Link>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import { twMerge } from 'tailwind-merge'

export default {
    name: "AButton",
    components: { Link },
    props: {
        customClass: {
            type: String,
            default: ''
        },
        color: {
            type: String,
            default: 'blue'
        },
        type: {
            type: String,
            default: 'button'
        },
    },
    data() {
        return {
            defaultClasses: 'inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg focus:ring-4 focus:outline-none',
            colorOptions: {
                blue: 'bg-blue-700 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 hover:bg-blue-800',
                red: 'bg-red-700 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 hover:bg-red-800',
                yellow: 'bg-yellow-700 focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800 hover:bg-yellow-800',
                green: 'bg-green-700 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 hover:bg-green-800',
                black: 'bg-black focus:ring-black dark:bg-black dark:hover:bg-black dark:focus:ring-grey-700 hover:bg-grey-800',
            },
        };
    },
    computed: {
        className() {
            return twMerge(
                this.colorOptions[this.color],
                this.defaultClasses,
                this.customClass
            );
        }
    }
}
</script>
