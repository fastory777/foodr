<template>
    <div class="mb-4 last:mb-0">
        <div class="flex gap-2 items-center">
            <div class="flex-1">
                <label class="block text-sm text-gray-700 dark:text-gray-200 h-6">
                    Name
                </label>
                <Dropdown
                    v-model="localId"
                    :options="options"
                    optionLabel="label"
                    optionValue="value"
                    filter
                    placeholder="Select an ingredient"
                    class="w-full"
                    :pt="{
                        root: {
                            class: errors?.id ? '!border-red-500 !border' : '',
                        },
                    }"
                />
            </div>

            <div class="flex flex-col w-18">
                <label class="block text-sm text-gray-700 dark:text-gray-200 h-6">
                    Amount
                </label>
                <input
                    v-model="localAmount"
                    type="number"
                    min="0"
                    step="any"
                    placeholder="100"
                    class="p-2 border rounded dark:bg-gray-700 dark:text-white text-right"
                    :class="{'border border-red-500': errors?.amount}"
                />
            </div>

            <div class="flex flex-col w-18">
                <label class="block text-sm text-gray-700 dark:text-gray-200 h-6">
                    Unit
                </label>
                <select v-model="localUnit"
                        class="p-2 border rounded dark:bg-gray-700 dark:text-white"
                        :class="{'border-red-500': errors?.unit}">
                    <option value="g">g</option>
                    <option value="kg">kg</option>
                    <option value="ml">ml</option>
                </select>
            </div>

            <div class="flex flex-col">
                <div class="h-6"></div>
                <Button
                    severity="danger"
                    @click="$emit('remove')"
                >
                    <X size="0.9em" color="white" />
                </Button>
            </div>
        </div>

        <ul class="text-red-500 text-xs py-1" v-if="errors">
            <li v-if="errors?.id">
                {{ errors.id }}
            </li>
            <li v-if="errors?.amount">
                {{ errors.amount }}
            </li>
            <li v-if="errors?.unit">
                {{ errors.unit }}
            </li>
        </ul>
    </div>
</template>

<script>
import { X } from 'lucide-vue-next';
import Dropdown from 'primevue/dropdown';

export default {
    name: 'ASelectWithCustom',
    components: { X, Dropdown },
    emits: ['update:modelValue', 'remove'],
    props: {
        modelValue: {
            type: Object,
            required: true
        },
        errors: Object,
        options: Array, // [{ label: 'Sugar', value: 1 }, ...]
    },

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
