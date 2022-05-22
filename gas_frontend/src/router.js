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
