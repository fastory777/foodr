<template>
    <Layout>
        <form @submit.prevent="submit">
            <div class="flex flex-col container mx-auto p-5">
                <h1 class="text-3xl font-semibold mb-12">
                    Create a new Dish
                </h1>

                <div class="max-w-xl">
                    {{ form?.errors }}
                    <AInput
                        v-model="form.name"
                        name="name"
                        label="Name"
                        :error="form.errors?.name"
                    />

                    <AImageUpload
                        class="mb-4"
                        v-model="form.image"
                        name="image"
                        label="Upload Image"
                        hint="SVG, PNG or JPG (MAX. 10 MB)"
                        preview-size="200px"
                    />

                    <ATextArea
                        class="mb-4"
                        v-model="form.description"
                        name="decription"
                        label="Description"
                        :error="form.errors?.description"
                        placeholder="Write about the dish here..."
                    />

                    <div class="mb-4">
                        <label class="block font-medium text-gray-800 dark:text-white mb-2">Ingredients</label>

                        <ASelectWithCustom
                            v-for="(ingredient, index) in form.ingredients"
                            :key="index"
                            v-model="form.ingredients[index]"
                            :options="ingredientOptions"
                            :isLast="index === form.ingredients.length - 1"
                            @add="addIngredient"
                            @remove="removeIngredient(index)"
                        />
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-gray-800 dark:text-white mb-2">Preparation Steps</label>

                        <AddPreparationStep
                            v-for="(step, index) in form.preparation_steps"
                            :key="index"
                            v-model="form.preparation_steps[index]"
                            :isLast="index === form.preparation_steps.length - 1"
                            @add="addStep"
                            @remove="removeStep(index)"
                        />
                    </div>

                    <AInput
                        v-model="form.tips"
                        name="tips"
                        label="Tips"
                        :error="form.errors?.tips"
                    />

                    <div class="flex py-5 gap-x-4 justify-end">
                        <AButton class="bg-gray-200 text-blue-700 dark:bg-gray-200 dark:text-blue-700 " :href="`/`">
                            Cancel
                        </AButton>

                        <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg focus:ring-4 focus:outline-none bg-blue-700 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 hover:bg-blue-800">
                            Add Dish
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </Layout>
</template>

<script>
import { CircleMinus, CirclePlus } from 'lucide-vue-next';
import { useForm } from '@inertiajs/vue3';
import Layout from '../Layout.vue';
import AButton from "../components/AButton.vue";
import AInput from "../components/AInput.vue";
import AImageUpload from "../components/AImageUpload.vue";
import ATextArea from "../components/ATextArea.vue";
import ASelectWithCustom from "../components/ASelectWithCustom.vue";
import APreparationStepEditor from "../components/APreparationStepEditor.vue";

export default {
    name: 'Create',
    components: {
        Layout,
        ATextArea,
        AInput,
        AButton,
        AImageUpload,
        ASelectWithCustom,
        AddPreparationStep: APreparationStepEditor,
        CircleMinus,
        CirclePlus,
    },
    data() {
        return {
            form: useForm({
                name: '',
                description: '',
                image: null,
                ingredients: [{ id: '', amount: '', unit: 'g' }],
                preparation_steps: [{ instruction: '', image: null }],
                tips: '',
                history: '',
            }),
            ingredientOptions: [
                { label: 'Sugar', value: 1 },
                { label: 'Salt', value: 2 },
                { label: 'Pumpkin', value: 3 },
            ],
        };
    },
    methods: {
        submit() {
            console.log('Ингредиенты:', JSON.stringify(this.form.ingredients, null, 2));
            this.form.post('/dish');
        },
        addIngredient() {
            this.form.ingredients.push({ id: null, amount: '', unit: 'g' });
        },
        removeIngredient(index) {
            this.form.ingredients.splice(index, 1);
        },
        addStep() {
            this.form.preparation_steps.push({ instruction: '', image: null });
        },
        removeStep(index) {
            this.form.preparation_steps.splice(index, 1);
        },
    }
}
</script>
