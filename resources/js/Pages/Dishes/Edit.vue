<template>
    <Layout>
        <div class="container mx-auto p-5">
            <h1 class="text-3xl font-semibold mb-12">Edit Dish</h1>

            <Form :form="form"
                  :dish="dish"
                  :ingredients="ingredients"
                  @submit="submit"/>
        </div>
    </Layout>
</template>


<script>
import Layout from "../Layout.vue";
import {useForm} from "@inertiajs/vue3";
import Form from "../components/Form.vue";
import {route} from 'ziggy-js';

export default {
    name: 'Edit',
    components: {Layout, Form},
    props: ['dish', 'ingredients'],
    data() {
        return {
            form: useForm({
                name: this.dish.name ?? '',
                description: this.dish.description ?? '',
                image: null,
                image_url: this.dish.image ?? null,
                tips: this.dish.tips ?? '',
                ingredients: (this.dish.ingredients ?? []).map(ingredient => ({
                    id: ingredient.id,
                    amount: ingredient.amount,
                    unit: ingredient.unit,
                })),
                preparation_steps: this.dish.preparation_steps.map(step => ({
                    instruction: step.instruction,
                    image: step.image,
                    duration_minutes: step.duration_minutes,
                }))
            }),

            ingredients: this.ingredients.map(ingredient => ({
                label: ingredient.name,
                value: ingredient.id
            }))
        };
    },
    methods: {
        submit() {
            this.form.post(route('dishes.update', this.dish.id), {
                preserveScroll: true,
                forceFormData: true,
                onError: (errors) => {
                    console.error('Validation errors: ', errors);
                }
            });
        }
    }
};
</script>
