<template>
  <div class="no-print">
    <v-card class="sidebar-card elevation-0 no-print">
      <v-navigation-drawer
        v-model="drawer"
        :mini-variant.sync="mini"
        permanent
        class="navaigation-side"
      >
        <v-list-item class="d-flex align-center justify-center ma-2">
          <v-list-item-avatar>
            <v-img
              :src="'data:image/jpeg;base64,' + user.company_profile_picture"
              v-if="user.company_profile_picture != null"
            ></v-img>
            <v-avatar color="white" v-else>
              <v-icon dark> mdi-account-circle </v-icon>
            </v-avatar>
          </v-list-item-avatar>
        </v-list-item>
        <v-divider></v-divider>
        <v-list>
          <v-list-item
            dense
            @click="Logout(link)"
            class="d-flex align-center pl-4 sidebar-item"
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
                :color="link.color"
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
  </div>
</template>
<script>
import axios from "axios";
import { mapGetters } from "vuex";

export default {
  data: () => ({
    drawer: true,
    titleName: "",
    user: JSON.parse(localStorage.getItem("user")),
    start_date: "2021-01-01",
    end_date: new Date().toISOString().substr(0, 10),
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
        text: "Companies",
        icon: "mdi-home-modern",
        route: "/companies",
        tabName: "Companies",
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
        text: "Reconciliation",
        icon: "mdi-trackpad",
        route: "/reconcilation",
        tabName: "Reconcilation",
        color: "black",
      },
      {
        text: "Settings",
        icon: "mdi-cog",
        route: "/settings",
        tabName: "Settings",
        color: "black",
      },
      {
        text: "AdminSettings",
        icon: "mdi-cog",
        route: "/admin-settings",
        tabName: "AdminSettings",
        color: "black",
      },
      {
        text: "Logout",
        icon: "mdi-logout",
        route: "/logout",
        tabName: "Logout",
        color: "black",
      },
    ],
    mini: false,
    showable_links: [],
  }),
  components: {},
  created() {},
  mounted() {
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
  watch: {},
  methods: {
    setPerimssions() {
      console.log("ths functn called for permsson");
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
    getColor(link, titleName, index) {
      titleName == link.tabName
        ? (this.links[index].color = "#215549")
        : (this.links[index].color = "black");
    },
    Logout(rout) {
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
.sidebar-card {
  height: 100vh;
  border-radius: 0px !important;
}
.navaigation-side {
  background-color: #ebebea !important;
}
.sidebar-item:hover {
  background-color: #fff;
}
@media print {
  .no-print,
  .no-print * {
    display: none !important;
  }
}
</style>
