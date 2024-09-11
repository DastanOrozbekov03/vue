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
    <div class="container mt-5">
        <h2 class="text-center mb-4">Register</h2>
        <form @submit.prevent="register" class="w-50 mx-auto border p-4 rounded shadow-sm bg-light">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" v-model="registerData.name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" v-model="registerData.email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" v-model="registerData.password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
    </div>
</template>

<style scoped>
/* Основной контейнер */
.container {
    max-width: 600px;
    margin: 0 auto;
    padding: 30px;
    background-color: #f9f9f9; /* Легкий фон для страницы */
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
    border-radius: 12px; /* Скругленные углы */
    padding: 2rem;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); /* Легкая тень */
    transition: box-shadow 0.3s ease, transform 0.3s ease; /* Плавный переход */
}

/* Эффект при наведении на форму */
form:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Увеличенная тень при наведении */
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

/* Эффект при фокусе на полях ввода */
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

/* Эффект при наведении на кнопку */
.btn-primary:hover {
    background: linear-gradient(135deg, #d83a56, #ff6f61); /* Градиент при наведении */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); /* Увеличенная тень при наведении */
}
</style>


