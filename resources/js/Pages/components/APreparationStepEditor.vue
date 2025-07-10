<template>
    <div
        class="w-full border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 mb-4 p-4 space-y-3">
        <!-- Formatting panel -->
        <div class="flex gap-2 mb-2">
            <button @click.prevent="wrap('**')"
                    class="p-2 rounded bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500">
                <Bold class="w-4 h-4 text-black dark:text-white"/>
            </button>
            <button @click.prevent="wrap('*')"
                    class="p-2 rounded bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500">
                <Signature class="w-4 h-4 text-black dark:text-white"/>
            </button>
        </div>

        <!-- Input field -->
        <textarea
            ref="textAreaRef"
            v-model="modelValue.instruction"
            rows="5"
            class="w-full p-2 text-sm text-gray-800 dark:text-white bg-white dark:bg-gray-800 border rounded focus:ring-blue-500 focus:border-blue-500 resize-y"
            placeholder="Describe the step..."
        ></textarea>

        <!-- Image Uploading -->
        <div>
            <AImageUpload
                :modelValue="modelValue.image"
                @update:modelValue="updateImage"
                name="preparation-step-image"
                label="Upload Image"
                hint="Click or drag a single image"
            />
        </div>

        <!-- Duration time -->
        <div class="w-28">
            <label class="block text-sm text-gray-700 dark:text-gray-200 mb-1">Duration (in minutes)</label>
            <input
                v-model="localDuration"
                type="number"
                min="0"
                step="any"
                placeholder="100"
                class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white"
            />
        </div>

        <!-- Existing image preview (for edit mode) -->
        <div v-if="modelValue.image_path" class="mt-2">
            <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">Current image:</p>
            <img :src="modelValue.image_path" class="w-40 rounded border dark:border-gray-500"/>
        </div>

        <!-- Control Buttons -->
        <div class="flex justify-end">
            <button
                type="button"
                @click="isLast ? $emit('add') : $emit('remove')"
                class="rounded-full text-white p-2"
            >
                <CirclePlus v-if="isLast" class="w-6 h-6 cursor-pointer"/>
                <CircleMinus v-else class="w-6 h-6 cursor-pointer"/>
            </button>
        </div>
    </div>
</template>

<script>
import {CirclePlus, CircleMinus, Bold, Signature} from 'lucide-vue-next';
import AImageUpload from './AImageUpload.vue';

export default {
    name: 'APreparationStepEditor',
    components: {CirclePlus, CircleMinus, Bold, Signature, AImageUpload},
    props: {
        modelValue: Object,
        isLast: Boolean,
    },
    emits: ['update:modelValue', 'add', 'remove'],
    methods: {
        wrap(token) {
            const el = this.$refs.textAreaRef;
            if (!el) return;

            const {selectionStart: start, selectionEnd: end, value} = el;

            if (start !== end) {
                const wrapped = value.slice(0, start) + token + value.slice(start, end) + token + value.slice(end);
                this.$emit('update:modelValue', {
                    ...this.modelValue,
                    instruction: wrapped,
                });

                this.$nextTick(() => {
                    el.setSelectionRange(start + token.length, end + token.length);
                    el.focus();
                });
            }
        },
        updateImage(file) {
            this.$emit('update:modelValue', {
                ...this.modelValue,
                image: file,
            });
        }
    },
    computed: {
        localDuration: {
            get() {
                return this.modelValue.duration_minutes;
            },
            set(value) {
                this.$emit('update:modelValue', {
                    ...this.modelValue,
                    duration_minutes: value,
                })
            }
        }
    }
}
</script>
