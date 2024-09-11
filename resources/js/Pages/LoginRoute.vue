<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";
import {useRouter} from "vue-router";

const data = ref({
    email: '',
    password: '',
})

const errors = ref({
    email: '',
    password: '',
});
const router = useRouter();

const login = async () => {
    await axios.post('/api/login', {
        email: data.value.email,
        password: data.value.password,
    }).then((res) => {
        localStorage.setItem('token', res.data.access_token);

        sessionStorage.setItem('token', res.data.access_token)


        console.log(res.data.access_token)
        console.log('login successful');
        router.push({path: '/products'});

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
    // await
}



</script>

<template>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Login</h2>
        <form @submit.prevent="login" class="w-50 mx-auto border p-4 rounded shadow-sm bg-light">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" v-model="data.email" type="email" class="form-control" required>
                <div v-if="errors.email" class="text-danger mt-2">{{ errors.email }}</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" v-model="data.password" type="password" class="form-control" required>
                <div v-if="errors.password" class="text-danger mt-2">{{ errors.password }}</div>
            </div>
             <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</template>
<style scoped>
/* Основной контейнер */
.container {
    max-width: 600px;
    margin: 0 auto;
    padding: 30px;
    background-color: #f5f5f5; /* Легкий фон для страницы */
    font-family: 'Noto Sans', sans-serif; /* Японский шрифт для элегантности */
}

/* Заголовок формы */
h2 {
    font-size: 2rem;
    color: #333;
    margin-bottom: 1.5rem;
    font-weight: 700;
}

/* Основная форма */
form {
    background: #ffffff; /* Белый фон для формы */
    border: 1px solid #dcdcdc; /* Легкая граница */
    border-radius: 10px; /* Скругленные углы */
    padding: 2rem;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Легкая тень */
    transition: box-shadow 0.3s ease, transform 0.3s ease; /* Плавный переход */
}

form:hover {
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Увеличенная тень при наведении */
    transform: translateY(-5px); /* Легкий подъем при наведении */
}

/* Поля ввода */
.form-control {
    background-color: #fafafa; /* Очень светлый фон для полей ввода */
    border: 1px solid #dcdcdc; /* Легкая граница */
    border-radius: 8px; /* Скругленные углы */
    padding: 0.75rem 1rem;
    font-size: 1rem;
    color: #333;
    transition: border-color 0.3s ease, box-shadow 0.3s ease; /* Плавный переход */
}

.form-control:focus {
    border-color: #ff6f61; /* Яркий акцентный цвет при фокусе */
    outline: none; /* Убираем стандартное выделение */
    box-shadow: 0 0 5px rgba(255, 111, 97, 0.5); /* Тень при фокусе */
}

/* Метки и ошибки */
.form-label {
    font-weight: 600;
    color: #333;
}

.text-danger {
    color: #e74c3c; /* Ярко-красный цвет для ошибок */
}

/* Кнопка */
.btn-primary {
    background: linear-gradient(135deg, #ff6f61, #d83a56); /* Градиентный фон */
    border: none; /* Убираем границу */
    border-radius: 8px; /* Скругленные углы */
    padding: 0.75rem;
    font-size: 1.125rem;
    font-weight: 600;
    color: #ffffff; /* Белый цвет текста */
    transition: background 0.3s ease, box-shadow 0.3s ease; /* Плавный переход */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Мягкая тень */
}

.btn-primary:hover {
    background: linear-gradient(135deg, #d83a56, #ff6f61); /* Градиент при наведении */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); /* Увеличенная тень при наведении */
}
</style>

