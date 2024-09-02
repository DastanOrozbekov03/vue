<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";

const data = ref({
    email: '',
    password: '',
})

const errors = ref({
    email: '',
    password: '',
});
const login = async () => {
    await axios.post('/api/login', {
        email: data.value.email,
        password: data.value.password,
    }).then((res) => {
        localStorage.setItem('token', res.data.access_token);

        sessionStorage.setItem('token', res.data.access_token)

        console.log(res.data.access_token)
        console.log('login successful');
    }).catch(error => {
        if (error.responce?.data.errors) {
            Object.keys(error.response.data.errors).map(key => {
                errors.value[key] = error.response.data.errors[key][0]
                errors.value.fatal = error.response.data.errors[key][0]
            })
        }
        console.log(errors)
        console.log('something was wrong')
    });
}
</script>

<template>
    <div>
        <h2>Login</h2>
        <form @submit.prevent="login" class="w-25">
            <div>
                <label for="email">Email</label>
                <input v-model="data.email" type="email" required>
                <span v-if="errors.email">{{ errors.email }}</span>
            </div>
            <div>
                <label for="password">password</label>
                <input v-model="data.password" type="password" required>
                <span v-if="errors.password">{{ errors.password }}</span>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</template>

<style scoped>

</style>
