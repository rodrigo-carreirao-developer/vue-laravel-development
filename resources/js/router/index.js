import { createRouter, createWebHistory } from "vue-router";
import UserRegistryComponent from "../user/form/UserRegistryComponent.vue";
import UserPreviewComponent from "../user/form/UserPreviewComponent.vue";
import UserListComponent from "../user/UserListComponent.vue";
import App from "../App.vue";
import MainHeader from "../template/MainHeader.vue";

const routes = [
    {
        path: '/user/listing',
        name: 'User Listing',
        component: UserListComponent
    },
    {
        path: '/user',
        name: 'Home',
        component: MainHeader
    },
    {
        path: '/user/registry',
        name: 'User Registry', 
        component: UserRegistryComponent
    },
    {
        path: '/user/preview',
        name: 'User Preview', 
        component: UserPreviewComponent
    }
];

const router = createRouter({history: createWebHistory(), routes});
export default router;