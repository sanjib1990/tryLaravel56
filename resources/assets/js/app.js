/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import VueRouter from "vue-router";
import Helper from "./utils/Helper";
import VueSession from 'vue-session';
import VeeValidate from 'vee-validate';
import BootstrapVue from 'bootstrap-vue';

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.use(VeeValidate);
Vue.use(VueRouter);
Vue.use(BootstrapVue);
VueSession.key = Helper.getSessionKey();
Vue.use(VueSession, {persist: true});

new Vue({
    el: '#app',
    router,
    render: h => h(App)
});
