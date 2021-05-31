import Vue from 'vue'
import Vuex from 'vuex'
import axios from "axios";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(Vuex)
Vue.use(require('vue-moment'));
Vue.use(VueSweetalert2);

export default new Vuex.Store({
    state: {
        barColor: 'rgba(0, 0, 0, .8), rgba(0, 0, 0, .8)',
        barImage: 'https://demos.creative-tim.com/material-dashboard/assets/img/sidebar-1.jpg',
        drawer: null,
        status: '',
        token: localStorage.getItem('token') || '',
        user: {}
    },
    mutations: {
        SET_BAR_IMAGE(state, payload) {
            state.barImage = payload
        },
        SET_DRAWER(state, payload) {
            state.drawer = payload
        },
        auth_request(state) {
            state.status = 'loading'
        },
        auth_success(state, token, user) {
            state.status = 'success'
            state.token = token
            state.user = user
        },
        auth_error(state) {
            state.status = 'error'
        },
        logout(state) {
            state.status = ''
            state.token = ''
        },
    },
    actions: {

        login({ commit }, user) {
            return new Promise((resolve, reject) => {
                commit('auth_request')
                axios({ url: process.env.VUE_APP_ROOT_API + '/login', data: user, method: 'POST' })
                    .then(resp => {
                        const token = resp.data.token
                        const user = resp.data.username
                        const role = resp.data.role
                        localStorage.setItem('token', token)
                        localStorage.setItem('user_role', role)
                        axios.defaults.headers.common['Authorization'] = token
                        commit('auth_success', token, user)
                        resolve(resp)
                    })
                    .catch(err => {
                        commit('auth_error')
                        localStorage.removeItem('token')
                        reject(err)
                    })
            })
        },

        logout() {
            axios.post(process.env.VUE_APP_ROOT_API + '/logout').then(response => {
                console.log(response);
                this.$router.push("/").catch(() => {});
            }).catch(error => {
                console.log(error);
                location.reload();
            });
        }

    },
    getters: {
        isLoggedIn: state => !!state.token,
        authStatus: state => state.status,
    }
})