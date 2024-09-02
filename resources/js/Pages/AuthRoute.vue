<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";



const registerData = ref({
    name: '',
    email: '',
    password: '',
})

const errors = ref({
    email: '',
    password: '',
});
const register = async () => {
    await axios.post('/api/register', registerData.value).then((res) => {
        localStorage.setItem('token', res.data.access_token);
    }).catch(error => {
        if (error.responce?.data.errors) {
            Object.keys(error.response.data.errors).map(key => {
                errors.value[key] = error.response.data.errors[key][0]
                errors.value.fatal = error.response.data.errors[key][0]
            })
        }
        console.log('something was wrong')
    });
}



</script>

<template>
<div>
    <h2>Register</h2>
    <form @submit.prevent="register" class="w-25">
        <div>
            <label for="name">Name</label>
            <input type="text" v-model="registerData.name" required>
        </div>
        <div>
            <label for="email">email</label>
            <input type="email" v-model="registerData.email" required>
        </div>
        <div>
            <label for="password">password</label>
            <input type="password" v-model="registerData.password" required>
        </div>
        <button type="submit">Register</button>
    </form>
</div>

</template>

<style scoped>

</style>
