import Vue from "vue";
import App from "./App.vue";
import Vuetify from "vuetify";

import "vuetify/dist/vuetify.min.css";

import router from "./router";
import store from "./store/index";

Vue.config.productionTip = false;
Vue.use(Vuetify);

new Vue({
  router,
  store,
  vuetify: new Vuetify(),
  render: (h) => h(App),
}).$mount("#app");
