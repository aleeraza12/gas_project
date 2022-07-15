import Vue from "vue";
import Vuex from "vuex";
import RequestService from "../RequestService";
import { eventBus } from "@/main";
import router from "@/router";

Vue.use(Vuex);

const store = {
  state: {
    url: "https://console.api.gas360.online/api/",
    // url: "http://127.0.0.1:8000/api/",
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
    //settngs
    payment_modes_settings: [],
    customer_types_settings: [],
    user_types_settings: [],
    states_settings: [],
    transactions: [],
    companies: [],
    price: [],
    depos: [],
    dashboard: [],
    orders: [],
    wallets: [],
    promos: [],
    rates: [],
    scroll_able_prices: [],
    date: "",
    recovery_mail: "",
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
    getAllDepos: (state) => state.depos,
    getAllOrders: (state) => state.orders,
    getRecoveryMail: (state) => state.recovery_mail,
    getScrollablePrice: (state) => state.scroll_able_prices,
    //settngs
    getAllCustomerTypesSettings: (state) => state.customer_types_settings,
    getAllUserTypesSettings: (state) => state.user_types_settings,
    getAllStatesSettings: (state) => state.states_settings,
    getAllPaymentModesSettings: (state) => state.payment_modes_settings,
    //
    getAllTransactions: (state) => state.transactions,
    getCompanies: (state) => state.companies,
    getPrice: (state) => state.price,
    getDashboardData: (state) => state.dashboard,
    getWallet: (state) => state.wallets,
    getSelectedDateRange: (state) => state.date,
    getPromos: (state) => state.promos,
    getRates: (state) => state.rates,
  },
  mutations: {
    SET_SALES: (state, payload) => (state.sales = payload),
    SET_PROMOS: (state, payload) => (state.promos = payload),
    SET_PAYMENT_MODES: (state, payload) => (state.payment_modes = payload),
    SET_CUSTOMER_TYPES: (state, payload) => (state.customer_types = payload),
    SET_USER_TYPES: (state, payload) => (state.user_types = payload),
    SET_STATES: (state, payload) => (state.states = payload),
    SET_COMPANIES: (state, payload) => (state.companies = payload),
    SET_PRICE: (state, payload) => (state.price = payload),
    SET_DEPOS: (state, payload) => (state.depos = payload),
    SET_DASHBOARD: (state, payload) => (state.dashboard = payload),
    SET_ORDERS: (state, payload) => (state.orders = payload),
    SET_WALLETS: (state, payload) => (state.wallets = payload),
    SET_RATES: (state, payload) => (state.rates = payload),
    //Settngs
    SET_PAYMENT_MODES_SETTINGS: (state, payload) =>
      (state.payment_modes_settings = payload),
    SET_CUSTOMER_TYPES_SETTINGS: (state, payload) =>
      (state.customer_types_settings = payload),
    SET_USER_TYPES_SETTINGS: (state, payload) =>
      (state.user_types_settings = payload),
    SET_STATES_SETTINGS: (state, payload) => (state.states_settings = payload),
    setSelectedDateRange: (state, payload) => (state.date = payload),

    EMPTY_CUSTOMERS: (state) => (state.customers = ""),
    SET_CUSTOMERS: (state, payload) => (state.customers = payload),
    SET_PURCHASES: (state, payload) => (state.purchases = payload),
    SET_USERS: (state, payload) => (state.users = payload),
    SET_TRANSATIONS: (state, payload) => (state.transactions = payload),
    SET_VIEW_RECEIPT: (state, payload) => (state.view_single_receipt = payload),
    SET_SINGLE_CUSTOMER_DATA: (state, payload) =>
      (state.single_customer_to_update = payload),
    SET_VIEW_PURCHASE: (state, payload) =>
      (state.view_single_purchase = payload),
    SET_RECOVERY_EMAIL: (state, payload) => (state.recovery_mail = payload),
    SET_PRICE_SCROLL: (state, payload) => (state.scroll_able_prices = payload),
  },
  actions: {
    //Wallet     &
    getAllWallets(context, data) {
      let requestBody = {};
      RequestService.post("wallet/read", requestBody, data).then((response) => {
        if (response.data.status == 200) {
          context.commit("SET_WALLETS", response.data.response);
          eventBus.$emit("responseArrived");
        }
      });
    },
    // gettng all customers for a company      7
    getCustomersListing(context, data) {
      let requestBody = {};
      RequestService.post("customer/read_all", requestBody, data).then(
        (response) => {
          if (response.data.status == 200) {
            eventBus.$emit("responseArrived");
            context.commit("EMPTY_CUSTOMERS", response.data.response);
            context.commit("SET_CUSTOMERS", response.data.response);
          }
        }
      );
    },

    // gettng all users for a company      6
    getUsersListing(context, data) {
      let requestBody = {};
      RequestService.post("user/read_all", requestBody, data).then(
        (response) => {
          if (response.data.status == 200) {
            context.commit("SET_USERS", response.data.response);
            eventBus.$emit("responseArrived");
          }
        }
      );
    },

    // gettng all orders of a company     5
    getSalesListings(context, data) {
      let requestBody = {};
      RequestService.post("sale/read_all", requestBody, data).then(
        (response) => {
          if (response.data.status == 200) {
            context.commit("SET_SALES", response.data.response);
            eventBus.$emit("responseArrived");
          }
        }
      );
    },

    // gettng all orders of a company     4
    getCompaniesListing(context, data) {
      let requestBody = {};
      RequestService.post("company/read_all", requestBody, data).then(
        (response) => {
          if (response.data.status == 200) {
            context.commit("SET_COMPANIES", response.data.response);
            eventBus.$emit("responseArrived");
          }
        }
      );
    },

    // gettng all purchases of a company      3
    getPurchaseListing(context, data) {
      let requestBody = {};
      RequestService.post("purchase/read_all", requestBody, data).then(
        (response) => {
          if (response.data.status == 200) {
            context.commit("SET_PURCHASES", response.data.response);
            eventBus.$emit("responseArrived");
          }
        }
      );
    },

    //Get Transaction       2
    getAllTransactions(context, data) {
      let requestBody = {};
      context.commit("SET_TRANSATIONS", "");
      RequestService.post("transaction/read_all", requestBody, data).then(
        (response) => {
          if (response.data.status == 200) {
            context.commit("SET_TRANSATIONS", response.data.response);
            eventBus.$emit("responseArrived");
          }
        }
      );
    },

    //Orders      1
    getOrderListing(context, data) {
      let requestBody = {};
      RequestService.post("order/read_all", requestBody, data).then(
        (response) => {
          if (response.data.status == 200) {
            context.commit("SET_ORDERS", response.data.response);
            eventBus.$emit("responseArrived");
          }
        }
      );
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

    //Get payment methods
    getPaymentMethodsSettings(context, data) {
      console.log(data);
      let requestBody = {};
      RequestService.post("payment/mode/read_all", requestBody).then(
        (response) => {
          if (response.data.status == 200) {
            context.commit(
              "SET_PAYMENT_MODES_SETTINGS",
              response.data.response
            );
          }
          eventBus.$emit("responseArrivedPaymentMode");
        }
      );
    },
    //Get customers type
    getCustomerTypesSettings(context, data) {
      console.log(data);
      let requestBody = {};
      RequestService.post("customer_type/read_all", requestBody).then(
        (response) => {
          if (response.data.status == 200) {
            context.commit(
              "SET_CUSTOMER_TYPES_SETTINGS",
              response.data.response
            );
            eventBus.$emit("responseArrivedCustomerTypes");
          }
        }
      );
    },
    //Get user type
    getUserTypesSettings(context, data) {
      console.log(data);
      let requestBody = {};
      RequestService.post("user_type/read_all", requestBody).then(
        (response) => {
          if (response.data.status == 200) {
            context.commit("SET_USER_TYPES_SETTINGS", response.data.response);
            eventBus.$emit("responseArrivedUserTypes");
          }
        }
      );
    },
    //Get states
    getAllStatesSettings(context, data) {
      console.log(data);
      let requestBody = {};
      RequestService.post("states/read_all", requestBody).then((response) => {
        if (response.data.status == 200) {
          context.commit("SET_STATES_SETTINGS", response.data.response);
          eventBus.$emit("responseArrivedStates");
        }
      });
    },

    //Gas price
    getCurrentPrice(context, data) {
      console.log(data);
      let requestBody = {};
      RequestService.post("depo/read_one", requestBody).then((response) => {
        if (response.data.status == 200) {
          context.commit("SET_PRICE", response.data.response);
          eventBus.$emit("priceResponseArrived");
        }
      });
    },

    //Gas price
    getDepoForScroll(context, data) {
      console.log(data);
      let requestBody = {};
      RequestService.post("depo/read_rate_list", requestBody).then(
        (response) => {
          if (response.data.status == 200) {
            context.commit("SET_PRICE_SCROLL", response.data.response);
          }
        }
      );
    },

    //Gas all depos
    getAllDepos(context, data) {
      console.log(data);
      let requestBody = {};
      RequestService.post("depo/read_all", requestBody).then((response) => {
        if (response.data.status == 200) {
          context.commit("SET_DEPOS", response.data.response);
          eventBus.$emit("responseArrivedDepo");
        }
      });
    },

    getDashboardStats(context, data) {
      console.log(data);
      let requestBody = {};
      RequestService.post("dashboard/read_all", requestBody).then(
        (response) => {
          if (response.data.status == 200) {
            context.commit("SET_DASHBOARD", response.data.response);
            eventBus.$emit("responseArrived");
          }
        }
      );
    },
    //Promo code
    getPromosListing(context, requestBody) {
      RequestService.post("promo/read_all", requestBody).then((response) => {
        if (response.data.status == 200) {
          context.commit("SET_PROMOS", response.data.response);
          eventBus.$emit("responseArrived");
        }
      });
    },

    getRateListing(context, requestBody) {
      RequestService.post("depo/read_rate_list", requestBody).then(
        (response) => {
          if (response.data.status == 200) {
            context.commit("SET_RATES", response.data.response);
            eventBus.$emit("responseArrived");
          }
        }
      );
    },

    checkRouteExistence() {
      let permissionsArray = JSON.parse(
        localStorage.getItem("user")
      ).permissions;
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
      } else if (permissionsArray.includes("Depos")) {
        router.push("/depos");
      } else {
        router.push("/pageNotFound");
      }
    },
  },
  modules: {},
};
export default new Vuex.Store(store);
