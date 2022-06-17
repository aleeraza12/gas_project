import Vue from "vue";
import App from "./App.vue";
import Vuetify from "vuetify";
// import VueHtmlToPaper from "vue-html-to-paper";
import "vuetify/dist/vuetify.min.css";

import router from "./router";
import store from "./store/index";

// const options = {
//   name: "_blank",
//   specs: ["fullscreen=yes", "titlebar=yes", "scrollbars=yes"],
//   styles: ["./assets/style.css"],
// };
// Vue.config.productionTip = false;
// Vue.use(VueHtmlToPaper, options);
Vue.use(Vuetify);
export const eventBus = new Vue();
new Vue({
  router,
  store,
  vuetify: new Vuetify(),
  render: (h) => h(App),
}).$mount("#app");
