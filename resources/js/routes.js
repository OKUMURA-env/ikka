import ExampleComponent from './components/Example.vue';
import { createRouter, createWebHistory } from 'vue-router';
import FullCalendarComponent from './components/FullCalendar.vue';

const routes = [
    {
        path: "/",
        component: ExampleComponent,
        name:'home',
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