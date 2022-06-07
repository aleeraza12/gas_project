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
          <div class="d-flex align-end justify-end">
            <v-btn small dense outlined @click="ViewAllTransactions()"
              >View All
              <v-icon small dense class="ml-2">mdi-eye-outline</v-icon></v-btn
            >
          </div>
        </div>
        <div class="d-flex mt-3">
          <div><b>Reconcilation</b></div>
          <v-spacer></v-spacer>
          <div class="mr-3" style="border-bottom: 1px solid grey">
            Export Csv
          </div>
          <div class="mr-3"><b>Date Picker</b></div>
        </div>
        <div class="mt-3">
          <v-tabs
            v-model="tab"
            background-color="#fff"
            color="black"
            dark
            class="mb-2"
          >
            <v-tab> Sales </v-tab>

            <v-tab> Purchases </v-tab>
          </v-tabs>

          <v-tabs-items v-model="tab">
            <v-tab-item>
              <v-data-table
                :headers="headers"
                :items="getSalesTransaction"
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
            <v-tab-item>
              <v-data-table
                :headers="headers"
                :items="getPurchasedTransaction"
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
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { eventBus } from "@/main";
import moment from "moment";
export default {
  data: () => ({
    tab: null,
    loading: true,
    search: "",
    getPurchasedTransaction: [],
    getSalesTransaction: [],
    headers: [
      {
        text: "Date",
        align: "start",
        sortable: false,
        value: "date",
      },
      { text: "Transaction Id", value: "id" },
      { text: "Customer Name", value: "customer_name" },
      { text: "Gas Quantity", value: "gas_quantity" },
      { text: "Amount", value: "amount" },
      { text: "Status", value: "status" },
      { text: "Updated by", value: "updated_by" },
      { text: "Payment Mode", value: "payment_mode" },
      { text: "View Receipt", value: "actions", sortable: false },
    ],
  }),
  computed: {
    ...mapGetters(["getAllTransactions"]),
  },
  components: {},
  created() {
    eventBus.$on("responseArrived", () => {
      this.loading = false;
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
    this.$store.dispatch("getAllTransacton");
  },
  methods: {
    ViewAllTransactions() {
      this.$router.push("/reconcilation");
    },
    getDate(date) {
      return moment(date.created_at).format("Do MMMM YYYY, h:mm a");
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
