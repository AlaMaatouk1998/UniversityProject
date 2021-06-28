
import Vue from "vue";
import VueRouter from "vue-router";
import SocialSharing from "vue-social-sharing"
import VueGitHubButtons from "vue-github-buttons"
import "vue-github-buttons/dist/vue-github-buttons.css"
import App from "./App.vue";
import './assets/scss/white-dashboard.scss';
import './assets/css/nucleo-icons.css';
import "./assets/demo/demo.css";
import Vuex from 'vuex';
import storeData from './store/store';
import VueSocialauth from 'vue-social-auth'

import axios from 'axios'
import VueAxios from 'vue-axios'

import GlobalComponents from "./globalComponents";
import GlobalDirectives from "./globalDirectives";
import RTLPlugin from "./RTLPlugin";
import Notify from "./components/NotificationPlugin";
import i18n from "./i18n"
import SideBar from "./components/SidebarPlugin";
import VuejsDialog from "vuejs-dialog"
import 'vuejs-dialog/dist/vuejs-dialog.min.css';

// import VueParticles from 'vue-particles'
// Vue.use(VueParticles)
Vue.use(Vuex);
const store = new Vuex.Store(storeData);

Vue.use(VuejsDialog);
Vue.use(VueAxios, axios);
Vue.config.productionTip = false;
Vue.use(VueSocialauth, {
 
  providers: {
    google: {
      clientId: '815467849861-g43assmdusbdasd93pb4p58u4kvu1odm.apps.googleusercontent.com',
      redirectUri: 'http://localhost:8000/auth/google/callback' // Your client app URL
    },
    facebook: {
      clientId: '172369434211621',
      redirectUri: 'http://localhost:8000/auth/facebook/callback' // Your client app URL
    }
  }
});

// router setup 96fc4218184701bebbba9e6cd6a58ac3
import routes from "./router";

// configure router
const router = new VueRouter({
  routes, // short for routes: routes
  linkExactActiveClass: "active"
});

Vue.use(VueRouter);
Vue.use(SocialSharing);
Vue.use(VueGitHubButtons, { useCache: true });
Vue.use(GlobalComponents);
Vue.use(GlobalDirectives);
Vue.use(RTLPlugin);
Vue.use(SideBar);
Vue.use(Notify);
var filter = function(text, length, clamp){
  clamp = clamp || '...';
  var node = document.createElement('div');
  node.innerHTML = text;
  var content = node.textContent;
  return content.length > length ? content.slice(0, length) + clamp : content;
};
Vue.filter('truncate', filter);
router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (!store.getters.loggedIn) {
      next({
        path: '/login',
      })
    } else {
      next()
    }
  } else if (to.matched.some(record => record.meta.requiresVisitor)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (store.getters.loggedIn) {
      next({
        path: '/consulter/don',
      })
    } else {
      next()
    }
  }else {
    next() // make sure to always call next()!
  }
})

new Vue({
  router,
  i18n,
  store,
  render: h => h(App)
}).$mount("#app");
