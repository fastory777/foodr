<template>
    <form @submit.prevent="$emit('submit')">
        <div class="max-w-xl">
            <AInput v-model="form.name" name="name" label="Name" :error="form.errors.name"/>

            <AImageUpload
                class="mb-4"
                v-model="form.image"
                :preview="form.image_url"
                name="image"
                label="Upload Image"
                hint="SVG, PNG or JPG (MAX. 10 MB)"
                preview-size="200px"
            />

            <div v-if="form.image === null && form.image_url" class="mb-4">
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">Current image:</p>
                <img :src="form.image_url" alt="Current Dish Image" class="w-40 rounded border dark:border-gray-500"/>
            </div>

            <ATextArea
                class="mb-4"
                v-model="form.description"
                name="description"
                label="Description"
                :error="form.errors.description"
                placeholder="Write about the dish here..."
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
                    @update:modelValue="val => updateStep(index, val)"
                />
            </div>

            <AInput
                v-model="form.tips"
                name="tips"
                label="Tips"
                :error="form.errors?.tips"
            />

            <div class="flex py-5 gap-x-4 justify-end">
                <AButton
                    class="bg-gray-200 text-indigo-500 dark:bg-gray-100 dark:text-indigo-500 dark:hover:bg-gray-200 dark:hover:text-indigo-600 focus:ring-indigo-500"
                    :href="`/`"
                >
                    Cancel
                </AButton>

                <button
                    type="submit"
                    class="cursor-pointer inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg focus:ring-4 focus:outline-none bg-indigo-600 focus:ring-indigo-200 dark:bg-indigo-500 dark:hover:bg-indigo-600 dark:hover:text-gray-200 hover:bg-indigo-700"
                >
                    Save Dish
                </button>
            </div>
        </div>
    </form>
</template>


<script>
import AInput from "./AInput.vue";
import AImageUpload from "./AImageUpload.vue";
import ATextArea from "./ATextArea.vue";
import ASelectWithCustom from "./ASelectWithCustom.vue";
import APreparationStepEditor from "./APreparationStepEditor.vue";
import AButton from "./AButton.vue";

export default {
    name: 'Form',
    components: {
        AInput,
        AImageUpload,
        ATextArea,
        ASelectWithCustom,
        APreparationStepEditor,
        AButton
    },
    props: {
        form: Object,
        ingredientOptions: Array
    },
    emits: ['submit'],
    methods: {
        addIngredient() {
            this.form.ingredients.push({id: null, amount: '', unit: 'g'});
        },
        removeIngredient(index) {
            this.form.ingredients.splice(index, 1);
        },
        updateIngredient(index, value) {
            this.form.ingredients.splice(index, 1, value);
        },
        addStep() {
            this.form.preparation_steps.push({instruction: '', image: null});
        },
        removeStep(index) {
            this.form.preparation_steps.splice(index, 1);
        },
        updateStep(index, value) {
            this.form.preparation_steps.splice(index, 1, value);
        }
    }
};
</script>



