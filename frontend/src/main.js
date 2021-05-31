 import Vue from 'vue'
 import App from './App.vue'
 import vuetify from './plugins/vuetify'
 import router from './router'
 import store from './store'
 import Axios from 'axios'
 import "./assets/styles.scss";
 import VueSweetalert2 from 'vue-sweetalert2';
 import 'sweetalert2/dist/sweetalert2.min.css';
 Vue.use(VueSweetalert2);
 require("dotenv").config();

 Vue.config.productionTip = false
 Vue.prototype.$http = Axios;
 const token = localStorage.getItem('token')
 if (token) {
     Vue.prototype.$http.defaults.headers.common['Authorization'] = 'Bearer ' + token
 }

 new Vue({
     router,
     store,
     vuetify,
     render: h => h(App)
 }).$mount('#app')