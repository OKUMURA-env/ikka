import './bootstrap';
import '../css/app.css';
import 'admin-lte';

import router from './routes';
import { createApp } from 'vue';
import  store  from './store'

// axios のリクエストに Authorization ヘッダーを設定
axios.interceptors.request.use((config) => {
    const token = localStorage.getItem("authToken");
    if (token) {
      config.headers["Authorization"] = `Bearer ${token}`;
    }
    return config;
});

const app = createApp({})
app.use(router)
app.use(store)
app.mount('#app');

