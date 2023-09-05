import './bootstrap';
import '../css/app.css';
import 'admin-lte';

import router from './routes';
import { createApp } from 'vue';

const app = createApp({})
app.use(router)
app.mount('#app');