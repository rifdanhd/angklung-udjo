import { createApp } from 'vue';
import AdminApp from './components/AdminApp.vue';

const adminAppElement = document.getElementById('admin-app');
if (adminAppElement) {
    createApp(AdminApp).mount(adminAppElement);
}
