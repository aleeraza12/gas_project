<template>
  <div id="app">
    <v-app id="inspire">
      <v-app-bar app clipped-left class="app-bar-color" height="50">
        <v-app-bar-nav-icon
          @click.stop="drawer = !drawer"
          v-show="$vuetify.breakpoint.mdAndDown"
          color="#dcd8f3"
        ></v-app-bar-nav-icon>
        <img
          v-show="!$vuetify.breakpoint.mdAndDown"
          height="30px"
          width="120px"
          src="../assets/images/Capperwhite textLogo.svg"
          alt="moody"
        />
        <v-tabs
          id="main-menu"
          class="ml-2"
          v-show="!$vuetify.breakpoint.mdAndDown"
        >
          <v-tabs-slider class="cstm-slider"></v-tabs-slider>
          <v-tab
            :transition="false"
            v-if="loggedInUserPermission.includes('dashboard_statistics_read')"
            to="/admin_dashboard"
            class="ml-2"
            :class="titleName == 'Admin Dashboard' ? 'active-tab' : ''"
          >
            <v-icon
              :color="titleName == 'Admin Dashboard' ? '#2a206a' : 'white'"
              size="14"
              class="mr-1"
              >mdi-view-dashboard</v-icon
            ><span
              :class="
                titleName == 'Admin Dashboard'
                  ? 'selected-tab'
                  : 'unselected-tab'
              "
              class="text-capitalize"
              >Dashboard</span
            ></v-tab
          >
          <v-tab
            v-if="loggedInUserPermission.includes('receive_task')"
            to="/AnnotationBoard"
            :class="titleName == 'Annotate Board' ? 'active-tab' : ''"
            ><v-icon
              :color="titleName == 'Annotate Board' ? '#2a206a' : 'white'"
              size="14"
              class="mr-1"
              >mdi-developer-board</v-icon
            ><span
              :class="
                titleName == 'Annotate Board'
                  ? 'selected-tab'
                  : 'unselected-tab'
              "
              class="text-capitalize"
              >Annotation Board</span
            ></v-tab
          >
          <v-tab
            v-if="loggedInUserPermission.includes('receive_audit_task')"
            to="/AuditorBoard"
            :class="titleName == 'Annotate Auditor' ? 'active-tab' : ''"
          >
            <v-icon
              :color="titleName == 'Annotate Auditor' ? '#2a206a' : 'white'"
              size="18"
              class="mr-1"
              >mdi-clock-fast</v-icon
            ><span
              :class="
                titleName == 'Annotate Auditor'
                  ? 'selected-tab'
                  : 'unselected-tab'
              "
              class="text-capitalize"
              >Annotation Auditor</span
            ></v-tab
          >
          <v-tab
            v-if="loggedInUserPermission.includes('view_report_page')"
            to="/Reports"
            :class="titleName == 'Reports' ? 'active-tab' : ''"
          >
            <v-icon
              :color="titleName == 'Reports' ? '#2a206a' : 'white'"
              size="14"
              class="mr-1"
              >mdi-chart-line</v-icon
            ><span
              :class="
                titleName == 'Reports' ? 'selected-tab' : 'unselected-tab'
              "
              class="text-capitalize"
              >Reports</span
            ></v-tab
          >
          <v-tab
            v-if="loggedInUserPermission.includes('view_live_tasks')"
            to="/LiveTasks"
            :class="titleName == 'Live Tasks' ? 'active-tab' : ''"
            ><v-icon
              :color="titleName == 'Live Tasks' ? '#2a206a' : 'white'"
              size="14"
              class="mr-1"
              >mdi-bulletin-board</v-icon
            ><span
              :class="
                titleName == 'Live Tasks' ? 'selected-tab' : 'unselected-tab'
              "
              class="text-capitalize"
              >Live Tasks</span
            ></v-tab
          >
          <v-tab
            v-if="loggedInUserPermission.includes('view_users')"
            to="/Users"
            :class="titleName == 'Users' ? 'active-tab' : ''"
          >
            <v-icon
              :color="titleName == 'Users' ? '#2a206a' : 'white'"
              size="14"
              class="mr-1"
              >mdi-account-multiple</v-icon
            ><span
              :class="titleName == 'Users' ? 'selected-tab' : 'unselected-tab'"
              class="text-capitalize"
              >Users</span
            ></v-tab
          >
          <v-tab
            v-if="loggedInUserPermission.includes('view_settings')"
            to="/Settings"
            :class="titleName == 'Settings' ? 'active-tab' : ''"
          >
            <v-icon
              :color="titleName == 'Settings' ? '#2a206a' : 'white'"
              size="14"
              class="mr-1"
              >mdi-cog</v-icon
            ><span
              :class="
                titleName == 'Settings' ? 'selected-tab' : 'unselected-tab'
              "
              class="text-capitalize"
              >Settings</span
            ></v-tab
          >
        </v-tabs>
        <v-spacer> </v-spacer> <Searchreport /> <DatePicker /> <AddUserButton />
        <div>
          <v-avatar color="#dcd8f3" size="32" class="mr-1 ml-1">
            <span class="text-h5" color="rgb(51 11 107)">{{ userName }}</span>
          </v-avatar>
        </div>
        <v-menu nudge-bottom="11px" offset-y>
          <template v-slot:activator="{ on, attrs }">
            <span
              class="font-weight-bold white--text"
              style="font-size: 0.95rem !important"
              v-bind="attrs"
              v-on="on"
              >{{ loggedInUserDetail.name }}
              <v-icon color="white" dark v-bind="attrs" v-on="on">
                mdi-chevron-down
              </v-icon>
            </span>
          </template>
          <v-list dense class="pointer">
            <v-list-item
              @click="
                deo_id = admin_id;
                EditUserdialog = true;
              "
            >
              <v-icon color="rgb(51 11 107)" size="22">mdi-account</v-icon>
              <v-list-item-title class="ml-2 font-weight-bold menu-text-color"
                >Account Settings</v-list-item-title
              >
            </v-list-item>
            <v-list-item @click="logout">
              <v-icon color="rgb(51 11 107)" size="22">mdi-logout</v-icon>
              <v-list-item-title class="ml-2 font-weight-bold menu-text-color"
                >Logout</v-list-item-title
              >
            </v-list-item>
          </v-list>
        </v-menu>
      </v-app-bar>
      <v-main>
        <v-navigation-drawer
          class="d-md-none d-block h"
          v-model="drawer"
          app
          absolute
          temporary
        >
          <v-list dense nav>
            <v-list-item-group
              v-model="group"
              active-class="deep-purple--text text--accent-4"
            >
              <v-list-item
                v-for="item in links"
                :key="item.title"
                link
                :to="item.route"
              >
                <v-list-item-icon>
                  <v-icon color="#2a206a">{{ item.icon }}</v-icon>
                </v-list-item-icon>
                <v-list-item-content class="drawer-text">
                  <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list-item-group>
          </v-list>
        </v-navigation-drawer>
        <router-view></router-view>
      </v-main>
    </v-app>
    <EditUserModal :EditUserdialog.sync="EditUserdialog" :deo_id="deo_id" />
  </div>
</template>
<script>
import EditUserModal from "../components/Users/UpdateProfile";
import AddUserButton from "../components/BaseLayoutComponents/addUser";
import DatePicker from "../components/BaseLayoutComponents/datePicker";
import Searchreport from "../components/BaseLayoutComponents/searchReports";
import moment from "moment";
export default {
  components: { EditUserModal, DatePicker, Searchreport, AddUserButton },
  props: { source: String },
  data() {
    return {
      drawer: false,
      annotateTask: false,
      deo_id: "",
      loggedInUserPermission: JSON.parse(
        localStorage.getItem("loggedInUserDetail")
      ).permissions,
      admin_id: JSON.parse(localStorage.getItem("loggedInUserId")),
      EditUserdialog: false,
      group: null,
      links: [
        {
          title: "Dashboard",
          icon: "mdi-view-dashboard",
          route: "/admin_dashboard",
        },
        {
          title: "Annotation Board",
          icon: "mdi-developer-board",
          route: "/AnnotationBoard",
        },
        {
          title: "Annotation Auditor",
          icon: "mdi-clock-fast",
          route: "/AuditorBoard",
        },
        { title: "Reports", icon: "mdi-chart-line", route: "/Reports" },
        {
          title: "Live Tasks",
          icon: "mdi-bulletin-board",
          route: "/LiveTasks",
        },
        { title: "Users", icon: "mdi-account-multiple", route: "/Users" },
        { title: "Settings", icon: "mdi-cog", route: "/Settings" },
      ],
      items: [
        { title: "Settings", icon: "mdi-account-circle" },
        { title: "Logout", icon: "mdi-logout" },
      ],
    };
  },
  computed: {
    loggedInUserDetail() {
      return JSON.parse(localStorage.getItem("loggedInUserDetail"));
    },
    titleName() {
      return this.$route.meta.title;
    },
    userName() {
      let name = this.loggedInUserDetail.name.split(" ");
      if (name.length > 1) {
        return (name[0].slice(0, 1) + name[1].slice(0, 1)).toUpperCase();
      }
      return (name[0].slice(0, 1) + name[0].slice(1, 2)).toUpperCase();
    },
  },
  methods: {
    /* * @Description * This function is used to set the format of data * @param none * @return void */ moment:
      function () {
        return moment();
      },
    /* * @Description * This function is used to logout the user * @param none * @return void / logout() { this.$store.dispatch("Logout"); }, /* * @Description * This function is used to check the permissions for app bar tabs * @param none * @return void */ allowedDrawerPermission() {
      for (let key in this.links) {
        if (this.links[key].title == "Dashboard") {
          if (
            !this.loggedInUserPermission.includes("dashboard_statistics_read")
          ) {
            this.links.splice(key, 1);
          }
        }
        if (this.links[key].title == "Annotation Board") {
          if (!this.loggedInUserPermission.includes("receive_task")) {
            this.links.splice(key, 1);
          }
        }
        if (this.links[key].title == "Annotation Auditor") {
          if (!this.loggedInUserPermission.includes("receive_audit_task")) {
            this.links.splice(key, 1);
          }
        }
        if (this.links[key].title == "Reports") {
          if (!this.loggedInUserPermission.includes("view_report_page")) {
            this.links.splice(key, 1);
          }
        }
        if (this.links[key].title == "Live Tasks") {
          if (!this.loggedInUserPermission.includes("view_live_tasks")) {
            this.links.splice(key, 1);
          }
        }
        if (this.links[key].title == "Users") {
          if (!this.loggedInUserPermission.includes("view_users")) {
            this.links.splice(key, 1);
          }
        }
        if (this.links[key].title == "Settings") {
          if (!this.loggedInUserPermission.includes("view_settings")) {
            this.links.splice(key, 1);
          }
        }
      }
    },
  },
  mounted() {
    this.allowedDrawerPermission();
  },
};
</script>
<style scoped>
.h {
  height: 200vh !important;
}
</style>
