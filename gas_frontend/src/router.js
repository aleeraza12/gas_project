import Vue from "vue";
import VueRouter from "vue-router";
import store from "./store/index";

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
      path: "/pageNotFound",
      name: "pageNotFound",
      meta: { layout: "simple", title: "404" },
      component: require("../src/PageNotFound").default,
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
      beforeEnter: (to, from, next) => {
        setTimeout(() => {
          if (
            !JSON.parse(localStorage.getItem("user")).permissions.includes(
              "Dashboard"
            )
          ) {
            store.dispatch("checkRouteExistence");
          } else {
            next();
          }
        }, 10);
      },
      meta: { layout: "app", title: "Dashboard", requireAuth: true },
      component: require("@/views/Pages/dashboard").default,
    },
    {
      path: "/orders",
      name: "Orders",
      beforeEnter: (to, from, next) => {
        setTimeout(() => {
          if (
            !JSON.parse(localStorage.getItem("user")).permissions.includes(
              "Orders"
            )
          ) {
            store.dispatch("checkRouteExistence");
          } else {
            next();
          }
        }, 10);
      },
      meta: { layout: "app", title: "Orders", requireAuth: true },
      component: require("@/views/Pages/orders").default,
    },
    {
      path: "/companies",
      name: "Companies",
      beforeEnter: (to, from, next) => {
        setTimeout(() => {
          if (
            !JSON.parse(localStorage.getItem("user")).permissions.includes(
              "Companies"
            )
          ) {
            store.dispatch("checkRouteExistence");
          } else {
            next();
          }
        }, 10);
      },
      meta: { layout: "app", title: "Companies", requireAuth: true },
      component: require("../src/components/Companies/Companies.vue").default,
    },
    {
      path: "/sales",
      name: "Sales",
      beforeEnter: (to, from, next) => {
        setTimeout(() => {
          if (
            !JSON.parse(localStorage.getItem("user")).permissions.includes(
              "Sales"
            )
          ) {
            store.dispatch("checkRouteExistence");
          } else {
            next();
          }
        }, 10);
      },
      meta: { layout: "app", title: "Sales", requireAuth: true },
      component: require("@/views/Pages/sales").default,
    },
    {
      path: "/purchases",
      name: "Purchases",
      beforeEnter: (to, from, next) => {
        setTimeout(() => {
          if (
            !JSON.parse(localStorage.getItem("user")).permissions.includes(
              "Purchases"
            )
          ) {
            store.dispatch("checkRouteExistence");
          } else {
            next();
          }
        }, 10);
      },
      meta: { layout: "app", title: "Purchases", requireAuth: true },
      component: require("@/views/Pages/purchases").default,
    },
    {
      path: "/depot",
      name: "depot",
      beforeEnter: (to, from, next) => {
        setTimeout(() => {
          if (
            !JSON.parse(localStorage.getItem("user")).permissions.includes(
              "Purchases"
            )
          ) {
            store.dispatch("checkRouteExistence");
          } else {
            next();
          }
        }, 10);
      },
      meta: { layout: "app", title: "Depot", requireAuth: true },
      component: require("./components/purchases/depot").default,
    },
    {
      path: "/customers",
      name: "Customers",
      beforeEnter: (to, from, next) => {
        setTimeout(() => {
          if (
            !JSON.parse(localStorage.getItem("user")).permissions.includes(
              "Customers"
            )
          ) {
            store.dispatch("checkRouteExistence");
          } else {
            next();
          }
        }, 10);
      },
      meta: { layout: "app", title: "Customers", requireAuth: true },
      component: require("@/views/Pages/customers").default,
    },
    {
      path: "/users",
      name: "Users",
      beforeEnter: (to, from, next) => {
        setTimeout(() => {
          if (
            !JSON.parse(localStorage.getItem("user")).permissions.includes(
              "Users"
            )
          ) {
            store.dispatch("checkRouteExistence");
          } else {
            next();
          }
        }, 10);
      },
      meta: { layout: "app", title: "Users" },
      component: require("@/views/Pages/users").default,
    },

    {
      path: "/reconcilation",
      name: "Reconcilation",
      beforeEnter: (to, from, next) => {
        setTimeout(() => {
          if (
            !JSON.parse(localStorage.getItem("user")).permissions.includes(
              "Reconciliation"
            )
          ) {
            store.dispatch("checkRouteExistence");
          } else {
            next();
          }
        }, 10);
      },
      meta: { layout: "app", title: "Reconcilation-tabs", requireAuth: true },
      component: require("./components/reconcilation/reconcilation-tabs")
        .default,
    },
    {
      path: "/sale-receipt-form",
      name: "sale-receipt-form",
      beforeEnter: (to, from, next) => {
        setTimeout(() => {
          if (
            !JSON.parse(localStorage.getItem("user")).permissions.includes(
              "Sales"
            )
          ) {
            store.dispatch("checkRouteExistence");
          } else {
            next();
          }
        }, 10);
      },
      meta: { layout: "app", title: "sale-receipt-form", requireAuth: true },
      component: require("./components/forms/sale-receipt-form.vue").default,
    },
    {
      path: "/sale-invoice",
      name: "sale-invoice",
      beforeEnter: (to, from, next) => {
        setTimeout(() => {
          if (
            !JSON.parse(localStorage.getItem("user")).permissions.includes(
              "Sales"
            )
          ) {
            store.dispatch("checkRouteExistence");
          } else {
            next();
          }
        }, 10);
      },
      meta: { layout: "app", title: "sale-invoice", requireAuth: true },
      component: require("./components/sales/saleInvoice").default,
    },

    {
      path: "/purchase-receipt-form",
      name: "purchase-receipt-form",
      beforeEnter: (to, from, next) => {
        setTimeout(() => {
          if (
            !JSON.parse(localStorage.getItem("user")).permissions.includes(
              "Purchases"
            )
          ) {
            store.dispatch("checkRouteExistence");
          } else {
            next();
          }
        }, 10);
      },
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
      beforeEnter: (to, from, next) => {
        setTimeout(() => {
          if (
            !JSON.parse(localStorage.getItem("user")).permissions.includes(
              "Sales"
            )
          ) {
            store.dispatch("checkRouteExistence");
          } else {
            next();
          }
        }, 10);
      },
      name: "sales-details",
      meta: { layout: "app", title: "sales-details" },
      component: require("./components/sales/sales-details.vue").default,
    },
    {
      path: "/purchase-details",
      name: "purchase-details",
      beforeEnter: (to, from, next) => {
        setTimeout(() => {
          if (
            !JSON.parse(localStorage.getItem("user")).permissions.includes(
              "Purchases"
            )
          ) {
            store.dispatch("checkRouteExistence");
          } else {
            next();
          }
        }, 10);
      },
      meta: { layout: "app", title: "purchase-details" },
      component: require("./components/purchases/purchase-details").default,
    },
    {
      path: "/order-details",
      name: "order-details",
      beforeEnter: (to, from, next) => {
        setTimeout(() => {
          if (
            !JSON.parse(localStorage.getItem("user")).permissions.includes(
              "Orders"
            )
          ) {
            store.dispatch("checkRouteExistence");
          } else {
            next();
          }
        }, 10);
      },
      meta: { layout: "app", title: "order-details" },
      component: require("./components/orders/order-details.vue").default,
    },
    {
      path: "/no-sale",
      name: "no-sales",
      beforeEnter: (to, from, next) => {
        setTimeout(() => {
          if (
            !JSON.parse(localStorage.getItem("user")).permissions.includes(
              "Sales"
            )
          ) {
            store.dispatch("checkRouteExistence");
          } else {
            next();
          }
        }, 10);
      },
      meta: { layout: "app", title: "no-sales" },
      component: require("./components/sales/no-sales.vue").default,
    },
    {
      path: "/no-order",
      name: "no-orders",
      beforeEnter: (to, from, next) => {
        setTimeout(() => {
          if (
            !JSON.parse(localStorage.getItem("user")).permissions.includes(
              "Orders"
            )
          ) {
            store.dispatch("checkRouteExistence");
          } else {
            next();
          }
        }, 10);
      },
      meta: { layout: "app", title: "no-orders" },
      component: require("./components/orders/no-order").default,
    },
    {
      path: "/no-user",
      name: "no-user",
      beforeEnter: (to, from, next) => {
        setTimeout(() => {
          if (
            !JSON.parse(localStorage.getItem("user")).permissions.includes(
              "Users"
            )
          ) {
            store.dispatch("checkRouteExistence");
          } else {
            next();
          }
        }, 10);
      },
      meta: { layout: "app", title: "no-user" },
      component: require("./components/users/no-user.vue").default,
    },
    {
      path: "/new-user",
      name: "new-user",
      beforeEnter: (to, from, next) => {
        setTimeout(() => {
          if (
            !JSON.parse(localStorage.getItem("user")).permissions.includes(
              "Users"
            )
          ) {
            store.dispatch("checkRouteExistence");
          } else {
            next();
          }
        }, 10);
      },
      meta: { layout: "app", title: "new-user" },
      component: require("./components/users/addNewUser.vue").default,
    },
    {
      path: "/new-customer",
      name: "new-customer",
      beforeEnter: (to, from, next) => {
        setTimeout(() => {
          if (
            !JSON.parse(localStorage.getItem("user")).permissions.includes(
              "Customers"
            )
          ) {
            store.dispatch("checkRouteExistence");
          } else {
            next();
          }
        }, 10);
      },
      meta: { layout: "app", title: "new-customer" },
      component: require("./components/customers/addNewCustomer.vue").default,
    },
    {
      path: "/new-customer-company",
      name: "new-customer-company",
      beforeEnter: (to, from, next) => {
        setTimeout(() => {
          if (
            !JSON.parse(localStorage.getItem("user")).permissions.includes(
              "Customers"
            )
          ) {
            store.dispatch("checkRouteExistence");
          } else {
            next();
          }
        }, 10);
      },
      meta: { layout: "app", title: "new-customer-company" },
      component: require("./components/customers/new-customer-company").default,
    },
    {
      path: "/wallet",
      name: "wallet",
      beforeEnter: (to, from, next) => {
        setTimeout(() => {
          if (
            !JSON.parse(localStorage.getItem("user")).permissions.includes(
              "Wallet"
            )
          ) {
            store.dispatch("checkRouteExistence");
          } else {
            next();
          }
        }, 10);
      },
      meta: { layout: "app", title: "wallet" },
      component: require("./components/wallet/wallet.vue").default,
    },
    {
      path: "/settings",
      name: "Settings",
      beforeEnter: (to, from, next) => {
        setTimeout(() => {
          if (
            !JSON.parse(localStorage.getItem("user")).permissions.includes(
              "Settings"
            )
          ) {
            store.dispatch("checkRouteExistence");
          } else {
            next();
          }
        }, 10);
      },
      meta: { layout: "app", title: "Settings", requireAuth: true },
      component: require("../src/components/customers/new-customer-company.vue")
        .default,
    },
    {
      path: "/admin-settings",
      name: "AdminSettings",
      beforeEnter: (to, from, next) => {
        setTimeout(() => {
          if (
            !JSON.parse(localStorage.getItem("user")).permissions.includes(
              "AdminSettings"
            )
          ) {
            store.dispatch("checkRouteExistence");
          } else {
            next();
          }
        }, 10);
      },
      meta: { layout: "app", title: "AdminSettings", requireAuth: true },
      component: require("../src/components/setting/setting.vue").default,
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
