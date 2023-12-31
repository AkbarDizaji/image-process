import { createApp } from 'vue'
import App from './App.vue'
import Toast from "vue-toastification";

createApp(App).use(Toast, {}).mount('#app')
