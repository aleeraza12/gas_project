import Vue from "vue";
import VueRouter from "vue-router";
Vue.use(VueRouter);
const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes: [
    {
      path: "/signup",
      name: "Sign up",
      meta: { layout: "simple" , title:"Sing Up" },
      component: require("@/views/Pages/SignUp").default
    },
    {
      path: "/",
      name: "Home",
      meta: { layout: "simple" , title:"Login" },
      component: require("@/views/Pages/Login").default
    },
    {
      path: "/login",
      name: "Login",
      meta: { layout: "simple" , title:"Login" },
      component: require("@/views/Pages/Login").default
    },
    {
      path: "/password-recover",
      name: "PasswordRecover",
      meta: { layout: "simple" , title:"Password Recover" },
      component: require("@/views/Pages/PasswordRecover").default
    },
    {
      path: "/mail-sent",
      name: "MailSent",
      meta: { layout: "simple" , title:"Mail Sent" },
      component: require("@/views/Pages/emailSent").default
    },
    {
      path: "/update-password",
      name: "Update Password",
      meta: { layout: "simple" , title:"Update Password" },
      component: require("@/views/Pages/updatePassword").default
    },
    {
      path: "/reset-message",
      name: "Reset Message",
      meta: { layout: "simple" , title:"Reset Message" },
      component: require("@/views/Pages/resetMessage").default
    },
    {
      path: "/dashboard",
      name: "Dashboard",
      meta: { layout: "app" , title:"Dashboard" },
      component: require("@/views/Pages/dashboard").default
    },
    {
      path: "/orders",
      name: "Orders",
      meta: { layout: "app" , title:"Orders" },
      component: require("@/views/Pages/orders").default
    },
    {
      path: "/sales",
      name: "Sales",
      meta: { layout: "app" , title:"Sales" },
      component: require("@/views/Pages/sales").default
    },
    {
      path: "/settings",
      name: "Settings",
      meta: { layout: "app" , title:"Settings" },
      component: require("@/views/Pages/setting").default
    }
  ]
});
// router.beforeEach(async(to, from, next) => {
//   if (to.matched.some(record => record.meta.requiresAuth)) {
//     if (!localStorage.getItem("token")) {
//       next({
//         name: "Login"
//       });
//     } else {
//       next();
//     }
//   } else {
//     next();
//   }
// });

export default router;
