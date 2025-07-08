<template>
    <div class="flex flex-col">
        <label
            v-if="label"
            :for="name"
            class="block mb-1 text-sm font-medium text-gray-900 dark:text-white"
        >
            {{ label }}
        </label>

        <!--
        Bind the input's value from the parent via modelValue.
        Emit input event on change, to let the parent update its v-model.
        This is the correct way to support v-model in custom components (Vue 3).
        -->
        <input
            :id="name"
            :type="type"
            :name="name"
            :value="type !== 'file' ? modelValue : undefined"
            @input="handleInput"
            :class="className"
        />
        <!-- When the user types, emit an event to update the parent component's v-model.
        This follows the Vue 3 convention: modelValue as a prop + update:modelValue as the event. -->

        <p v-if="error" class="text-red-500 text-bold -mt-2.5">{{ error }}</p>
    </div>
</template>

<script>
import { twMerge } from 'tailwind-merge'

export default {
    name: 'AInput',
    props: {
        modelValue: {
            type: [String, Number],
            default: '',
        },
        name: {
            type: String,
            required: true,
        },
        type: {
            type: String,
            default: 'text',
        },
        label: {
            type: String,
            default: '',
        },
        customClass: {
            type: String,
            default: '',
        },
        error: {
            type: String,
            default: null,
        }
    },
    methods: {
        handleInput(event) {
            const value =
                this.type === 'file'
                    ? event.target.files[0]
                    : event.target.value;
            this.$emit('update:modelValue', value);
        }
    },
    data() {
        return {
            defaultClasses: 'p-2.5 mb-4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
            errorClasses: 'border-red-600 dark:border-red-600 dark:focus:border-red-500 focus:border-red-500 focus:ring-red-500 dark:focus:ring-red-500',
        }
    },

    computed: {
        computedErrorClasses() {
            if (this.error) {
                return this.errorClasses;
            }

            return '';
        },

        className() {
            return twMerge(this.defaultClasses, this.customClass, this.computedErrorClasses);
        },
    }
}
</script>



