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
    <div class="container mt-5">
        <div class="mb-4">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Enter category name" v-model="title">
                <button class="btn btn-primary ms-2" @click="send">Create</button>
            </div>
        </div>

        <div>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="category in categories" :key="category.id">
                    <td>{{ category.id }}</td>
                    <td>{{ category.name }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>
/* Основной контейнер */
.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 30px;
    background-color: #fafafa; /* Очень светлый фон для современного вида */
    font-family: 'Noto Sans', sans-serif; /* Японский шрифт */
}

/* Группировка ввода и кнопки */
.input-group {
    margin-bottom: 1.5rem; /* Отступ снизу */
}

.form-control {
    background-color: #ffffff; /* Белый фон для полей ввода */
    border: 1px solid #dcdcdc; /* Легкая граница */
    border-radius: 8px; /* Скругленные углы */
    padding: 0.75rem 1rem;
    font-size: 1rem;
    color: #333;
    transition: border-color 0.3s ease, box-shadow 0.3s ease; /* Плавный переход для границы и тени */
}

.form-control:focus {
    border-color: #ff6f61; /* Яркий акцентный цвет при фокусе */
    outline: none; /* Убираем стандартное выделение при фокусе */
    box-shadow: 0 0 5px rgba(255, 111, 97, 0.5); /* Тень при фокусе */
}

/* Кнопка */
.btn-primary {
    background: linear-gradient(135deg, #ff6f61, #d83a56); /* Яркий градиентный фон */
    border: none; /* Убираем границу */
    border-radius: 8px; /* Скругленные углы */
    padding: 0.75rem 1.5rem;
    font-size: 1.125rem;
    font-weight: 600;
    color: #ffffff; /* Белый цвет текста */
    transition: background 0.3s ease, box-shadow 0.3s ease; /* Плавный переход для фона и тени */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Мягкая тень */
}

.btn-primary:hover {
    background: linear-gradient(135deg, #d83a56, #ff6f61); /* Градиент при наведении */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); /* Увеличенная тень при наведении */
}

/* Таблица */
.table {
    background-color: #ffffff; /* Белый фон для таблицы */
    border-radius: 8px; /* Скругленные углы */
    overflow: hidden; /* Убираем скроллы */
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f5f5f5; /* Легкий серый фон для нечетных строк */
}

.table-dark thead th {
    background-color: #333; /* Темный фон для заголовков таблицы */
    color: #fff; /* Белый цвет текста */
    font-weight: 700;
}

.table-bordered {
    border: 1px solid #e0e0e0; /* Легкая граница */
}

.table-bordered th, .table-bordered td {
    border: 1px solid #e0e0e0; /* Граница ячеек таблицы */
    padding: 0.75rem; /* Отступы в ячейках */
}

.text-center {
    text-align: center;
}

.mb-4 {
    margin-bottom: 1.5rem;
}

.ms-2 {
    margin-left: 0.5rem;
}
</style>


