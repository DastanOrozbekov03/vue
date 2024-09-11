<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";

const products = ref([]);
const totalCartPrice = ref(0);

const getProductFromCart = async () => {
    try {
        await axios.get('/api/cart',{
            headers: {
                Authorization: 'Bearer ' + localStorage.getItem('token')
            }
        }).then(res => {
            let total = 0;

            for (let i = 0; i < res.data.data.length; i++) {
                const product = res.data.data[i];
                total += product.price * product.quantity;
            }

            totalCartPrice.value = total;

            products.value = res.data.data;
        });


    } catch (error) {
        console.error("Error fetching products from cart:", error);
    }
}

const clearCart = async () => {
    try {

        await axios.delete('/api/cart/clear', {
            headers: {
                Authorization: 'Bearer ' + localStorage.getItem('token')
            }
        });
        products.value = [];
        totalCartPrice.value = 0
    } catch (error) {
        console.error('Error clearing cart:', error);
    }
};

onMounted(async () => {
    await getProductFromCart();
})
</script>

<template>
    <div class="container mt-4">
        <div class="cart-container">
            <h1 class="text-center mb-4">Cart</h1>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="product in products" :key="product.id">
                    <td>{{ product.id }}</td>
                    <td>{{ product.name }}</td>
                    <td>$ {{ product.price.toFixed(2) }}</td>
                    <td>{{ product.category }}</td>
                    <td>{{ product.quantity }}</td>
                    <td>$ {{ (product.price * product.quantity).toFixed(2) }}</td>
                </tr>
                </tbody>
            </table>
            <h2 class="text-end">Total Cart Price: $ {{ totalCartPrice.toFixed(2) }}</h2>
            <button @click="clearCart" class="btn btn-danger mt-3">Clear Cart</button>
        </div>
    </div>
</template>

<style scoped>
/* Основной контейнер */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    font-family: 'Noto Sans', sans-serif; /* Японский шрифт для современного дизайна */
    background-color: #f8f9fa; /* Легкий нейтральный фон для контейнера */
}

/* Контейнер корзины */
.cart-container {
    background-color: #ffffff; /* Белый фон для корзины */
    border-radius: 12px; /* Более скругленные углы */
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1); /* Мягкая тень для контейнера корзины */
    padding: 20px;
    margin-top: 20px; /* Расстояние от верха контейнера */
}

/* Заголовки */
h1 {
    font-size: 2.5rem;
    color: #2c3e50; /* Более темный оттенок для текста заголовка */
    margin-bottom: 1rem;
    text-align: center;
    font-weight: 700;
    border-bottom: 2px solid #dcdcdc; /* Легкая граница снизу для заголовка */
    padding-bottom: 0.5rem;
}

/* Заголовок общего итога */
h2 {
    font-size: 1.5rem;
    color: #2c3e50; /* Более темный оттенок для текста заголовка */
    margin-top: 1rem;
    font-weight: 600;
    text-align: right;
}

/* Кнопки */
.btn-danger {
    background: linear-gradient(135deg, #f76c6c, #f44e5b); /* Градиентный фон */
    border: none; /* Убираем границу */
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    font-weight: 600;
    color: #ffffff;
    transition: background 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Мягкая тень для кнопки */
}

.btn-danger:hover {
    background: linear-gradient(135deg, #f44e5b, #f76c6c); /* Градиент при наведении */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); /* Увеличенная тень при наведении */
}

/* Таблица */
.table {
    width: 100%;
    border-collapse: collapse;
    background-color: #ffffff; /* Белый фон таблицы */
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Мягкая тень для таблицы */
}

.table thead th {
    background: linear-gradient(135deg, #f9f9f9, #ffffff); /* Градиентный фон для заголовков таблицы */
    color: #2c3e50; /* Темный оттенок для текста заголовка */
    font-weight: bold;
    border-bottom: 2px solid #e0e0e0;
    padding: 12px; /* Дополнительное пространство */
}

.table tbody tr:hover {
    background-color: #f1f1f1; /* Очень светлый серый фон при наведении */
}

.table td {
    padding: 12px;
    border-bottom: 1px solid #e0e0e0; /* Легкий градиент для строк таблицы */
    color: #333; /* Темный цвет текста */
}

/* Общий стиль текста и цветов */
.text-center {
    text-align: center;
}

.text-end {
    text-align: right;
}

.mt-3 {
    margin-top: 1rem;
}

.mb-4 {
    margin-bottom: 1.5rem;
}
</style>


