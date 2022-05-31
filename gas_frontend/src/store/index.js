import Vue from "vue";
import Vuex from "vuex";
import RequestService from "../RequestService";
Vue.use(Vuex);

const store = {
  state: {
    url: "http://127.0.0.1:8000/api/",
    sales: [],
    customers: [],
    purchases: [],
    users: [],
  },
  getters: {
    getSales: (state) => state.sales,
    getCustomers: (state) => state.customers,
    getUsers: (state) => state.users,
    getPurchases: (state) => state.purchases,
  },
  mutations: {
    SET_SALES: (state, payload) => (state.sales = payload),
    SET_CUSTOMERS: (state, payload) => (state.customers = payload),
    SET_PURCHASES: (state, payload) => (state.purchases = payload),
    SET_USERS: (state, payload) => (state.users = payload),
  },
  actions: {
    // gettng all customers for a company
    getCustomersListing(context) {
      let requestBody = {};
      RequestService.post("customer/read_all", requestBody).then((response) => {
        if (response.data.status == 200) {
          console.log("customers fetched");
          context.commit("SET_CUSTOMERS", response.data.response);
        }
      });
    },

    // gettng all users for a company
    getUsersListing(context) {
      let requestBody = {};
      RequestService.post("user/read_all", requestBody).then((response) => {
        if (response.data.status == 200) {
          console.log("users fetched");
          context.commit("SET_USERS", response.data.response);
        }
      });
    },

    // gettng all orders of a company
    getSalesListings(context, data) {
      console.log(data);
      let requestBody = {};
      RequestService.post("sale/read_all", requestBody).then((response) => {
        if (response.data.status == 200) {
          console.log("Order fetched");
          context.commit("SET_SALES", response.data.response);
        }
      });
    },

    // gettng all purchases of a company
    getPurchaseListing(context, data) {
      console.log(data);
      let requestBody = {};
      RequestService.post("purchase/read_all", requestBody).then((response) => {
        if (response.data.status == 200) {
          console.log("purchase fetched");
          context.commit("SET_PURCHASES", response.data.response);
        }
      });
    },
  },
  modules: {},
};
export default new Vuex.Store(store);
