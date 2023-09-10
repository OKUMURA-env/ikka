import ExampleComponent from './components/Example.vue';
import { createRouter, createWebHistory } from 'vue-router';
import FullCalendarComponent from './components/FullCalendar.vue';
import RegisterComponent from './components/Auth/Register.vue';
import LoginComponent from './components/Auth/Login.vue';
import DriverListComponent from './components/Driver/List.vue';
import DriverCreateComponent from './components/Driver/Create.vue';
import DriverEditComponent from './components/Driver/Edit.vue';

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
    {
        path: "/driver",
        component: DriverListComponent,
        name:'driver.list',
    },
    {
        path: "/driver/create",
        component: DriverCreateComponent,
        name:'driver.create',
    },
    {
        path: "/driver/:driverId/edit",
        name: "driver.edit",
        component: DriverEditComponent,
        props: true,
    },
];

const router = createRouter({
    routes, // short for `routes: routes`
    history: createWebHistory(),
  })

export default router;