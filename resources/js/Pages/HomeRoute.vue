<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";

const response = ref(null);
const products = ref([]);
const user = ref({
    name: ''
})

onMounted(async () => {
    try {
        const result = (await axios.get("/api/products")).data;
        products.value = result.data;
    } catch (error) {
        console.error('Error fetching products:', error);
    }

    if (localStorage.getItem('token')) {
        axios.get('/api/user', {
            headers: {
                Authorization: 'Bearer ' + localStorage.getItem('token')
            }
        }).then(res => {
            user.value = res.data
        }).catch(() => {
        })
    }

    console.log(localStorage.getItem('token'))
});

const getValue = async () => {
    try {
        response.value = await axios.get("/api/products");
        // console.log(await axios.get("api/products"));

    } catch (error) {
        console.log('Error fetching data:', error);
    }
};

const addProductToCart = async (id) => {
    try {
        await axios.post(`api/cart/add/${id}`);
        alert('Product added to cart successfuly');
    } catch (error) {
        console.error('Error adding product to cart:', error);
        alert('Failed to add product to cart')
    }
};

const triggerEndpoint = () => {
    getValue();
};


</script>

<template>
    <div>
        <h1>HOME</h1>
        <router-link to="/auth">register
        </router-link>
        <br>
        <router-link to="/login">login</router-link>
        <br>
        <router-link to="/category">Category</router-link>
        <br>
        <router-link to="/create_product">Create Product</router-link>
        <br>
        <router-link to="/cart">Cart</router-link>
        <br>
        <button @click.prevent="triggerEndpoint">Trigger Endpoint</button>
        <p v-if="response">{{ response.data }}</p>

        <table class="table" border="1" cellpadding="10">
            <thead>
                <tr>
                    <th class="text-bg-success">Product ID</th>
                    <th class="text-bg-primary">Name</th>
                    <th class="text-bg-danger">Price</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products" :key="product.id">
                    <td class="table-active">{{product.id}}</td>
                    <td>{{product.name}}</td>
                    <td>$ {{product.price}}</td>
                    <td>{{ product.category_id }}</td>
                    <td>
                        <button @click.prevent="() => addProductToCart(product.id)">Add to cart</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>


    <div>
    <h4>{{ user.name }}</h4>
    </div>
</template>
