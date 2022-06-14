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

        <div
          class="d-flex mt-5 pa-5"
          style="background-color: #ebebea; border-radius: 5px"
        >
          <div>
            <div class="d-flex align-start justify-start">
              <b>Total Reconcilation</b>
            </div>
            <div class="d-flex align-start justify-start">
              {{ getAllTransactions.length }}
            </div>
          </div>
          <v-spacer></v-spacer>
          <!--<div class="d-flex align-end justify-end">
            <v-btn small dense outlined @click="ViewAllTransactions()"
              >View All
              <v-icon small dense class="ml-2">mdi-eye-outline</v-icon></v-btn
            >
          </div>-->
        </div>
        <div class="d-flex mt-3">
          <div class="mt-4"><b>Reconcilation</b></div>
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
          <v-tabs
            v-model="tab"
            background-color="#fff"
            color="black"
            dark
            dense
            class="mb-2"
          >
            <v-tab dense> Sales </v-tab>

            <v-tab dense> Purchases </v-tab>
          </v-tabs>

          <v-tabs-items v-model="tab">
            <v-tab-item>
              <v-data-table
                :headers="headers"
                :items="getSalesTransaction"
                :items-per-page="5"
                class="elevation-1"
                  style="border:1px solid rgb(235, 235, 234)"
                hide-default-header
                height="210px"
                :search="search"
                :loading="loading"
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
                <template v-slot:item.status="{ item }">
                  <v-chip
                    class="ma-2"
                    small
                    :color="item.status == 'not_verified' ? 'red' : 'green'"
                    label
                    outlined
                    >{{
                      item.status == "not_verified" ? "Pending" : "Reconcilled"
                    }}</v-chip
                  >
                </template>
                <template v-slot:item.payment_mode="{ item }" class="ml-3">
                  {{ item.payment_mode ? item.payment_mode : "---" }}
                </template>
                <!--<template v-slot:item.actions="{ item }">
                  <v-icon small class="mr-2" @click="ViewReceipt(item)">
                    mdi-eye
                  </v-icon>
                </template>-->
              </v-data-table>
            </v-tab-item>
            <v-tab-item>
              <v-data-table
                :headers="headers"
                :items="getPurchasedTransaction"
                :items-per-page="5"
                   class="elevation-1"
                  style="border:1px solid rgb(235, 235, 234)"
                hide-default-header
                height="210px"
                :search="search"
                :loading="loading"
              >
                <template v-slot:[`body.prepend`]="{ headers }">
                  <th
                    v-for="(header, i) in headers"
                    :key="'B' + i"
                    class="table-head"
                  >
                    <div class="d-flex ml-3">
                      {{ header.text }}
                    </div>
                  </th>
                </template>
                <template v-slot:item.status="{ item }">
                  <v-chip
                    class="ma-2"
                    small
                    :color="item.status == 'not_verified' ? 'red' : 'green'"
                    label
                    outlined
                    >{{
                      item.status == "not_verified" ? "Pending" : "Reconcilled"
                    }}</v-chip
                  >
                </template>
                <template v-slot:item.payment_mode="{ item }" class="ml-3">
                  {{ item.payment_mode ? item.payment_mode : "---" }}
                </template>
                <template v-slot:item.actions="{ item }">
                  <v-icon small class="mr-2" @click="ViewReceipt(item)">
                    mdi-eye
                  </v-icon>
                </template>
              </v-data-table>
            </v-tab-item>
          </v-tabs-items>
        </div>
      </v-card-text>
    </v-card>
    <download-csv :json-data="getAllTransactions">
      <v-btn style="display: none" id="myBtn">
        <b>My custom button</b>
      </v-btn>
    </download-csv>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { eventBus } from "@/main";
import datePicker from "../../views/Pages/datePicker.vue";
import VueJsonToCsv from "vue-json-to-csv";
import Vue from "vue";
Vue.component("downloadCsv", VueJsonToCsv);
export default {
  data: () => ({
    tab: null,
    loading: true,
    start_date: '2022-01-01',
    end_date: new Date().toISOString().substr(0, 10),
    search: "",
    getPurchasedTransaction: [],
    getSalesTransaction: [],
    headers: [
      {
        text: "Date",
        align: "start",
        sortable: false,
        value: "created_at",
      },
      { text: "Transaction Id", value: "id" },
      { text: "Customer Name", value: "customer_name" },
      { text: "Gas Quantity", value: "gas_quantity" },
      { text: "Amount", value: "amount" },
      { text: "Status", value: "status" },
      { text: "Updated by", value: "updated_by" },
      { text: "Payment Mode", value: "payment_mode" },
      //{ text: "View Receipt", value: "actions", sortable: false },
    ],
  }),
  computed: {
    ...mapGetters(["getAllTransactions"]),
  },
  components: {
    datePicker,
  },
  created() {
    eventBus.$on("responseArrived", () => {
      this.loading = false;
    });
    eventBus.$on("selectedReconcilationDateFilter", (value) => {
      this.getTransactions(value);
    });
  },
  watch: {
    getAllTransactions() {
      for (let j = 0; j < this.getAllTransactions.length; j++) {
        if (this.getAllTransactions[j].type == "sale") {
          this.getSalesTransaction.push(this.getAllTransactions[j]);
        } else this.getPurchasedTransaction.push(this.getAllTransactions[j]);
      }
    },
  },
  mounted() {
    this.getTransactions([this.start_date, this.end_date]);
    this.$store.commit("setSelectedDateRange", "All");
  },
  methods: {
     btnClick() {
      document.getElementById("myBtn").click();
    },
    getTransactions(date) {
      this.loading = true;
      let requestBody = {
        start_date: date[0],
        end_date: date[1].concat(" 23:59:00"),
      };
      this.getPurchasedTransaction = [];
      this.getSalesTransaction = [];
      this.$store.dispatch("getAllTransactions", requestBody);
    },
    ViewAllTransactions() {
      this.$router.push("/reconcilation");
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
<style>
.theme--dark.v-tabs > .v-tabs-bar .v-tab--disabled,
.theme--dark.v-tabs > .v-tabs-bar .v-tab:not(.v-tab--active),
.theme--dark.v-tabs > .v-tabs-bar .v-tab:not(.v-tab--active) > .v-btn,
.theme--dark.v-tabs > .v-tabs-bar .v-tab:not(.v-tab--active) > .v-icon {
  color: black !important;
}
</style>
