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
          <div class="mr-5 mt-2">
            <v-icon> mdi-bell-outline</v-icon>
          </div>
        </div>
        <div class="d-flex mt-5">
          <div>
            <b> Companies</b>
          </div>
        </div>
        <div
          class="d-flex mt-5 pa-5"
          style="background-color: #ebebea; border-radius: 5px"
        >
          <div>
            <div class="d-flex align-start justify-start">
              <b>Total Companies</b>
            </div>
            <div class="d-flex align-start justify-start">
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
          <div><b>Transactions</b></div>
          <v-spacer></v-spacer>
          <div class="mr-3" style="border-bottom: 1px solid grey">
            Export Csv
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
            height="400px"
            :search="search"
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
            <!--<template v-slot:item.actions1="{ item }">
              <v-icon small class="mr-2" @click="editItem(item)">
                mdi-eye
              </v-icon>
            </template>-->
            <template v-slot:item.actions2="{ item }">
              <v-icon small class="mr-2" @click="setModal(item)">
                mdi-delete-forever
              </v-icon>
            </template>
          </v-data-table>
        </div>
      </v-card-text>
    </v-card>

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
    start_date: new Date().toISOString().substr(0, 10),
    end_date: new Date().toISOString().substr(0, 10),
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
      //{ text: "Edit", value: "actions1", sortable: false },
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
      console.log(value, "value");
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
    this.$store.commit("setSelectedDateRange", "Today");
  },
  methods: {
    getCompaniesListing(date) {
      this.loading = true;
      let requestBody = {
        start_date: date[0],
        end_date: date[1].concat(" 23:59:00"),
      };
      console.log("before dispatching", requestBody);
      this.$store.dispatch("getCompaniesListing", requestBody);
    },
    editItem(item) {
      console.log(item);
      //  this.$router.push("/new-customer");
      setTimeout(() => {
        eventBus.$emit("updategetCompanies", item);
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
        company_id: this.deleteable.id,
      };
      RequestService.post("company/delete", requestBody).then((response) => {
        if (response.data.status == 200) {
          this.loading = true;
          this.snackbar = true;
          this.snackbarColor = "success";
          this.snacbarMessage = "Your company(s) deleted successfully";
          this.$store.dispatch("getCompaniesListing");
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
  background-color: #ebebea;
  height: 55px;
  border-radius: 20px;
}
.searchbar {
  border-radius: 10px;
  background-color: white !important;
  width: 500px;
}
.table-head {
  background-color: #ebebea;
  font-size: 12px;
  height: 50px;
}
</style>
