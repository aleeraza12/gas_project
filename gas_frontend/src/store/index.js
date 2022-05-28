import Vue from "vue";
import Vuex from "vuex";

import RequestService from "../RequestService";
//import router from "./router";
Vue.use(Vuex);

const store = {
  state: {
    url: "http://127.0.0.1:8000/api/",
    orders: [],
  },
  getters: {
    getOrders: (state) => state.orders,
  },
  mutations: {
    SET_ORDERS: (state, payload) => (state.orders = payload),
  },
  actions: {
    getOrders(context, data) {
      console.log(data);
      RequestService.post("order/read_all").then((response) => {
        if (response.data.status == 200) {
          console.log("Order fetched");
          context.commit("SET_ORDERS", response.data.response);
        }
      });
    },
  },
  modules: {},
};
export default new Vuex.Store(store);
