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
            <b> Wallet</b>
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
              <b>Available Balance</b>
            </div>
            <div class="d-flex align-start justify-start total-amount">
              ₦ {{ Number(total_wallet_balance).toLocaleString() }}
            </div>
          </div>
          <v-spacer></v-spacer>
          <!--<div class="d-flex align-end justify-end">
            <v-btn small dense outlined
              >Withdraw
              <v-icon small dense class="ml-2">mdi-plus</v-icon></v-btn
            >
          </div>-->
        </div>
        <div class="d-flex mt-3">
          <div class="mt-4"><b>Withdraw History</b></div>
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
              <span style="color: #2e3995">Export </span></v-btn
            >
          </div>
          <div class="mr-3"><date-picker /></div>
        </div>
        <div class="mt-3">
          <v-data-table
            :headers="headers"
            :items="getWallet"
            :items-per-page="5"
            class="elevation-1"
            hide-default-header
            height="calc(100vh - 400px)"
            :search="search"
            :loading="tableloading"
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
            <template v-slot:item.amount="{ item }">
              ₦ {{ Number(item.amount).toLocaleString() }}
            </template>
            <template v-slot:item.status="{ item }">
              <v-chip
                class="ma-2"
                small
                :color="item.status == 'UnSuccessfull' ? 'red' : 'green'"
                label
                outlined
                >{{ item.status }}</v-chip
              >
            </template>
            <!--<template v-slot:item.actions="{ item }">
              <v-icon small class="mr-2" @click="editItem(item)">
                mdi-eye
              </v-icon>
            </template>-->
          </v-data-table>
        </div>
      </v-card-text>
    </v-card>
    <download-csv :json-data="getWallet">
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
    search: "",
    start_date: "2022-01-01",
    end_date: new Date().toISOString().substr(0, 10),
    total_wallet_balance: null,
    tableloading: true,
    headers: [
      {
        text: "Date",
        align: "start",
        sortable: false,
        value: "created_at",
      },
      { text: "Transaction_id", value: "transaction_id" },
      { text: "Account Name", value: "account_name" },
      { text: "Account Number", value: "account_number" },
      { text: "Amount", value: "amount" },
      { text: "Status", value: "status" },
      { text: "Authorized By", value: "authorized_by" },
    ],
  }),
  computed: {
    ...mapGetters(["getWallet"]),
  },
  components: {
    datePicker,
  },
  created() {
    eventBus.$on("responseArrived", () => {
      this.tableloading = false;
    });
    eventBus.$on("selectedWalletDateFilter", (value) => {
      this.getWalletListing(value);
    });
  },
  watch: {
    getWallet() {
      this.total_wallet_balance = 0;
      for (let i in this.getWallet)
        this.total_wallet_balance =
          this.total_wallet_balance + this.getWallet[i].amount;
    },
  },
  methods: {
    btnClick() {
      document.getElementById("myBtn").click();
    },
    getWalletListing(date) {
      this.tableloading = true;
      let requestBody = {
        start_date: date[0],
        end_date: date[1].concat(" 23:59:00"),
      };
      this.$store.dispatch("getAllWallets", requestBody);
    },
  },
  mounted() {
    this.getWalletListing([this.start_date, this.end_date]);
    this.$store.commit("setSelectedDateRange", "All");
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
