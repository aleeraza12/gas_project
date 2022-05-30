import Vue from "vue";
import Vuex from "vuex";

import RequestService from "../RequestService";
//import router from "./router";
Vue.use(Vuex);

const store = {
  state: {
    url: "http://127.0.0.1:8000/api/",
    orders: [],
    customers: [],
  },
  getters: {
    getOrders: (state) => state.orders,
  },
  mutations: {
    SET_ORDERS: (state, payload) => (state.orders = payload),
    SET_CUSTOMERS: (state, payload) => (state.customers = payload),
  },
  actions: {
    // gettng all customers for a company
    getCustomersListing(context, data) {
      RequestService.post("customer/read_all").then((response) => {
        if (response.data.status == 200) {
          console.log("customers fetched");
          context.commit("SET_CUSTOMERS", response.data.response);
        }
      });
    },
    // gettng all orders of a company
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
