<template>
    <Layout>
        <form @submit.prevent="submit" class="container mx-auto p-5">
            <h1 class="text-3xl font-semibold mb-12">Edit Dish</h1>

            <div class="max-w-xl">
                <AInput v-model="form.name" name="name" label="Name" :error="form.errors?.name" />

                <AImageUpload
                    class="mb-4"
                    v-model="form.image"
                    name="image"
                    label="Replace Image"
                    hint="Leave empty to keep existing image"
                    preview-size="200px"
                />

                <ATextArea
                    class="mb-4"
                    v-model="form.description"
                    name="description"
                    label="Description"
                    :error="form.errors?.description"
                />

                <div class="mb-4">
                    <label class="block font-medium text-gray-800 dark:text-white mb-2">Ingredients</label>

                    <ASelectWithCustom
                        v-for="(ingredient, index) in form.ingredients"
                        :key="index"
                        :modelValue="ingredient"
                        :options="ingredientOptions"
                        :isLast="index === form.ingredients.length - 1"
                        @update:modelValue="updateIngredient(index, $event)"
                        @add="addIngredient"
                        @remove="removeIngredient(index)"
                    />
                    <!--
                    // When a user changes an ingredient ASelectWithCustom component emits the update:modelValue event, and i catch this event.
                    // Pass the current index and the new ingredient value to the updateIngredient method (via $event).
                    -->
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-800 dark:text-white mb-2">Preparation Steps</label>

                    <APreparationStepEditor
                        v-for="(step, index) in form.preparation_steps"
                        :key="index"
                        v-model="form.preparation_steps[index]"
                        :isLast="index === form.preparation_steps.length - 1"
                        @add="addStep"
                        @remove="removeStep(index)"
                    />
                </div>

                <AInput v-model="form.tips" name="tips" label="Tips" :error="form.errors?.tips" />

                <div class="flex justify-end gap-x-4 mt-6">
                    <AButton class="bg-gray-200 text-blue-700 dark:bg-gray-200 dark:text-blue-700" :href="`/`">Cancel</AButton>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 cursor-pointer">
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </Layout>
</template>




<script>
import { useForm } from '@inertiajs/vue3';
import Layout from '../Layout.vue';
import AInput from "../components/AInput.vue";
import AImageUpload from "../components/AImageUpload.vue";
import ATextArea from "../components/ATextArea.vue";
import ASelectWithCustom from "../components/ASelectWithCustom.vue";
import APreparationStepEditor from "../components/APreparationStepEditor.vue";
import AButton from "../components/AButton.vue";

export default {
    name: 'Edit',
    components: {
        Layout,
        AInput,
        AImageUpload,
        ATextArea,
        ASelectWithCustom,
        APreparationStepEditor,
        AButton
    },
    props: {
        dish: Object,
        ingredients: Array
    },
    data() {
        return {
            form: useForm({
                name: this.dish.name ?? '',
                description: this.dish.description ?? '',
                image: null,
                tips: this.dish.tips ?? '',
                ingredients: (this.dish.ingredients ?? []).map(i => ({ // we take the id, amount and unit and assemble them into a new object to give to the form.
                    id: i.id,
                    amount: i.pivot?.amount ?? '',
                    unit: i.pivot?.unit ?? 'g'
                })),
                preparation_steps: (this.dish.preparationSteps ?? []).map(s => ({
                    instruction: s.instruction ?? '',
                    image: null
                }))
            }),
            ingredientOptions: this.ingredients.map(i => ({
                label: i.name,
                value: i.id
            }))
        };
    },
    methods: {
        submit() {
            console.log('Submit called');
            this.form.put(`/dish/${this.dish.id}`);
        },
        addIngredient() {
            this.form.ingredients.push({ id: null, amount: '', unit: 'g' });
        },
        removeIngredient(index) {
            this.form.ingredients.splice(index, 1);
        },
        updateIngredient(index, value) {
            this.form.ingredients.splice(index, 1, value);
        },
        addStep() {
            this.form.preparation_steps.push({ instruction: '', image: null });
        },
        removeStep(index) {
            this.form.preparation_steps.splice(index, 1);
        }
    }
};
</script>
