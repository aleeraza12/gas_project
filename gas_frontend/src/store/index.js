import Vue from "vue";
import Vuex from "vuex";
import RequestService from "../RequestService";
import { eventBus } from "@/main";
import router from "@/router";

Vue.use(Vuex);

const store = {
  state: {
    url: "http://127.0.0.1:8000/api/",
    sales: [],
    customers: [],
    purchases: [],
    users: [],
    view_single_receipt: [],
    view_single_purchase: [],
    single_customer_to_update: "",
    payment_modes: [],
    customer_types: [],
    user_types: [],
    states: [],
    transactions: [],
  },
  getters: {
    getSales: (state) => state.sales,
    getCustomers: (state) => state.customers,
    getUsers: (state) => state.users,
    getPurchases: (state) => state.purchases,
    getSingleReceipt: (state) => state.view_single_receipt,
    getSinglePurchase: (state) => state.view_single_purchase,
    getSingleCustomer: (state) => state.single_customer_to_update,
    getAllPaymentModes: (state) => state.payment_modes,
    getAllCustomerTypes: (state) => state.customer_types,
    getAllUserTypes: (state) => state.user_types,
    getAllStates: (state) => state.states,
    getAllTransactions: (state) => state.transactions,
  },
  mutations: {
    SET_SALES: (state, payload) => (state.sales = payload),
    SET_PAYMENT_MODES: (state, payload) => (state.payment_modes = payload),
    SET_CUSTOMER_TYPES: (state, payload) => (state.customer_types = payload),
    SET_USER_TYPES: (state, payload) => (state.user_types = payload),
    SET_STATES: (state, payload) => (state.states = payload),
    SET_CUSTOMERS: (state, payload) => (state.customers = payload),
    SET_PURCHASES: (state, payload) => (state.purchases = payload),
    SET_USERS: (state, payload) => (state.users = payload),
    SET_TRANSATIONS: (state, payload) => (state.transactions = payload),
    SET_VIEW_RECEIPT: (state, payload) => (state.view_single_receipt = payload),
    SET_SINGLE_CUSTOMER_DATA: (state, payload) =>
      (state.single_customer_to_update = payload),
    SET_VIEW_PURCHASE: (state, payload) =>
      (state.view_single_purchase = payload),
  },
  actions: {
    // gettng all customers for a company
    getCustomersListing(context) {
      let requestBody = {};
      RequestService.post("customer/read_all", requestBody).then((response) => {
        if (response.data.status == 200) {
          eventBus.$emit("responseArrived");
          context.commit("SET_CUSTOMERS", response.data.response);
        }
      });
    },

    // gettng all users for a company
    getUsersListing(context) {
      let requestBody = {};
      RequestService.post("user/read_all", requestBody).then((response) => {
        if (response.data.status == 200) {
          context.commit("SET_USERS", response.data.response);
          eventBus.$emit("responseArrived");
        }
      });
    },

    // gettng all orders of a company
    getSalesListings(context, data) {
      console.log(data);
      let requestBody = {};
      RequestService.post("sale/read_all", requestBody).then((response) => {
        if (response.data.status == 200) {
          context.commit("SET_SALES", response.data.response);
          eventBus.$emit("responseArrived");
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
          eventBus.$emit("responseArrived");
        }
      });
    },
    //Get payment methods
    getPaymentMethods(context, data) {
      console.log(data);
      let requestBody = {};
      RequestService.post("payment/mode/read_all", requestBody).then(
        (response) => {
          if (response.data.status == 200) {
            let payment_modes = [];
            for (let j = 0; j < response.data.response.length; j++) {
              payment_modes.push(response.data.response[j].payment_mode);
            }
            context.commit("SET_PAYMENT_MODES", payment_modes);
          }
        }
      );
    },
    //Get customers type
    getCustomerTypes(context, data) {
      console.log(data);
      let requestBody = {};
      RequestService.post("customer_type/read_all", requestBody).then(
        (response) => {
          if (response.data.status == 200) {
            let customer_types = [];
            for (let j = 0; j < response.data.response.length; j++) {
              customer_types.push(response.data.response[j].customer_type);
            }
            context.commit("SET_CUSTOMER_TYPES", customer_types);
          }
        }
      );
    },
    //Get user type
    getUserTypes(context, data) {
      console.log(data);
      let requestBody = {};
      RequestService.post("user_type/read_all", requestBody).then(
        (response) => {
          if (response.data.status == 200) {
            let user_types = [];
            for (let j = 0; j < response.data.response.length; j++) {
              user_types.push(response.data.response[j].user_type);
            }
            context.commit("SET_USER_TYPES", user_types);
          }
        }
      );
    },
    //Get states
    getAllStates(context, data) {
      console.log(data);
      let requestBody = {};
      RequestService.post("states/read_all", requestBody).then((response) => {
        if (response.data.status == 200) {
          let states = [];
          for (let j = 0; j < response.data.response.length; j++) {
            states.push(response.data.response[j].state_name);
          }
          context.commit("SET_STATES", states);
        }
      });
    },
    //Get Transaction
    getAllTransacton(context, data) {
      console.log(data);
      let requestBody = {};
      RequestService.post("transaction/read_all", requestBody).then(
        (response) => {
          if (response.data.status == 200) {
            context.commit("SET_TRANSATIONS", response.data.response);
            eventBus.$emit("responseArrived");
          }
        }
      );
    },

    checkRouteExistence() {
      let permissionsArray = JSON.parse(
        localStorage.getItem("user")
      ).permissions;
      console.log(
        permissionsArray.includes("Dashboard"),
        JSON.parse(localStorage.getItem("user")).permissions
      );
      if (permissionsArray.includes("Dashboard")) {
        router.push("/dashboard");
      } else if (permissionsArray.includes("Orders")) {
        router.push("/orders");
      } else if (permissionsArray.includes("Sales")) {
        router.push("/sales");
      } else if (permissionsArray.includes("Purchases")) {
        router.push("/purchases");
      } else if (permissionsArray.includes("Users")) {
        router.push("/users");
      } else if (permissionsArray.includes("Customers")) {
        router.push("/customers");
      } else if (permissionsArray.includes("Settings")) {
        router.push("/settings");
      } else if (permissionsArray.includes("Wallet")) {
        router.push("/wallet");
      } else if (permissionsArray.includes("Reconciliation")) {
        router.push("/reconcilation");
      }
      //else {
      //  router.push("/dashboard");
      //}
    },
  },
  modules: {},
};
export default new Vuex.Store(store);
