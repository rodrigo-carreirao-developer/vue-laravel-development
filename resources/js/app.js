import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import router from './router'
import MainHeader from './template/MainHeader.vue';


// Create Vue app
const app = createApp(App);

// Create and use Pinia
const pinia = createPinia();
app.use(pinia);

// Register components
app.component('main-header', MainHeader);


// Mount the app
app.use(router).mount('#app');