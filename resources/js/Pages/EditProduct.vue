<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";
import '@fortawesome/fontawesome-free/css/all.min.css'
import {useRouter, useRoute} from "vue-router";
import router from "../router/index.js";

const route = useRoute();
const routes = useRouter();
const product = ref({
    name: '',
    price: '',
    category_id: '',
    description: ''
});
const categories = ref([])

const fetchProduct = async () => {
    try {
        console.log(route.params)
        const response = await axios.get(`/api/show/${route.params.id}`);
        console.log(response.data)
        product.value = response.data.data;
    } catch (error) {
        console.error(error);
    }
};

const fetchCategories = async () => {
    try {
        const response = await axios.get('/api/categories');
        categories.value = response.data.data;
    } catch (error) {
        console.error(error);
    }
};

const updateProduct = async () => {
    try {
        console.log(product)
        await axios.put(`/api/products/${route.params.id}`, product.value);
        // router.push('/products');
    } catch (error) {
        console.error(error);
    }
};

onMounted(() => {
    fetchProduct();
    fetchCategories();
});
</script>

<template>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Edit Product</h2>
        <form @submit.prevent="updateProduct" class="form-card shadow-lg p-4 rounded">
            <div class="form-group mb-4">
                <label for="name" class="form-label">Name:</label>
                <input type="text" v-model="product.name" id="name" class="form-control" placeholder="Enter product name" />
            </div>
            <div class="form-group mb-4">
                <label for="description" class="form-label">Description:</label>
                <input type="text" v-model="product.description" id="description" class="form-control" placeholder="Enter product description" />
            </div>
            <div class="form-group mb-4">
                <label for="price" class="form-label">Price:</label>
                <input type="number" v-model="product.price" id="price" class="form-control" placeholder="Enter product price" />
            </div>
            <div class="form-group mb-4">
                <label for="category" class="form-label">Category:</label>
                <select v-model="product.category_id" id="category" class="form-select">
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Update Product</button>
        </form>
    </div>
</template>

<style scoped>
.container {
    max-width: 800px;
    margin: 0 auto;
}

h2 {
    font-size: 2rem;
    color: #333;
    margin-bottom: 1rem;
}

.form-card {
    background-color: #f9f9f9;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: bold;
    color: #555;
}

.form-control,
.form-select {
    border-radius: 8px;
    border: 1px solid #dcdcdc;
    padding: 0.5rem 0.75rem;
    font-size: 1rem;
}

.form-control:focus,
.form-select:focus {
    border-color: #a2b5e2;
    box-shadow: 0 0 0 0.2rem rgba(162, 181, 226, 0.25);
}

.btn-primary {
    background-color: #b2d8b2; /* Мягкий зеленый цвет */
    border: 1px solid #a2c4a2;
    border-radius: 8px;
    padding: 0.75rem;
    font-size: 1rem;
    font-weight: 600;
    color: #333;
    transition: background-color 0.3s, border-color 0.3s;
}

.btn-primary:hover {
    background-color: #9bc89b;
    border-color: #89b589;
}
</style>

