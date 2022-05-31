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
            ></v-text-field>
          </div>
          <v-spacer></v-spacer>
          <div class="mr-5 mt-2">
            <v-icon> mdi-bell-outline</v-icon>
          </div>
        </div>
        <div class="d-flex mt-5">
          <div>
            <b> Purchases</b>
          </div>
        </div>
        <div class="d-flex mt-5">
          <div>
            <v-card height="80" width="930" style="background-color: #ebebea">
              <v-card-text>
                <div class="d-flex">
                  <div>
                    <div class="d-flex align-start justify-start">
                      <b>Available Balance</b>
                    </div>
                    <div class="d-flex align-start justify-start">
                      165,00,0000 NAJRA
                    </div>
                  </div>
                  <v-spacer></v-spacer>
                  <div class="d-flex align-end justify-end">
                    <v-btn small dense outlined
                      >Add Receipt
                      <v-icon small dense class="ml-2">mdi-plus</v-icon></v-btn
                    >
                  </div>
                </div>
              </v-card-text>
            </v-card>
          </div>
        </div>
        <div class="d-flex mt-3">
          <div><b>History</b></div>
          <v-spacer></v-spacer>
          <div class="mr-3" style="border-bottom: 1px solid grey">
            Export Csv
          </div>
          <div class="mr-3"><b>Date Picker</b></div>
        </div>
        <div class="mt-3">
          <v-card >
            <v-card-text>
              <v-data-table
                :headers="headers"
                :items="getPurchases"
                :items-per-page="5"
                class="elevation-1"
                hide-default-footer
                hide-default-header
                height="230px"
              >
                <template v-slot:[`body.prepend`]="{ headers }">
                  <th
                    v-for="(header, i) in headers"
                    :key="i"
                    class="table-head"
                  >
                    <div class="d-flex ml-3">
                      {{ header.text }}
                    </div>
                  </th>
                </template>
              </v-data-table>
            </v-card-text>
          </v-card>
        </div>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data: () => ({
    headers: [
      {
        text: "Date",
        align: "start",
        sortable: false,
        value: "date",
      },
      { text: "Receipt Number", value: "receipt_number" },
      { text: "Company Name", value: "company_name" },
      { text: "Gas Quantity", value: "gas_quantity" },
      { text: "Amount", value: "amount" },
      { text: "Unit Price", value: "unit_price" },
      { text: "Status", value: "status" },
      { text: "Drver's Name", value: "driver_name" },
      { text: "Received By", value: "recepient_name" },
      { text: "Actions", value: "" },
    ],
  }),
  components: {},
  computed: {
    ...mapGetters(["getPurchases"]),
  },
  created() {},
  methods: {},
  watch: {
    getPurchases() {
      console.log("response", this.getPurchases);
    },
  },
  mounted() {
    this.$store.dispatch("getPurchaseListing");
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
