<template>
  <div>
    <v-card class="sidebar-card elevation-0">
      <v-navigation-drawer
        v-model="drawer"
        :mini-variant.sync="mini"
        permanent
        class="navaigation-side"
      >
        <v-list-item class="d-flex align-center justify-center ma-2">
          <v-list-item-avatar>
            <v-img src="https://randomuser.me/api/portraits/men/85.jpg"></v-img>
          </v-list-item-avatar>
        </v-list-item>
        <v-divider></v-divider>
        <v-list dense>
          <v-list-item
            @click="Logout(link)"
            class="d-flex align-center pl-4 sidebar-item"
            v-for="(link, i) in links"
            :key="i"
            router
            @click.stop="mini = !mini"
            :to="link.route"
          >
            <!-- sidebar icons -->
            <div :id="link.icon">
              <v-icon
                class="mr-7 py-4"
                :color="link.color"
                v-text="link.icon"
                size="25"
              ></v-icon>
            </div>
            <v-tooltip
              content-class="arrow-left"
              nudge-right="1"
              right
              color="#ffe7b8"
            >
              <span class="black--text"> {{ link.text }} </span>
            </v-tooltip>
            <!--sidebar text -->
            <div>
              <span class="text-capitalize body-2 font-weight-bold">
                {{ link.text }}
              </span>
            </div>
          </v-list-item>
        </v-list>
      </v-navigation-drawer>
    </v-card>
  </div>
</template>
<script>
import axios from "axios";
import { mapGetters } from "vuex";

export default {
  data: () => ({
    drawer: true,
    titleName: "",
    links: [
      {
        text: "Dashboard",
        icon: "mdi-view-dashboard",
        route: "/dashboard",
        tabName: "Dashboard",
        color: "black",
      },
      {
        text: "Orders",
        icon: "mdi-chart-line",
        route: "/orders",
        tabName: "Orders",
        color: "black",
      },
      {
        text: "Sales",
        icon: "mdi-cart-outline",
        route: "/sales",
        tabName: "Sales",
        color: "black",
      },
      {
        text: "Purchases",
        icon: "mdi-shopping",
        route: "/purchases",
        tabName: "Purchases",
        color: "black",
      },
      {
        text: "Customers",
        icon: "mdi-account-multiple-outline",
        route: "/customers",
        tabName: "Customers",
        color: "black",
      },
      {
        text: "Users",
        icon: "mdi-account-outline",
        route: "/users",
        tabName: "Users",
        color: "black",
      },
      {
        text: "Wallet",
        icon: "mdi-credit-card",
        route: "/wallet",
        tabName: "Wallet",
        color: "black",
      },
      {
        text: "Reconcilation",
        icon: "mdi-trackpad",
        route: "/reconcilation",
        tabName: "Reconcilation",
        color: "black",
      },
      // {
      //   text: "Settings",
      //   icon: "mdi-cog",
      //   route: "/settings",
      //   tabName: "Settings",
      //   color: "black",
      // },
      {
        text: "Logout",
        icon: "mdi-logout",
        route: "/logout",
        tabName: "Logout",
        color: "black",
      },
    ],
    mini: false,
  }),
  components: {},
  created() {},
  computed: {
    ...mapGetters(["getSales", "getUsers"]),
  },
  methods: {
    getColor(link, titleName, index) {
      titleName == link.tabName
        ? (this.links[index].color = "#215549")
        : (this.links[index].color = "black");
    },
    Logout(rout) {
      console.log("logout called", rout, this.getSales.length);

      if (rout.text == "Logout") {
        let url = this.$store.state.url;
        let requestBody = {
          token: localStorage.getItem("token"),
        };
        axios.post(url + "logout", requestBody).then(() => {
          this.$router.push("login");
          localStorage.removeItem("token");
          localStorage.removeItem("user");
        });
      } else if (rout.text == "Sales" && this.getSales.length == 0) {
        this.$router.push("no-sale");
      } else if (rout.text == "Users" && this.getUsers.length == 0) {
        this.$router.push("no-user");
      }
    },
  },
};
</script>
<style scoped>
.sidebar-card {
  height: 660px;
  border-radius: 0px !important;
}
.navaigation-side {
  background-color: #ebebea !important;
}
.sidebar-item:hover {
  background-color: #fff;
}
</style>
