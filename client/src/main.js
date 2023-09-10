import Vue from 'vue';
import App from './App.vue';
import store from './store'; // Импорт Vuex Store
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/en'
Vue.use(ElementUI, { locale })
Vue.config.productionTip = false;
new Vue({render: h => h(App), store}).$mount('#app');
