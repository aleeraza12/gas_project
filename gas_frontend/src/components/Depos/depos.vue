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
            <b> Depos</b>
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
              <b>Total</b>
            </div>
            <div class="d-flex align-start justify-start total-amount">
              {{ getAllDepos.length }}
            </div>
          </div>
        </div>
        <div class="d-flex mt-3">
          <div class="mt-4"><b>History</b></div>
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
        </div>
        <div class="mt-3">
          <v-data-table
            :loading="loading"
            loading-text="Loading... Please wait"
            :headers="Depoheaders"
            :items="getAllDepos"
            :items-per-page="5"
            class="elevation-1"
            hide-default-header
            height="260px"
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
          </v-data-table>
        </div>
      </v-card-text></v-card
    >
    <download-csv :json-data="getAllDepos">
      <v-btn style="display: none" id="myBtn">
        <b>My custom button</b>
      </v-btn>
    </download-csv>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { eventBus } from "@/main";
import moment from "moment";
import VueJsonToCsv from "vue-json-to-csv";
import Vue from "vue";
Vue.component("downloadCsv", VueJsonToCsv);
export default {
  data: () => ({
    loading: true,
    isDepo: false,
    search: "",
    Depoheaders: [
      { text: "Depot Name", value: "depo_name" },
      { text: "Location", value: "location" },
      { text: "Price(per 20MT)", value: "price_per_twenty_million_ton" },
      { text: "Update At", value: "updated_at" },
    ],
  }),

  computed: {
    ...mapGetters(["getAllDepos"]),
  },
  created() {
    eventBus.$on("responseArrivedDepo", () => {
      console.log("asfsdsdfas");
      this.loading = false;
    });
  },
  methods: {
    btnClick() {
      document.getElementById("myBtn").click();
    },
    getDate(date) {
      return moment(date.date).format("Do MMMM YYYY, h:mm a");
    },
  },
  watch: {},
  mounted() {
    console.log("sdsda");
    this.$store.dispatch("getAllDepos");
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
.pointer {
  cursor: pointer;
}
</style>
