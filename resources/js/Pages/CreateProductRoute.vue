<script setup>
import axios from "axios";
import {ref, onMounted} from "vue";
import data from "bootstrap/js/src/dom/data.js";

const product = ref(
    {
        name: '',
        price: null,
        description: '',
        category_id: ''

    }
)

const categories = ref([]);
const fetchCategories = async () => {
    try {
        const response = await axios.get('http://127.0.0.1:8000/api/categories');
        categories.value = response.data.data;
        console.log(categories.value)
    } catch (error) {
        console.error('Error ', error)
    }
};

onMounted(() => {
    fetchCategories();
})

const addProduct = async () => {
    try {
        const response = await axios.post('http://127.0.0.1:8000/api/products/create', product.value);
        console.log('Product added:', response.data);

        product.value = {
            name: '',
            description: '',
            price: null,
            category_id: ''
        };
    } catch (error) {
        console.log('Error', error)
    }
};
</script>

<template>
    <div>
        <h1>Create New Product</h1>
        <form @submit.prevent="addProduct" class="m-5">
            <div>
                <label>name</label>
                <input type="text" class="form-control w-25" v-model="product.name">
            </div>
            <div>
                <label>price</label>
                <input type="text" class="form-control w-25" v-model="product.price">
            </div>
            <div>
                <label>description</label>
                <input type="text" class="form-control w-25" v-model="product.description">
            </div>
            <div>
                <label>category</label>
                <select class="form-control w-25" v-model="product.category_id">
                    <template v-for="category in categories" :key="category.id">
                        <option :value="category.id">
                            {{ category.name }}
                        </option>

                    </template>
                </select>
            </div>
            <button type="submit">add</button>
        </form>
    </div>


</template>

<style scoped>

</style>
