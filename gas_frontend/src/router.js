import Vue from "vue";
import VueRouter from "vue-router";
// import store from "./store/index";
Vue.use(VueRouter);
const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes: [
    {
      path: "/signup",
      name: "Sign up",
      meta: { layout: "simple", title: "Sing Up" },
      component: require("@/views/Pages/SignUp").default,
    },
    {
      path: "/",
      name: "Home",
      meta: { layout: "simple", title: "Login" },
      component: require("@/views/Pages/Login").default,
    },
    {
      path: "/login",
      name: "Login",
      meta: { layout: "simple", title: "Login" },
      component: require("@/views/Pages/Login").default,
    },
    {
      path: "/password-recover",
      name: "PasswordRecover",
      meta: { layout: "simple", title: "Password Recover" },
      component: require("@/views/Pages/PasswordRecover").default,
    },
    {
      path: "/mail-sent",
      name: "MailSent",
      meta: { layout: "simple", title: "Mail Sent" },
      component: require("@/views/Pages/emailSent").default,
    },
    {
      path: "/update-password",
      name: "Update Password",
      meta: { layout: "simple", title: "Update Password" },
      component: require("@/views/Pages/updatePassword").default,
    },
    {
      path: "/reset-message",
      name: "Reset Message",
      meta: { layout: "simple", title: "Reset Message" },
      component: require("@/views/Pages/resetMessage").default,
    },
    {
      path: "/dashboard",
      name: "Dashboard",
      //beforeEnter: (to, from, next) => {
      //  setTimeout(() => {
      //    if (
      //      !(
      //        "Dashboard" in
      //        JSON.parse(localStorage.getItem("user")).permissions
      //      )
      //    ) {
      //      store.dispatch("checkRouteExistence");
      //    } else {
      //      next();
      //    }
      //  }, 10);
      //},
      meta: { layout: "app", title: "Dashboard", requireAuth: true },
      component: require("@/views/Pages/dashboard").default,
    },
    {
      path: "/orders",
      name: "Orders",
      //beforeEnter: (to, from, next) => {
      //  setTimeout(() => {
      //    if (
      //      !("Orders" in JSON.parse(localStorage.getItem("user")).permissions)
      //    ) {
      //      store.dispatch("checkRouteExistence");
      //    } else {
      //      next();
      //    }
      //  }, 10);
      //},
      meta: { layout: "app", title: "Orders", requireAuth: true },
      component: require("@/views/Pages/orders").default,
    },
    {
      path: "/sales",
      name: "Sales",
      //beforeEnter: (to, from, next) => {
      //  setTimeout(() => {
      //    if (
      //      !("Sales" in JSON.parse(localStorage.getItem("user")).permissions)
      //    ) {
      //      store.dispatch("checkRouteExistence");
      //    } else {
      //      next();
      //    }
      //  }, 10);
      //},
      meta: { layout: "app", title: "Sales", requireAuth: true },
      component: require("@/views/Pages/sales").default,
    },
    {
      path: "/purchases",
      name: "Purchases",
      //beforeEnter: (to, from, next) => {
      //  setTimeout(() => {
      //    if (
      //      !(
      //        "Purchases" in
      //        JSON.parse(localStorage.getItem("user")).permissions
      //      )
      //    ) {
      //      store.dispatch("checkRouteExistence");
      //    } else {
      //      next();
      //    }
      //  }, 10);
      //},
      meta: { layout: "app", title: "Purchases", requireAuth: true },
      component: require("@/views/Pages/purchases").default,
    },
    {
      path: "/customers",
      name: "Customers",
      //beforeEnter: (to, from, next) => {
      //  setTimeout(() => {
      //    if (
      //      !(
      //        "Customers" in
      //        JSON.parse(localStorage.getItem("user")).permissions
      //      )
      //    ) {
      //      store.dispatch("checkRouteExistence");
      //    } else {
      //      next();
      //    }
      //  }, 10);
      //},
      meta: { layout: "app", title: "Customers", requireAuth: true },
      component: require("@/views/Pages/customers").default,
    },
    {
      path: "/users",
      name: "Users",
      //beforeEnter: (to, from, next) => {
      //  setTimeout(() => {
      //    if (
      //      !("Users" in JSON.parse(localStorage.getItem("user")).permissions)
      //    ) {
      //      store.dispatch("checkRouteExistence");
      //      console.log("dispatch");
      //    } else {
      //      next();
      //    }
      //  }, 10);
      //},
      meta: { layout: "app", title: "Users" },
      component: require("@/views/Pages/users").default,
    },
    {
      path: "/reconcilation",
      name: "Reconcilation",
      //beforeEnter: (to, from, next) => {
      //  setTimeout(() => {
      //    if (
      //      !(
      //        "Reconciliation" in
      //        JSON.parse(localStorage.getItem("user")).permissions
      //      )
      //    ) {
      //      store.dispatch("checkRouteExistence");
      //    } else {
      //      next();
      //    }
      //  }, 10);
      //},
      meta: { layout: "app", title: "Reconcilation", requireAuth: true },
      component: require("@/views/Pages/reconcilation").default,
    },

    {
      path: "/reconcilation-tabs",
      name: "Reconcilation-tabs",
      meta: { layout: "app", title: "Reconcilation-tabs", requireAuth: true },
      component: require("./components/reconcilation/reconcilation-tabs").default,
    },
    {
      path: "/sale-receipt-form",
      name: "sale-receipt-form",
      //beforeEnter: (to, from, next) => {
      //  setTimeout(() => {
      //    if (
      //      !("Sales" in JSON.parse(localStorage.getItem("user")).permissions)
      //    ) {
      //      store.dispatch("checkRouteExistence");
      //    } else {
      //      next();
      //    }
      //  }, 10);
      //},
      meta: { layout: "app", title: "sale-receipt-form", requireAuth: true },
      component: require("./components/forms/sale-receipt-form.vue").default,
    },
    {
      path: "/sale-invoice",
      name: "sale-invoice",
      //beforeEnter: (to, from, next) => {
      //  setTimeout(() => {
      //    if (
      //      !("Sales" in JSON.parse(localStorage.getItem("user")).permissions)
      //    ) {
      //      store.dispatch("checkRouteExistence");
      //    } else {
      //      next();
      //    }
      //  }, 10);
      //},
      meta: { layout: "app", title: "sale-invoice", requireAuth: true },
      component: require("./components/sales/saleInvoice").default,
    },

    {
      path: "/purchase-receipt-form",
      name: "purchase-receipt-form",
      //beforeEnter: (to, from, next) => {
      //  setTimeout(() => {
      //    if (
      //      !(
      //        "Purchases" in
      //        JSON.parse(localStorage.getItem("user")).permissions
      //      )
      //    ) {
      //      store.dispatch("checkRouteExistence");
      //    } else {
      //      next();
      //    }
      //  }, 10);
      //},
      meta: {
        layout: "app",
        title: "purchase-receipt-form",
        requireAuth: true,
      },
      component: require("./components/forms/purchase-receipt-form.vue")
        .default,
    },

    {
      path: "/sales-details",
      //beforeEnter: (to, from, next) => {
      //  setTimeout(() => {
      //    if (
      //      !("Sales" in JSON.parse(localStorage.getItem("user")).permissions)
      //    ) {
      //      store.dispatch("checkRouteExistence");
      //    } else {
      //      next();
      //    }
      //  }, 10);
      //},
      name: "sales-details",
      meta: { layout: "app", title: "sales-details" },
      component: require("./components/sales/sales-details.vue").default,
    },
    {
      path: "/purchase-details",
      name: "purchase-details",
      //beforeEnter: (to, from, next) => {
      //  setTimeout(() => {
      //    if (
      //      !(
      //        "Purchases" in
      //        JSON.parse(localStorage.getItem("user")).permissions
      //      )
      //    ) {
      //      store.dispatch("checkRouteExistence");
      //    } else {
      //      next();
      //    }
      //  }, 10);
      //},
      meta: { layout: "app", title: "purchase-details" },
      component: require("./components/purchases/purchase-details").default,
    },
    {
      path: "/order-details",
      name: "order-details",
      //beforeEnter: (to, from, next) => {
      //  setTimeout(() => {
      //    if (
      //      !("Orders" in JSON.parse(localStorage.getItem("user")).permissions)
      //    ) {
      //      store.dispatch("checkRouteExistence");
      //    } else {
      //      next();
      //    }
      //  }, 10);
      //},
      meta: { layout: "app", title: "order-details" },
      component: require("./components/orders/order-details.vue").default,
    },
    {
      path: "/no-sale",
      name: "no-sales",
      //beforeEnter: (to, from, next) => {
      //  setTimeout(() => {
      //    if (
      //      !("Sales" in JSON.parse(localStorage.getItem("user")).permissions)
      //    ) {
      //      store.dispatch("checkRouteExistence");
      //    } else {
      //      next();
      //    }
      //  }, 10);
      //},
      meta: { layout: "app", title: "no-sales" },
      component: require("./components/sales/no-sales.vue").default,
    },
    {
      path: "/no-order",
      name: "no-orders",
      //beforeEnter: (to, from, next) => {
      //  setTimeout(() => {
      //    if (
      //      !("Orders" in JSON.parse(localStorage.getItem("user")).permissions)
      //    ) {
      //      store.dispatch("checkRouteExistence");
      //    } else {
      //      next();
      //    }
      //  }, 10);
      //},
      meta: { layout: "app", title: "no-orders" },
      component: require("./components/orders/no-order").default,
    },
    {
      path: "/no-user",
      name: "no-user",
      //beforeEnter: (to, from, next) => {
      //  setTimeout(() => {
      //    if (
      //      !("Users" in JSON.parse(localStorage.getItem("user")).permissions)
      //    ) {
      //      store.dispatch("checkRouteExistence");
      //    } else {
      //      next();
      //    }
      //  }, 10);
      //},
      meta: { layout: "app", title: "no-user" },
      component: require("./components/users/no-user.vue").default,
    },
    {
      path: "/new-user",
      name: "new-user",
      //beforeEnter: (to, from, next) => {
      //  setTimeout(() => {
      //    if (
      //      !("Users" in JSON.parse(localStorage.getItem("user")).permissions)
      //    ) {
      //      store.dispatch("checkRouteExistence");
      //    } else {
      //      next();
      //    }
      //  }, 10);
      //},
      meta: { layout: "app", title: "new-user" },
      component: require("./components/users/addNewUser.vue").default,
    },
    {
      path: "/new-customer",
      name: "new-customer",
      //beforeEnter: (to, from, next) => {
      //  setTimeout(() => {
      //    if (
      //      !(
      //        "Customers" in
      //        JSON.parse(localStorage.getItem("user")).permissions
      //      )
      //    ) {
      //      store.dispatch("checkRouteExistence");
      //    } else {
      //      next();
      //    }
      //  }, 10);
      //},
      meta: { layout: "app", title: "new-customer" },
      component: require("./components/customers/addNewCustomer.vue").default,
    },
    {
      path: "/wallet",
      name: "wallet",
      //beforeEnter: (to, from, next) => {
      //  setTimeout(() => {
      //    if (
      //      !("Wallet" in JSON.parse(localStorage.getItem("user")).permissions)
      //    ) {
      //      store.dispatch("checkRouteExistence");
      //    } else {
      //      next();
      //    }
      //  }, 10);
      //},
      meta: { layout: "app", title: "wallet" },
      component: require("./components/wallet/wallet.vue").default,
    },
    {
      path: "/settings",
      name: "Settings",
      //beforeEnter: (to, from, next) => {
      //  setTimeout(() => {
      //    if (
      //      !(
      //        "Settings" in JSON.parse(localStorage.getItem("user")).permissions
      //      )
      //    ) {
      //      store.dispatch("checkRouteExistence");
      //    } else {
      //      next();
      //    }
      //  }, 10);
      //},
      meta: { layout: "app", title: "Settings", requireAuth: true },
      component: require("@/views/Pages/setting").default,
    },
  ],
});
//route guard
// router.beforeEach(async (to, from, next) => {
//   if (to.matched.some((record) => record.meta.requireAuth)) {
//     if (!localStorage.getItem("token")) {
//       next({
//         name: "Login",
//       });
//     } else {
//       next();
//     }
//   } else {
//     next();
//   }
// });

export default router;
