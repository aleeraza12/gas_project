<template>
  <div>
    <v-card v-if="$vuetify.breakpoint.smAndDown">
      <v-app v-show="$vuetify.breakpoint.smAndDown">
        <v-app-bar
          app
          clipped-left
          class="app-bar-color"
          height="50"
          v-show="$vuetify.breakpoint.smAndDown"
        >
          <v-app-bar-nav-icon
            @click.stop="mblDrawer = !mblDrawer"
            v-show="$vuetify.breakpoint.smAndDown"
            color="#2b3896"
          ></v-app-bar-nav-icon>
        </v-app-bar>
      </v-app>
    </v-card>
    <v-card
      class="sidebar-card elevation-0"
      v-show="!$vuetify.breakpoint.smAndDown"
    >
      <v-navigation-drawer
        v-model="drawer"
        :mini-variant.sync="mini"
        permanent
        class="navaigation-side"
      >
        <v-list-item class="d-flex align-center justify-center ma-2 ml-0 pl-0">
          <!--<v-list-item-avatar>-->
          <img
            v-if="!mini"
            src="../../assets/images/side2.png"
            height="50"
            width="150"
            class="ml-1"
          />
          <img
            v-else
            src="../../assets/images/mn.png"
            height="30"
            width="120"
            class="ml-6"
          />
        </v-list-item>
        <v-divider></v-divider>
        <v-list>
          <v-list-item
            dense
            @click="Logout(link)"
            class="d-flex align-center pl-4 sidebar-item"
            :class="titleName == link.tabName ? 'selected-route' : ''"
            v-for="(link, i) in showable_links"
            :key="i"
            router
            @click.stop="mini = !mini"
            :to="link.route"
          >
            <!-- sidebar icons -->
            <div :id="link.icon">
              <v-icon
                class="mr-7 py-4"
                :color="titleName == link.tabName ? '#2b3896' : link.color"
                v-text="link.icon"
                size="19"
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

    <!-- for Moble -->
    <v-navigation-drawer
      class="d-md-none d-block h navaigation-side tests"
      v-model="mblDrawer"
      app
      absolute
      temporary
    >
      <v-list-item
        class="d-flex align-center justify-center ma-2 ml-0 pl-0 test"
      >
        <img
          src="../../assets/images/side2.png"
          height="40"
          width="120"
          class="ml-1"
        />
      </v-list-item>
      <v-list dense nav>
        <v-list-item-group v-model="group">
          <v-list-item
            dense
            @click="Logout(link)"
            class="d-flex align-center pl-4 sidebar-item"
            :class="titleName == link.tabName ? 'selected-route' : ''"
            v-for="(link, i) in showable_links"
            :key="i"
            router
            @click.stop="mini = !mini"
            :to="link.route"
          >
            <div :id="link.icon">
              <v-icon
                class="mr-7 py-4"
                :color="titleName == link.tabName ? '#2b3896' : link.color"
                v-text="link.icon"
                size="19"
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
            <div>
              <span class="text-capitalize body-2 font-weight-bold">
                {{ link.text }}
              </span>
            </div>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>
  </div>
</template>
<script>
import axios from "axios";
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      drawer: true,
      mblDrawer: false,
      titleName: "",
      user: JSON.parse(localStorage.getItem("user")),
      start_date: "2021-01-01",
      end_date: new Date().toISOString().substr(0, 10),
      group: null,
      links: [
        {
          text: "Dashboard",
          icon: "mdi-view-dashboard",
          route: "/dashboard",
          tabName: "Dashboard",
          color: "#fff",
        },
        {
          text: "Orders",
          icon: "mdi-chart-line",
          route: "/orders",
          tabName: "Orders",
          color: "#fff",
        },
        {
          text: "Companies",
          icon: "mdi-home-modern",
          route: "/companies",
          tabName: "Companies",
          color: "#fff",
        },
        {
          text: "Sales",
          icon: "mdi-cart-outline",
          route: "/sales",
          tabName: "Sales",
          color: "#fff",
        },
        {
          text: "Purchases",
          icon: "mdi-shopping",
          route: "/purchases",
          tabName: "Purchases",
          color: "#fff",
        },
        {
          text: "Customers",
          icon: "mdi-account-multiple-outline",
          route: "/customers",
          tabName: "Customers",
          color: "#fff",
        },
        {
          text: "Users",
          icon: "mdi-account-outline",
          route: "/users",
          tabName: "Users",
          color: "#fff",
        },
        {
          text: "Wallet",
          icon: "mdi-credit-card",
          route: "/wallet",
          tabName: "Wallet",
          color: "#fff",
        },
        {
          text: "Reconciliation",
          icon: "mdi-trackpad",
          route: "/reconcilation",
          tabName: "Reconciliation",
          color: "#fff",
        },
        {
          text: "Settings",
          icon: "mdi-cog",
          route: "/settings",
          tabName: "Settings",
          color: "#fff",
        },
        {
          text: "Promos",
          icon: "mdi-cash-multiple",
          route: "/promos",
          tabName: "Promos",
          color: "#fff",
        },
        {
          text: "Rate List",
          icon: "mdi-cash",
          route: "/rate_list",
          tabName: "Rate List",
          color: "#fff",
        },
        {
          text: "AdminSettings",
          icon: "mdi-cog",
          route: "/admin-settings",
          tabName: "AdminSettings",
          color: "#fff",
        },
        {
          text: "Logout",
          icon: "mdi-logout",
          route: "/logout",
          tabName: "Logout",
          color: "#fff",
        },
      ],
      mini: true,
      showable_links: [],
    };
  },
  components: {},
  created() {},
  mounted() {
    this.titleName = this.$route.name;
    let requestBody = {
      start_date: this.start_date,
      end_date: this.end_date.concat(" 23:59:00"),
    };
    this.$store.dispatch("getUsersListing", requestBody);
    this.$store.dispatch("getSalesListings", requestBody);
    this.setPerimssions();
  },
  computed: {
    ...mapGetters(["getSales", "getUsers"]),
  },
  watch: {
    group() {
      this.mblDrawer = false;
    },
  },
  methods: {
    setPerimssions() {
      let permissions = JSON.parse(localStorage.getItem("user")).permissions;

      this.showable_links = [];
      for (let j = 0; j < permissions.length; j++) {
        for (let w = 0; w < this.links.length; w++) {
          if (this.links[w].text === permissions[j])
            this.showable_links.push(this.links[w]);
        }
      }
      this.showable_links.push(this.links[this.links.length - 1]);
    },
    Logout(rout) {
      this.titleName = rout.text;
      if (rout.text == "Logout") {
        this.$router.push("login");
        let url = this.$store.state.url;
        let requestBody = {
          token: localStorage.getItem("token"),
        };
        axios.post(url + "logout", requestBody).then(() => {
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
.h {
  height: 200vh !important;
}
.sidebar-card {
  height: 100vh;
  border-radius: 0px !important;
}
.navaigation-side {
  background-color: #2b3896 !important;
}
.sidebar-item {
  color: #fff !important;
  font-size: 14px !important;
  max-height: 47px !important;
  /*min-height: 30px !important;*/
}
.sidebar-item:active {
  background-color: #fff;
  color: #2b3896 !important;
  border-left: 1px solid #fff !important;
}
.selected-route {
  border: 1px solid white;
  border-top-left-radius: 30px;
  border-bottom-left-radius: 30px;
  border-left: 10px solid #2b3896;
  border-bottom: 1px solid #2b3896;
  border-top: 1px solid #2b3896;
  background-color: white;
  color: #2b3896 !important;
}
.app-bar-color {
  color: #2b3896 !important;
}
</style>
<style>
.v-list-group--active {
  border-left: 5px solid #fff important;
}
.v-overlay.v-overlay--absolute.v-overlay--active.theme--dark {
  opacity: 0 !important;
  background-color: none !important;
}
</style>
