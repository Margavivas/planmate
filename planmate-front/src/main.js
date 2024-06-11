import { createApp } from 'vue';
import App from './App.vue';
import router from './router'; // Importa la configuración de Vue Router
import { createPinia } from 'pinia'

import Donut from 'vue-css-donut-chart';
import 'vue-css-donut-chart/dist/vcdonut.css';

const app = createApp(App);
const pinia = createPinia();
app.use(Donut);
app.use(pinia); 
app.use(router); // Usa Vue Router en tu aplicación
app.mount('#app');
