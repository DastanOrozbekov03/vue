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
        const response = await axios.get('api/categories');
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
    <div class="container mt-5">
        <h1 class="text-center mb-5">Create New Product</h1>
        <form @submit.prevent="addProduct" class="form-card shadow-lg p-4 rounded">
            <div class="form-group mb-4">
                <label for="productName" class="form-label">Name</label>
                <input type="text" id="productName" class="form-control" v-model="product.name" placeholder="Enter product name">
            </div>
            <div class="form-group mb-4">
                <label for="productPrice" class="form-label">Price</label>
                <input type="text" id="productPrice" class="form-control" v-model="product.price" placeholder="Enter product price">
            </div>
            <div class="form-group mb-4">
                <label for="productDescription" class="form-label">Description</label>
                <input type="text" id="productDescription" class="form-control" v-model="product.description" placeholder="Enter product description">
            </div>
            <div class="form-group mb-4">
                <label for="productCategory" class="form-label">Category</label>
                <select id="productCategory" class="form-select" v-model="product.category_id">
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Add Product</button>
            </div>
        </form>
    </div>
</template>

<style scoped>
/* Основной контейнер */
.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 30px;
    background-color: #f9f9f9; /* Очень светлый фон */
    font-family: 'Noto Sans', sans-serif; /* Японский шрифт */
}

/* Заголовки */
h1 {
    font-size: 2.5rem;
    color: #333; /* Темно-серый для контраста */
    margin-bottom: 2rem;
    font-weight: 700;
    text-align: center;
    position: relative;
}

h1::before {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 60px;
    height: 4px;
    background: #ff6f61; /* Яркий акцентный цвет */
    border-radius: 2px;
    transform: translateX(-50%);
}

/* Карта формы */
.form-card {
    background: #ffffff; /* Белый фон */
    border-radius: 12px; /* Скругленные углы */
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1); /* Легкая тень для глубины */
    padding: 2rem;
    border: 1px solid #e0e0e0; /* Легкая граница */
    position: relative;
}

/* Группы формы */
.form-group {
    margin-bottom: 1.5rem; /* Отступы между группами формы */
}

.form-label {
    font-size: 1.1rem;
    color: #555; /* Теплый серый цвет */
    font-weight: 600;
    display: block;
    margin-bottom: 0.5rem;
}

/* Поля ввода */
.form-control, .form-select {
    background-color: #fff; /* Белый фон */
    border: 1px solid #dcdcdc; /* Легкая граница */
    border-radius: 8px; /* Скругленные углы */
    padding: 0.75rem 1rem;
    font-size: 1rem;
    color: #333;
    transition: border-color 0.3s ease, box-shadow 0.3s ease; /* Плавный переход для границы и тени */
}

.form-control:focus, .form-select:focus {
    border-color: #ff6f61; /* Яркий акцентный цвет при фокусе */
    outline: none; /* Убираем стандартное выделение при фокусе */
    box-shadow: 0 0 5px rgba(255, 111, 97, 0.5); /* Тень при фокусе */
}

/* Кнопки */
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

/* Дополнительные стили */
.text-center {
    text-align: center;
}

.mb-4 {
    margin-bottom: 1.5rem;
}

.mb-5 {
    margin-bottom: 2rem;
}

.mt-5 {
    margin-top: 3rem;
}
</style>




