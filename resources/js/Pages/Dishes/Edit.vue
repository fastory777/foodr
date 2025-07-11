<template>
    <Layout>
        <div class="container mx-auto p-5">
            <h1 class="text-3xl font-semibold mb-12">Edit Dish</h1>
            <Form v-if="form" :form="form" :ingredientOptions="ingredientOptions" @submit="submit"/>
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
    props: {dish: Object, ingredients: Array},
    data() {
        return {
            form: useForm({
                name: this.dish.name ?? '',
                description: this.dish.description ?? '',
                image: null,
                image_url: this.dish.image_url ?? null,
                tips: this.dish.tips ?? '',
                ingredients: (this.dish.ingredients ?? []).map(i => ({
                    id: i.id,
                    amount: i.pivot?.amount ?? '',
                    unit: i.pivot?.unit ?? 'g'
                })),
                preparation_steps: (this.dish.preparation_steps ?? []).map((s, i) => ({
                    instruction: s.instruction ?? '',
                    image_path: s.image_path ?? null,
                    image: null,
                    duration_minutes: s.duration_minutes ?? 0,
                    step_number: i + 1
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
            this.form.preparation_steps = this.form.preparation_steps.map((step, index) => ({
                ...step,
                step_number: index + 1
            }));

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
