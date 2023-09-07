import ExampleComponent from './components/Example.vue';
import { createRouter, createWebHistory } from 'vue-router';
import FullCalendarComponent from './components/FullCalendar.vue';
import RegisterComponent from './components/Auth/Register.vue';
import LoginComponent from './components/Auth/Login.vue';

const routes = [
    {
        path: "/",
        component: ExampleComponent,
        name:'home',
    },
    {
        path: "/register",
        component: RegisterComponent,
        name:'register',
    },
    {
        path: "/login",
        component: LoginComponent,
        name:'login',
    },
    {
        path: "/calendar",
        component: FullCalendarComponent,
        name:'calendar',
    },
];

const router = createRouter({
    routes, // short for `routes: routes`
    history: createWebHistory(),
  })

export default router;