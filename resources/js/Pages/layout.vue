<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";
import { useRouter} from "vue-router";



const userName = ref('')
const isAuthorized = ref(true);;
const showProfile = ref(false);
const router = useRouter();

const logout = async () => {
    const token = localStorage.getItem('token')
    try {
        await axios.post('/api/logout', {}, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });
        localStorage.removeItem('token');
        console.log('Logout succesful');
        isAuthorized.value = false;
        showProfile.value = false
        router.push('/login')
    } catch(error) {
            console.log('Error logout', error);
        }
}

const toggleProfile = () => {
    showProfile.value = !showProfile.value;
}

onMounted(async () => {
    const token = localStorage.getItem('token')
    if (token) {
            try {
                const res = await axios.get('/api/user', {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });
                userName.value = res.data.name
                isAuthorized.value = true;
            } catch(ex) {
                console.log(ex);
                isAuthorized.value = false;
            }
    } else {
        isAuthorized.value = false;
    }
});

</script>


<template>
    <header class="mb-4">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-lg">
            <div class="container">
                <div v-if="!isAuthorized" class="d-flex">
                    <router-link to="/auth" class="btn btn-primary me-2">Register</router-link>
                    <router-link to="/login" class="btn btn-secondary me-2">Login</router-link>
                </div>
                <div v-if="isAuthorized" class="d-flex align-items-center">
                    <router-link to="/category" class="btn btn-info me-2">Category</router-link>
                    <router-link to="/create_product" class="btn btn-danger me-2">Create Product</router-link>
                    <router-link to="/carts" class="btn btn-success me-2">Cart</router-link>
                    <router-link to="/products" class="btn btn-warning">Products</router-link>

                    <div class="ms-3 d-flex align-items-center position-relative">
                        <img
                            src="https://h5p.org/sites/default/files/h5p/content/1209180/images/file-6113d5f8845dc.jpeg"
                            alt="User Icon"
                            class="user-icon"
                            @click="toggleProfile"
                        />
                        <h4 class="ms-3 text-light ms-2 profile-link" @click="toggleProfile">{{ userName }}</h4>

                        <div v-if="showProfile" class="profile-menu position-absolute bg-dark text-light shadow-lg">
                            <button @click.prevent="logout" class="btn btn-danger">Logout</button>
<!--                            <router-link to="/change-password" class="dropdown-item">Change Password</router-link>-->
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <!-- Основной контент -->
    <body>
    <main class="container_main">
        <router-view />
    </main>
    </body>
</template>

<style scoped>
/* Основной контейнер */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1rem;
}

/* Навигация */
.navbar {
    background-color: #333; /* Темный фон для навигации */
    border-bottom: 2px solid #444; /* Легкая граница снизу */
}

.navbar-dark .navbar-nav .nav-link {
    color: #fff;
}

.navbar-dark .navbar-nav .nav-link:hover {
    color: #f0f0f0; /* Светлый цвет при наведении */
}

.navbar-dark .navbar-brand {
    color: #fff;
}

.navbar-dark .navbar-brand:hover {
    color: #f0f0f0;
}

/* Кнопки */
.btn-primary {
    background-color: #f6c6c6; /* Мягкий розовый цвет */
    border: 1px solid #e5a9a9;
    color: #333;
    border-radius: 8px;
}

.btn-primary:hover {
    background-color: #e5a9a9;
    border-color: #d98d8d;
}

.btn-secondary {
    background-color: #c6d5f6; /* Легкий голубой цвет */
    border: 1px solid #a9c1e5;
    color: #333;
    border-radius: 8px;
}

.btn-secondary:hover {
    background-color: #a9c1e5;
    border-color: #8a9bc4;
}

.btn-info {
    background-color: #b2c8f0; /* Легкий синий цвет */
    border: 1px solid #a2b5e2;
    color: #333;
    border-radius: 8px;
}

.btn-info:hover {
    background-color: #9ab5d4;
    border-color: #8a9bb0;
}

.btn-danger {
    background-color: #f8b2b2; /* Мягкий красный цвет */
    border: 1px solid #f7a1a1;
    color: #333;
    border-radius: 8px;
}

.btn-danger:hover {
    background-color: #e69b9b;
    border-color: #d78a8a;
}

.btn-success {
    background-color: #b2d8b2; /* Мягкий зеленый цвет */
    border: 1px solid #a2c4a2;
    color: #333;
    border-radius: 8px;
}

.btn-success:hover {
    background-color: #9bc89b;
    border-color: #89b589;
}

.btn-warning {
    background-color: #f7e7a0; /* Легкий желтый цвет */
    border: 1px solid #e0d890;
    color: #333;
    border-radius: 8px;
}

.btn-warning:hover {
    background-color: #e0d38a;
    border-color: #d0c36a;
}

/* Иконка пользователя и меню */
.user-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    object-fit: cover;
}

.profile-link {
    cursor: pointer;
    font-size: 1.25rem;
    color: #fff;
}

.profile-menu {
    top: 50px;
    right: 0;
    width: 200px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 1rem;
}

.profile-menu button {
    background-color: #f8b2b2; /* Мягкий красный цвет для кнопки Logout */
    border: 1px solid #f7a1a1;
    color: #333;
    border-radius: 8px;
    padding: 0.5rem 1rem;
    width: 100%;
}

.profile-menu button:hover {
    background-color: #e69b9b;
    border-color: #d78a8a;
}

/* Основной контент */
.container_main {
    padding: 1.5rem;
}
</style>



