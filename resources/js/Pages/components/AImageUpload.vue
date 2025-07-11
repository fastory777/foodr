<template>
    <div class="flex flex-col max-w-xl w-full">
        <label v-if="label" :for="name" class="mb-2 text-sm font-medium text-gray-900 dark:text-white">
            {{ label }}
        </label>

        <!-- Драг-зона -->
        <div class="flex flex-col items-center justify-center w-full">
            <label
                class="flex flex-col items-center justify-center w-full h-64 border-2  border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600"
                :class="error ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600'"
                @click="selectFile"
            >
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg
                        class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 20 16"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"
                        />
                    </svg>
                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                        <span class="font-semibold">Click to upload</span> or drag and drop
                    </p>
                    <p v-if="hint" class="text-xs text-gray-500 dark:text-gray-400">{{ hint }}</p>
                </div>
                <input
                    ref="fileInput"
                    type="file"
                    accept="image/*"
                    class="hidden"
                    @change="handleChange"
                />
            </label>
        </div>

        <!-- Preview -->
        <img
            v-if="preview"
            :src="preview"
            class="mt-4 h-auto rounded shadow-md"
            :style="{ width: previewSize }"
        />

        <p v-if="error"
           class="text-red-500 text-sm mt-2">
            {{ error }}
        </p>
    </div>
</template>

<script>
export default {
    name: 'AImageUpload',
    props: {
        modelValue: File,
        name: String,
        label: String,
        error: String,
        hint: String,
        previewSize: {
            type: String,
            default: '160px',
        },
    },
    data() {
        return {
            preview: null,
        };
    },
    watch: {
        modelValue: {
            immediate: true,
            handler(val) {
                if (val instanceof File) {
                    this.preview = URL.createObjectURL(val);
                } else {
                    this.preview = null;
                }
            },
        },
    },
    methods: {
        selectFile() {
            this.$refs.fileInput.click();
        },
        handleChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.$emit('update:modelValue', file);
            }
            event.target.value = null;
        },
    },
};
</script>
