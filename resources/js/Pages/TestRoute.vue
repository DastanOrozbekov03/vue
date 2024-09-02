<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";

const categories = ref([]);
const title = ref()

onMounted(async () => {
    try {
        const result = (await axios.get("/api/categories")).data;
        console.log("Fetched Categories:", result);
        categories.value = result.data
    } catch (error) {
        console.error('Error fetching products:', error)
    }
});

const send = async () => {
    await axios.post('http://127.0.0.1:8000/api/categories',  {name: title.value})}
</script>

<template>
    <div>
    <input type="text" name="title" v-model="title">
        <button @click="send()">Create</button>
    </div>
    <br>
    <div>
        <table class="table">
            <thead>
            <tr>
                <th>id</th>
                <th>name</th>
            </tr>
            </thead>
            <tbody class="table-group-divider">
            <tr v-for="category in categories" :key="categories.id">
                <td class="text-body-tertiary">{{ category.id }}</td>
                <td>{{ category.name }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped>

</style>
