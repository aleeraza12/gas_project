<template>
  <v-app id="app">
    <v-main>
      <component :is="layout" />
    </v-main>
  </v-app>
</template>
<script>
const default_layout = "app";
import { eventBus } from "@/main";
export default {
  components: {
    "simple-layout": () => import("@/components/Layouts/simpleLayout"),
    "app-layout": () => import("@/components/Layouts/AppLayout"),
  },
  computed: {
    layout() {
      return (this.$route.meta.layout || default_layout) + "-layout";
    },
  },
  updated() {
    //if internet is not connected
    if (navigator.onLine === false) eventBus.$emit("snackbarMsg");
  },
  created() {},
  methods: {},
  watch: {
    $route: {
      handler: (to) => {
        document.title = to.meta.title + "-" + `Sample`;
      },
      immediate: true,
    },
  },
  data() {
    return {};
  },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

.v-navigation-drawer__content {
  height: 100%;
  overflow-y: hidden !important;
  overflow-x: hidden;
}
#nav {
  padding: 30px;
}

#nav a {
  font-weight: bold;
  color: #2c3e50;
}

#nav a.router-link-exact-active {
  color: #42b983;
}
</style>
