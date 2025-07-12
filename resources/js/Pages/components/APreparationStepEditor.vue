<template>
    <div
        class="relative w-full border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 mb-4 p-4 space-y-3">
        <h3 class="flex items-center justify-between font-bold text-lg border-b border-b-gray-300 pt-1 pb-3">
            Step {{ index + 1 }}

            <Button
                :pt="{ root: '!text-white font-normal' }"
                severity="danger"
                size="small"
                @click="$emit('remove')"
            >
                <X size=".8rem" />
                Remove
            </Button>
        </h3>

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
        <div class="mb-4">
            <textarea
                ref="textAreaRef"
                v-model="modelValue.instruction"
                rows="5"
                class="mb-0 w-full p-2 text-sm text-gray-800 dark:text-white bg-white dark:bg-gray-800 border rounded focus:ring-blue-500 focus:border-blue-500 resize-y"
                :class="{ '!border-red-400': errors?.instruction }"
                placeholder="Describe the step..."
            ></textarea>
            <span v-if="errors?.instruction" class="text-red-500 text-sm">
                {{ errors.instruction }}
            </span>
        </div>

        <!-- Duration time -->
        <div class="flex flex-col">
            <label class="text-sm text-gray-700 dark:text-gray-200 mb-1">
                Duration (in minutes)
            </label>
            <input
                v-model="localDuration"
                type="number"
                min="0"
                step="any"
                placeholder="100"
                class="flex-1 w-full p-2 border rounded dark:bg-gray-700 dark:text-white"
                :class="{ '!border-red-500': errors.duration_minutes }"
            />
            <span v-if="errors?.duration_minutes" class="text-red-500 text-sm">
                {{ errors.duration_minutes }}
            </span>
        </div>

        <!-- Image Uploading -->
        <div class="flex flex-col gap-2">
            <AImageUpload
                :modelValue="modelValue.image"
                @update:modelValue="updateImage"
                name="preparation-step-image"
                label="Upload Image"
                hint="Click or drag a single image"
                :error="errors?.image"
            />
        </div>

        <!-- Existing image preview (for edit mode) -->
        <div v-if="modelValue.image" class="mt-2">
            <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">Current image:</p>
            <img :src="modelValue.image" class="w-40 rounded border dark:border-gray-500"/>
        </div>
    </div>
</template>

<script>
import {X, Bold, Signature} from 'lucide-vue-next';
import AImageUpload from './AImageUpload.vue';

export default {
    name: 'APreparationStepEditor',
    components: { X, Bold, Signature, AImageUpload},
    props: {
        modelValue: Object,
        index: Number,
        errors: Object,
    },
    emits: ['update:modelValue', 'add', 'remove'],
    methods: {
        // Used for the markdown editor
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
