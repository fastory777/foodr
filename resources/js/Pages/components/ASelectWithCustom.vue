<template>
    <div class="flex flex-wrap gap-2 items-end mb-4">
        <div class="flex-1 min-w-[150px]">
            <label class="block text-sm text-gray-700 dark:text-gray-200 mb-1">Ingredient</label>
            <select
                v-model="local.id"
                class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white"
            >
                <option disabled value="">Select</option>
                <option v-for="option in options" :key="option.value" :value="option.value">
                    {{ option.label }}
                </option>
            </select>
        </div>

        <div class="w-28">
            <label class="block text-sm text-gray-700 dark:text-gray-200 mb-1">Amount</label>
            <input
                v-model="local.amount"
                type="number"
                min="0"
                step="any"
                placeholder="100"
                class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white"
            />
        </div>


        <div class="w-24">
            <label class="block text-sm text-gray-700 dark:text-gray-200 mb-1">Unit</label>
            <select v-model="local.unit" class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
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

export default {
    name: 'ASelectWithCustom',
    components: { CirclePlus, CircleMinus },
    props: {
        modelValue: Object,
        isLast: Boolean,
        options: Array, // [{ label: 'Sugar', value: 1 }, ...]
    },
    emits: ['update:modelValue', 'add', 'remove'],
    data() {
        return {
            local: {
                id: '',
                amount: '',
                unit: 'g',
                ...this.modelValue,
            },
        };
    },
    watch: {
        local: {
            deep: true,
            handler(val) {
                this.$emit('update:modelValue', val);
            },
        },
    },
};
</script>

