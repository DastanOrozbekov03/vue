import axios from "axios";
import config from "bootstrap/js/src/util/config.js";

const axiosInstance = axios.create({
    baseURL: 'http://laravel_vue/api',
    headers: {
        'Content-Type': "application/json",
    },
});

axiosInstance.interceptors.request.use((config) => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers['Autorization'] = 'Bearer ${token}';
    }
    return config;
});

export default axiosInstance;
