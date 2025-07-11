<template>
    <Layout>
        <div class="container mx-auto p-5">
            <h1 class="text-3xl font-semibold mb-12">Create a new Dish</h1>
            <Form :form="form" :ingredientOptions="ingredientOptions" @submit="submit"/>
        </div>
    </Layout>
</template>


<script>
import Layout from "../Layout.vue";
import {useForm} from "@inertiajs/vue3";
import Form from "./Form.vue";

export default {
    name: 'Create',
    components: {Layout, Form},
    props: {ingredients: Array},
    data() {
        return {
            form: useForm({
                name: '',
                description: '',
                image: null,
                tips: '',
                ingredients: [{id: null, amount: '', unit: 'g'}],
                preparation_steps: [{instruction: '', image: null}]
            }),
            ingredientOptions: this.ingredients.map(i => ({
                label: i.name,
                value: i.id
            }))
        };
    },
    methods: {
        submit() {
            this.form.post('/dish');
        }
    }
};
</script>
