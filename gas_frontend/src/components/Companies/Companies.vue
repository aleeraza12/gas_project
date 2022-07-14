<template>
  <div class="main-container">
    <v-card class="dashboard-card pa-0 elevation-0">
      <v-card-text>
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
            <b> Companies</b>
          </div>
        </div>
        <div
          class="d-flex mt-5 pa-5"
          style="background-color: #eff0fa; border-radius: 5px"
        >
          <div>
            <div
              class="d-flex align-start justify-start"
              style="color: #2b3896"
            >
              <b>Total Companies</b>
            </div>
            <div class="d-flex align-start justify-start total-amount">
              {{ getCompanies.length }}
            </div>
          </div>
          <v-spacer></v-spacer>
          <div class="d-flex align-end justify-end">
            <!--<v-btn small dense outlined @click="addNewCustomer()"
              >Add New <v-icon small dense class="ml-2">mdi-plus</v-icon></v-btn
            >-->
          </div>
        </div>
        <div class="d-flex mt-3">
          <div><b>Companies</b></div>
          <v-spacer></v-spacer>
          <div class="mr-3" style="border-bottom: 1px solid grey">
            <v-btn
              @click="btnClick()"
              depressed
              light
              text
              :ripple="false"
              height="5px"
              x-small
              dense
              class="text-capitalize pa-4 mb-n1 mt-2"
            >
              <span class="black--text">Export </span></v-btn
            >
          </div>
          <div class="mr-3"><date-picker /></div>
        </div>
        <div class="mt-3">
          <v-data-table
            :loading="loading"
            loading-text="Loading... Please wait"
            :headers="headers"
            :items="getCompanies"
            :items-per-page="5"
            class="elevation-1"
            hide-default-footer
            hide-default-header
            height="calc(100vh - 340px)"
            :search="search"
            :mobile-breakpoint="0"
          >
            <template v-slot:[`body.prepend`]="{ headers }">
              <th
                v-for="(header, i) in headers"
                :key="'A' + i"
                class="table-head"
              >
                <div class="d-flex ml-3">
                  {{ header.text }}
                </div>
              </th>
            </template>
            <template v-slot:item.actions1="{ item }">
              <v-icon
                small
                class="mr-2"
                color="success"
                @click="setApprovalModal(item)"
                v-show="loggedInUser.company_email != item.company_email"
              >
                mdi-checkbox-marked-circle-outline
              </v-icon>
            </template>
            <template v-slot:item.actions2="{ item }">
              <v-icon
                small
                class="mr-2"
                color="red"
                @click="setModal(item)"
                v-show="loggedInUser.company_email != item.company_email"
              >
                mdi-delete-forever
              </v-icon>
            </template>
          </v-data-table>
        </div>
      </v-card-text>
    </v-card>
    <!-- Delet Modal -->
    <v-dialog v-model="dialog" persistent max-width="410">
      <v-card>
        <v-card-title class="text-h7">
          Are you sure to delete this company?
        </v-card-title>
        <v-card-text
          >By deleting, All of this company data will be lost.</v-card-text
        >
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
    <!-- Approval Modal -->
    <v-dialog v-model="statusDialog" persistent max-width="410">
      <v-card>
        <v-card-title class="text-h7">
          Are you sure to {{ statusText }} this company?
        </v-card-title>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color=" black" small text @click="statusDialog = false">
            Cancel
          </v-btn>
          <v-btn color="success" small text @click="changeStatus()">
            Confirm
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
    <download-csv :json-data="getCompanies">
      <v-btn style="display: none" id="myBtn">
        <b>My custom button</b>
      </v-btn>
    </download-csv>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { eventBus } from "@/main";
import RequestService from "../../RequestService";
import datePicker from "../../views/Pages/datePicker.vue";
import VueJsonToCsv from "vue-json-to-csv";
import Vue from "vue";
Vue.component("downloadCsv", VueJsonToCsv);
export default {
  data: () => ({
    loading: true,
    search: "",
    deleteable: "",
    updateable: "",
    statusText: "",
    statusDialog: false,
    dialog: false,
    snacbarMessage: "",
    start_date: "2022-01-01",
    end_date: new Date().toISOString().substr(0, 10),
    loggedInUser: JSON.parse(localStorage.getItem("user")),
    snackbar: false,
    snackbarColor: "",
    headers: [
      {
        text: "Owner Name",
        align: "start",
        sortable: false,
        value: "owner_name",
      },
      { text: "Company Email", value: "company_email" },
      { text: "Company Name", value: "company_name" },
      { text: "Company Phone Number", value: "company_phone_number" },
      { text: "City", value: "city" },
      { text: "State", value: "state" },
      { text: "Status", value: "actions1", sortable: false },
      { text: "Delete", value: "actions2", sortable: false },
    ],
  }),
  components: {
    datePicker,
  },
  created() {
    eventBus.$on("responseArrived", () => {
      this.loading = false;
    });
    eventBus.$on("selectedCompanyDateFilter", (value) => {
      this.getCompaniesListing(value);
    });
  },
  watch: {
    getCompanies() {},
  },
  computed: {
    ...mapGetters(["getCompanies"]),
    getIcon() {
      return this.snackbarColor == "success"
        ? "mdi-checkbox-marked-circle"
        : "mdi-close-circle";
    },
  },
  mounted() {
    this.getCompaniesListing([this.start_date, this.end_date]);
    this.$store.commit("setSelectedDateRange", "All");
  },
  methods: {
    btnClick() {
      document.getElementById("myBtn").click();
    },
    getCompaniesListing(date) {
      this.loading = true;
      let requestBody = {
        start_date: date[0],
        end_date: date[1].concat(" 23:59:00"),
      };
      this.$store.dispatch("getCompaniesListing", requestBody);
    },
    setApprovalModal(item) {
      this.statusDialog = true;
      this.updateable = item;
      this.statusText = item.status == "Active" ? "Inactive" : "Active";
    },
    changeStatus() {
      this.statusDialog = false;
      let requestBody = {
        company_id: this.updateable.id,
        status: this.statusText,
      };
      RequestService.post("company/update_company_status", requestBody).then(
        (response) => {
          if (response.data.status == 200) {
            this.loading = true;
            this.snackbar = true;
            this.snackbarColor = "success";
            this.snacbarMessage = "Your company(s) status updated successfully";
            this.getCompaniesListing([this.start_date, this.end_date]);
          }
        }
      );
    },
    setModal(item) {
      this.dialog = true;
      this.deleteable = item;
    },
    deleteItem() {
      this.dialog = false;
      let requestBody = {
        company_id: this.deleteable.id,
      };
      RequestService.post("company/delete", requestBody).then((response) => {
        if (response.data.status == 200) {
          this.loading = true;
          this.snackbar = true;
          this.snackbarColor = "success";
          this.snacbarMessage = "Your company(s) deleted successfully";
          this.getCompaniesListing([this.start_date, this.end_date]);
        }
      });
    },
  },
};
</script>
<style scoped>
.total-amount {
  color: #2b3896;
  font-family: "Inter";
  font-style: normal;
  font-weight: 500;
  font-size: 22px;
}
.dashboard-card {
  height: 600px;

  border-radius: 0px !important;
}
.top-bar {
  background-color: #eff0fa;
  height: 55px;
  border-radius: 20px;
}
.searchbar {
  border-radius: 10px;
  background-color: white !important;
  width: 100% !important;
}
.table-head {
  background-color: #eff0fa;
  font-size: 12px;
  height: 50px;
}
</style>
