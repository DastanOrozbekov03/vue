<script setup>
import axios from "axios";
import {computed, onMounted, ref} from "vue";
import {useStore} from "vuex";
import '@fortawesome/fontawesome-free/css/all.min.css'


const response = ref(null);
const products = ref([]);
const currentPage = ref(1);
const totalPages = ref(0);
const selectProduct = ref(null);
const favorite = ref();
const isModal = ref(false)


// const store = useStore()
//
// store.dispatch('product/getProducts')
// const products = computed(() => store.getters['product/products']);

const fetchProducts = async (page = 1) => {
    try {
        const response = await axios.get(`api/products?page=${page}`, {
            headers: {
                Authorization: 'Bearer ' + localStorage.getItem('token')
            }
        });
        products.value = response.data.data;
        currentPage.value = response.data.current_page;
        totalPages.value = response.data.last_page;
    } catch (error) {
        console.error('Error fetching products:', error)
    }
};
const showProducts = async (id) => {
    try {
        const { data } = await axios.get(`api/show/${id}`, {
            headers: {
                Authorization: 'Bearer ' + localStorage.getItem('token')
            }
        });
        console.log(data)
        selectProduct.value = data.data || null;

        isModal.value = true
    } catch (error) {
        console.error('Error fetching product details:', error);
    }
};
const closeModal = () => {
    selectProduct.value = null

    isModal.value = false
};
// const updateProduct = async () => {
//     try {
//         await axios.put(`api/products/${selectProduct.value.id}`, selectProduct.value, {
//             headers: {
//                 Authorization: 'Bearer ' + localStorage.getItem('token')
//             }
//         });
//         fetchProducts();
//         closeModal();
//     } catch (error) {
//         console.error('Error updating product:', error);
//     }
// };

onMounted(async () => {
    fetchProducts();

    try {
        const favorites = (await axios.get('api/favorites', {
            headers: {
                Authorization: 'Bearer ' + localStorage.getItem('token')
            }
        })).data;
        favorite.value = favorites
    } catch (error) {
        console.error('error', error)
    }
    console.log(localStorage.getItem('token'))
});
const changePage = (page) => {
    if (page > 0 && page <= totalPages.value) {
        fetchProducts(page);
    }
};


const addProductToCart = async (id) => {
    try {
        await axios.post(`api/cart/add/${id}`, {},{
            headers: {
                Authorization: 'Bearer ' + localStorage.getItem('token')
            }
        });
    } catch (error) {
        console.error('Error adding product to cart:', error);
    }
};
const addFavorite = async (id) => {
    try{
    await axios.post(`api/favorite/${id}`, {}, {
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
        }
    });
} catch (error) {
        console.error('Error adding favorite', error)
    }

};
const deleteFavorite = async (id) => {
    try{
        await axios.post(`api/favorite/${id}/delete`, {}, {
            headers: {
                Authorization: 'Bearer ' + localStorage.getItem('token')
            }
        });
        fetchProducts();
    } catch (error) {
        console.error('Error deleting favorite', error)
    }
};

const toggleFavorite = async (id) => {
    const product = products.value.find(p => p.id === id);
    if (product.is_favorite) {
        await deleteFavorite(id);
    } else {
        await addFavorite(id);
    }
    fetchProducts();
};

const  deleteProduct = async (id) => {
    console.log(`deletion: ${id}`);
    try {
        await axios.delete(`/api/products/${id}`, {
            headers: {
                Authorization: 'Bearer ' + localStorage.getItem('token')
            }
        });
        fetchProducts();
    } catch (error) {
        console.error('Error deleting product:', error);
    }
};

</script>

<template>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <div class="container mt-5">
        <h1 class="text-center mb-4">Welcome to Our Store </h1>
        <section class="mb-5">
            <table class="table table-striped table-hover table-bordered">
                <thead class="thead-light">
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Actions</th>
                    <th> </th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="product in products" :key="product.id">
                    <td>{{ product.id }}</td>
                    <td>{{ product.name }}</td>
                    <td>$ {{ product.price.toFixed(2) }}</td>
                    <td>{{ product.category_id }}</td>
                    <td>
                        <button @click.prevent="showProducts(product.id)" class="btn btn-info btn-sm">Detail</button>
                    </td>
                    <td>
                        <button @click.prevent="() => addProductToCart(product.id)" class="btn btn-success btn-sm"><i class="fas fa-shopping-cart"></i></button>
                    </td>
                    <td>
                        <button @click.prevent="deleteProduct(product.id)" class="btn btn-light btn-sm"><i class="fas fa-trash-alt"></i></button>
                    </td>
                    <td>
                        <button @click.prevent="() => toggleFavorite(product.id)" class="btn btn-light btn-sm">
                            <i :class="product.is_favorite ? 'fas fa-heart' : 'far fa-heart'"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </section>
        <div class="pagination">
            <button @click.prevent="changePage(currentPage - 1)" :disabled="currentPage === 1">Previous</button>
            <button v-for="page in totalPages" :key="page" @click.prevent="changePage(page)" :class="{ active: page === currentPage }"> {{ page }} </button>
            <button @click.prevent="changePage(currentPage + 1)" :disabled="currentPage === totalPages">Next</button>
        </div>

        <div v-if="isModal" class="modal"  style="display: block" @click="closeModal">
            <div class="modal-content" @click.stop>
                <span @click="closeModal" class="close">&times;</span>
                <h2>Product Detail</h2>
                <div>
                    <p><strong>Name:</strong> {{ selectProduct.name }}</p>
                    <p><strong>Price:</strong> {{ selectProduct.price }}</p>
                    <p><strong>Category:</strong> {{ selectProduct.category_id }}</p>
                    <router-link :to="{name: 'detailUrl', params: {id:selectProduct.id}}"><i class="fas fa-edit"></i></router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Основной контейнер */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    font-family: 'Noto Sans', sans-serif;
}

/* Заголовок страницы */
h1 {
    font-size: 2.5rem;
    color: #333;
    margin-bottom: 2rem;
    font-weight: 700;
}

/* Таблица */
.table {
    background-color: #ffffff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f2f2f2;
}

.table-hover tbody tr:hover {
    background-color: #eaeaea;
}

.table-bordered {
    border: 1px solid #ddd;
}

.btn-light i.fas.fa-trash-alt {
    color: #f8b2b2;
}

.btn-light i.fas.fa-trash-alt:hover {
    color: #e69b9b;
}

.table th, .table td {
    padding: 12px;
    text-align: center;
    color: #555;
}

/* Кнопки */
.btn {
    border-radius: 8px;
    padding: 8px 16px;
    font-size: 0.875rem;
    font-weight: 500;
    transition: background-color 0.3s, color 0.3s;
}

.btn-info {
    background-color: #b2c8f0;
    border: 1px solid #a2b5e2;
    color: #333;
}

.btn-info:hover {
    background-color: #9ab5d4;
    border-color: #8a9bb0;
}

.btn-success {
    background-color: #b2d8b2;
    border: 1px solid #a2c4a2;
    color: #333;
}

.btn-success:hover {
    background-color: #9bc89b;
    border-color: #89b589;
}

.btn-light {
    background-color: #f9f9f9;
    border: 1px solid #e0e0e0;
    color: #333;
}

.btn-light:hover {
    background-color: #e0e0e0;
    border-color: #dcdcdc;
}

.btn-danger {
    background-color: #f8b2b2;
    border: 1px solid #f7a1a1;
    color: #333;
}

.btn-danger:hover {
    background-color: #e69b9b;
    border-color: #d78a8a;
}

/* Пагинация */
.pagination {
    margin-top: 1rem;
    text-align: center;
}

.pagination button {
    border-radius: 8px;
    background-color: #f0f0f0;
    border: 1px solid #dcdcdc;
    color: #333;
    margin: 0 0.5rem;
    padding: 0.5rem 1rem;
    font-size: 1rem;
    transition: background-color 0.3s, border-color 0.3s;
}

.pagination button.active {
    background-color: #b2d8b2;
    color: #fff;
}

.pagination button:disabled {
    background-color: #e0e0e0;
    border-color: #dcdcdc;
    cursor: not-allowed;
}

/* Модальное окно */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #ffffff;
    margin: 15% auto;
    padding: 2rem;
    border: 1px solid #ddd;
    width: 80%;
    max-width: 600px;
    border-radius: 12px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #333;
    text-decoration: none;
    cursor: pointer;
}
</style>



