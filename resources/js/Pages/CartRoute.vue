<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";

const products = ref();

const getProductFromCart = async () => {
    try {
        const response = await axios.get('/api/cart');
        products.value = response.data;
    } catch (error) {
        console.error("Error fetching products from cart:", error);
    }
}

onMounted(async () => {
    getProductFromCart();
})
</script>

<template>
    <div>
        <h1>Cart</h1>
        <table class="table" border="1" cellpadding="10">
            <thead>
            <tr>
                <th>Product ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Quantity</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="product in products" :key="product.id">
                <td>{{ product.id }}</td>
                <td>{{ product.name }}</td>
                <td>$ {{ product.price }}</td>
                <td>{{ product.category }}</td>
                <td>{{ product.quantity }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped>

</style>
