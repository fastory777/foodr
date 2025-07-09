<template>
    <div class="flex flex-wrap gap-2 items-end mb-4">
        <div class="flex-1 min-w-[150px]">
            <label class="block text-sm text-gray-700 dark:text-gray-200 mb-1">Ingredient</label>
            <Dropdown
                v-model="localId"
                :options="options"
                optionLabel="label"
                optionValue="value"
                filter
                placeholder="Select an ingredient"
                class="w-full"
                :pt="{
                    root: 'border-2 rounded focus:ring-2 dark:border-[#5ddcff] border-[#3aaaff]',
                    input: 'bg-white text-black dark:bg-[#121212] dark:text-white',
                    panel: 'bg-white dark:bg-[#1e1e1e] border dark:border-[#444] shadow-md',
                    filterInput: 'bg-white dark:bg-[#121212] text-black dark:text-white placeholder-gray-400 p-2 rounded',
                    item: ({ context }) => ({
                        class: [
                            'px-3 py-2 cursor-pointer transition-colors',
                            context.selected
                              ? 'bg-[#3aaaff] text-white dark:bg-[#2d9cdb]'
                              : 'hover:bg-[#e0f2ff] dark:hover:bg-[#2a2a2a] text-black dark:text-white'
                        ]
                    })
                }"
            />

        </div>

        <div class="w-28">
            <label class="block text-sm text-gray-700 dark:text-gray-200 mb-1">Amount</label>
            <input
                v-model="localAmount"
                type="number"
                min="0"
                step="any"
                placeholder="100"
                class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white"
            />
        </div>

        <div class="w-24">
            <label class="block text-sm text-gray-700 dark:text-gray-200 mb-1">Unit</label>
            <select v-model="localUnit" class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
                <option value="g">g</option>
                <option value="kg">kg</option>
                <option value="ml">ml</option>
            </select>
        </div>

        <div class="w-10 h-10 mb-1">
            <button
                type="button"
                @click="isLast ? $emit('add') : $emit('remove')"
                class="w-full h-full flex items-center justify-center text-white"
            >
                <CirclePlus v-if="isLast" class="w-5 h-5 cursor-pointer" />
                <CircleMinus v-else class="w-5 h-5 cursor-pointer" />
            </button>
        </div>
    </div>
</template>

<script>
import { CircleMinus, CirclePlus } from "lucide-vue-next";
import Dropdown from 'primevue/dropdown';

export default {
    name: 'ASelectWithCustom',
    components: { CirclePlus, CircleMinus, Dropdown },
    props: {
        modelValue: {
            type: Object,
            required: true
        },
        isLast: Boolean,
        options: Array, // [{ label: 'Sugar', value: 1 }, ...]
    },
    emits: ['update:modelValue', 'add', 'remove'],
    computed: {
        localId: {
            get() {
                return this.modelValue.id;
            },
            set(value) {
                this.update('id', value);
            }
        },
        localAmount: {
            get() {
                return this.modelValue.amount;
            },
            set(value) {
                this.update('amount', value);
            }
        },
        localUnit: {
            get() {
                return this.modelValue.unit;
            },
            set(value) {
                this.update('unit', value);
            }
        }
    },
    methods: {
        update(field, value) {
            this.$emit('update:modelValue', {
                ...this.modelValue,
                [field]: value
            });
        }
    }
};
</script>
