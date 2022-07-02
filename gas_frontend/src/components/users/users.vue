<template>
  <div class="main-container">
    <!--<v-card class="dashboard-card pa-0 elevation-0">-->
    <!--<v-card-text>-->
    <div class="d-flex top-bar pt-2">
      <div class="ml-2">
        <v-text-field
          placeholder="search..."
          outlined
          dense
          prepend-inner-icon="mdi-magnify"
          hide-details
          class="searchbar"
          v-model="search"
        ></v-text-field>
      </div>
      <v-spacer></v-spacer>
      <!--<div class="mr-5 mt-2">
            <v-icon> mdi-bell-outline</v-icon>
          </div>-->
    </div>
    <div class="d-flex mt-5">
      <div>
        <b> Users</b>
      </div>
    </div>
    <div
      class="d-flex mt-5 pa-5"
      style="background-color: #eff0fa; border-radius: 5px"
    >
      <div>
        <div class="d-flex align-start justify-start">
          <b>Total Users</b>
        </div>
        <div class="d-flex align-start justify-start">
          {{ getUsers.length }}
        </div>
      </div>
      <v-spacer></v-spacer>
      <div class="d-flex align-end justify-end">
        <v-btn small dense outlined color="#2b3896" @click="addNewUser()"
          >Add New <v-icon small dense class="ml-2">mdi-plus</v-icon></v-btn
        >
      </div>
    </div>
    <div class="d-flex mt-3">
      <div class="mt-4"><b>History</b></div>
      <v-spacer></v-spacer>
      <div class="mr-3"><date-picker /></div>
    </div>
    <div class="mt-3">
      <v-data-table
        :loading="loading"
        loading-text="Loading... Please wait"
        :headers="headers"
        :items="getUsers"
        :items-per-page="5"
        class="elevation-1"
        hide-default-header
        height="calc(100vh - 400px)"
        :search="search"
        :mobile-breakpoint="0"
      >
        <template v-slot:[`body.prepend`]="{ headers }">
          <th v-for="(header, i) in headers" :key="'A' + i" class="table-head">
            <div class="d-flex ml-3">
              {{ header.text }}
            </div>
          </th>
        </template>
        <template v-slot:item.actions1="{ item }">
          <v-icon small class="mr-2" @click="editItem(item)">
            mdi-pencil
          </v-icon>
        </template>
        <template v-slot:item.actions2="{ item }">
          <v-icon small class="mr-2" @click="setModal(item)" color="red">
            mdi-delete-empty
          </v-icon>
        </template>
      </v-data-table>
    </div>
    <!--</v-card-text>
    </v-card>-->
    <v-dialog v-model="dialog" persistent max-width="390">
      <v-card>
        <v-card-title class="text-h7">
          Are you sure to delete this user?
        </v-card-title>
        <v-card-text>By deleting, All of its data will be lost.</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color=" black" small text @click="dialog = false">
            Cancel
          </v-btn>
          <v-btn color="red darken-1" small text @click="deleteItem()">
            Delete
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-snackbar
      v-model="snackbar"
      :timeout="2000"
      :value="true"
      absolute
      class="mt-5"
      :color="snackbarColor"
      shaped
      :right="true"
      :top="true"
      text
    >
      <v-icon class="pr-3" :color="snackbarColor">{{ getIcon }} </v-icon>
      {{ snacbarMessage }}
    </v-snackbar>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { eventBus } from "@/main";
import RequestService from "../../RequestService";
import datePicker from "../../views/Pages/datePicker.vue";
export default {
  data: () => ({
    loading: true,
    search: "",
    deleteable: "",
    dialog: false,
    snacbarMessage: "",
    snackbar: false,
    snackbarColor: "",
    start_date: "2022-01-01",
    end_date: new Date().toISOString().substr(0, 10),
    headers: [
      {
        text: "User Name",
        align: "start",
        sortable: false,

        value: "name",
      },
      { text: "Designation", value: "designation" },
      { text: "User Type", value: "user_type" },
      { text: "Status", value: "status" },
      { text: "Access Granted", value: "permissions" },
      { text: "Created By", value: "created_by" },
      { text: "Edit", value: "actions1", sortable: false },
      { text: "Delete", value: "actions2", sortable: false },
    ],
  }),
  components: {
    datePicker,
  },
  watch: {
    getUsers() {},
  },
  computed: {
    ...mapGetters(["getUsers"]),
    getIcon() {
      return this.snackbarColor == "success"
        ? "mdi-checkbox-marked-circle"
        : "mdi-close-circle";
    },
  },
  created() {
    eventBus.$on("responseArrived", () => {
      this.loading = false;
    });
    eventBus.$on("selectedUsersDateFilter", (value) => {
      this.getUsersListing(value);
    });
  },
  mounted() {
    this.getUsersListing([this.start_date, this.end_date]);
    this.$store.commit("setSelectedDateRange", "All");
  },
  methods: {
    getUsersListing(date) {
      this.loading = true;
      let requestBody = {
        start_date: date[0],
        end_date: date[1].concat(" 23:59:00"),
      };
      this.$store.dispatch("getUsersListing", requestBody);
    },
    addNewUser() {
      this.$router.push("/new-user");
    },
    editItem(item) {
      this.$router.push("/new-user");
      setTimeout(() => {
        eventBus.$emit("updateUser", item);
      }, 100);
      //this.$store.commit("SET_SINGLE_CUSTOMER_DATA", item);
    },
    setModal(item) {
      this.dialog = true;
      this.deleteable = item;
    },
    deleteItem() {
      this.dialog = false;
      let requestBody = {
        users_id: this.deleteable.id,
      };
      RequestService.post("user/delete", requestBody).then((response) => {
        if (response.data.status == 200) {
          this.loading = true;
          this.snackbar = true;
          this.snackbarColor = "success";
          this.snacbarMessage = "Your user(s) deleted successfully";
          this.$store.dispatch("getUsersListing");
        }
      });
    },
  },
};
</script>
<style scoped>
.dashboard-card {
  height: 600px;
  border-radius: 0px !important;
}
.top-bar {
  background: #eff0fa;
  height: 55px;
  border-radius: 20px;
  width: 100%;
}
.searchbar {
  border-radius: 10px;
  background-color: white !important;
  width: 100% !important;
}
.table-head {
  background: #eff0fa;
  font-size: 12px;
  height: 50px;
}
</style>
