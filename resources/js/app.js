import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import UserListComponent from './user/UserListComponent.vue';
import router from './router'
import MainHeader from './template/MainHeader.vue';
import UserRegistryComponent from './user/form/UserRegistryComponent.vue';
import UserPreviewComponent from './user/form/UserPreviewComponent.vue';

// Create Vue app
const app = createApp(App);

// Create and use Pinia
const pinia = createPinia();
app.use(pinia);

// Register components
app.component('main-header', MainHeader);
app.component('user-list-component', UserListComponent);
app.component('user-registry-component', UserRegistryComponent);
app.component('user-preview-component', UserPreviewComponent);

// Mount the app
app.use(router).mount('#app');