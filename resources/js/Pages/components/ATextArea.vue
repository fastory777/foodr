<template>
    <div class="w-full">
        <label
            v-if="label"
            :for="id"
            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
        >
            {{ label }}
        </label>
        <textarea
            :id="id"
            :rows="rows"
            :placeholder="placeholder"
            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
        ></textarea>
        <p v-if="error" class="text-red-500 text-sm mt-1">{{ error }}</p>
    </div>
</template>

<script>
export default {
    name: 'ATextArea',
    props: {
        modelValue: {
            type: String,
            default: '',
        },
        label: {
            type: String,
            default: '',
        },
        placeholder: {
            type: String,
            default: 'Write your thoughts here...',
        },
        rows: {
            type: Number,
            default: 4,
        },
        id: {
            type: String,
            default: 'textarea',
        },
        error: {
            type: String,
            default: '',
        },
    },
};
</script>
