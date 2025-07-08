<template>
    <div class="w-full border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 mb-4 p-4 space-y-3">
        <!-- Formatting panel -->
        <div class="flex gap-2 mb-2">
            <button @click.prevent="wrap('**')" class="p-2 rounded bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500">
                <Bold class="w-4 h-4 text-black dark:text-white" />
            </button>
            <button @click.prevent="wrap('*')" class="p-2 rounded bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500">
                <Signature class="w-4 h-4 text-black dark:text-white" />
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


        <!-- Control Buttons -->
        <div class="flex justify-end">
            <button
                type="button"
                @click="isLast ? $emit('add') : $emit('remove')"
                class="rounded-full text-white p-2"
                :class="isLast ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700'"
            >
                <CirclePlus v-if="isLast" class="w-5 h-5" />
                <CircleMinus v-else class="w-5 h-5" />
            </button>
        </div>
    </div>
</template>

<script>
import { CirclePlus, CircleMinus, Bold, Signature } from 'lucide-vue-next';
import AImageUpload from './AImageUpload.vue';

export default {
    name: 'APreparationStepEditor',
    components: { CirclePlus, CircleMinus, Bold, Signature, AImageUpload },
    props: {
        modelValue: Object,
        isLast: Boolean,
    },
    emits: ['update:modelValue', 'add', 'remove'],
    methods: {
        wrap(token) {
            const el = this.$refs.textAreaRef;
            if (!el) return;

            const { selectionStart: start, selectionEnd: end, value } = el;

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
    }
}
</script>
