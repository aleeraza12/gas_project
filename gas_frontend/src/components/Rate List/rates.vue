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
            <b> Rates</b>
          </div>
        </div>
        <div
          class="d-flex mt-5 pa-5"
          style="background-color: #eff0fa; border-radius: 5px"
        >
          <div>
            <div class="d-flex align-start justify-start">
              <b>Total</b>
            </div>
            <div class="d-flex align-start justify-start">
              {{ getRates.length }}
            </div>
          </div>
          <v-spacer></v-spacer>
          <div
            class="d-flex align-end justify-end"
            v-if="loggedinUser.company_email == 'superadmin@gmail.com'"
          >
            <v-btn small dense outlined color="#2b3896" @click="addRateModal()"
              >Add New Rate
              <v-icon small dense class="ml-2">mdi-plus</v-icon></v-btn
            >
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
          <div class="mr-3"><date-picker /></div>
        </div>
        <div class="mt-3">
          <v-data-table
            :loading="loading"
            loading-text="Loading... Please wait"
            :headers="Depoheaders"
            :items="getRates"
            :items-per-page="5"
            class="elevation-1"
            hide-default-header
            height="calc(100vh - 400px)"
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
            <template v-slot:item.actions1="{ item }">
              <v-icon small class="mr-2" @click="editItem(item)">
                mdi-pencil
              </v-icon>
            </template>
            <template v-slot:item.actions2="{ item }">
              <v-icon
                small
                class="mr-2"
                @click="deleteItemModal(item)"
                color="red"
              >
                mdi-delete-empty
              </v-icon>
            </template>
          </v-data-table>
        </div>
      </v-card-text>
    </v-card>
    <v-dialog v-model="dialog" persistent max-width="390">
      <v-card>
        <v-card-title class="text-h7">
          Are you sure to delete this rate?
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
    <download-csv :json-data="getRates">
      <v-btn style="display: none" id="myBtn">
        <b>My custom button</b>
      </v-btn>
    </download-csv>
    <v-dialog v-model="isModal" persistent max-width="390">
      <v-card>
        <v-card-title class="text-h5 text-center align-center display-center">
          Enter Rate
        </v-card-title>
        <v-form v-model="valid">
          <v-card-text>
            <v-text-field
              v-model="depo_name"
              solo
              label="Enter Depo Name"
              hide-details="auto"
              class="ma-3"
              :rules="nameRules"
            ></v-text-field>
            <v-text-field
              hide-details="auto"
              v-model="location"
              solo
              label="Enter Depo Location"
              :rules="nameRules"
              class="ma-3"
            ></v-text-field>
            <v-text-field
              class="ma-3"
              hide-details="auto"
              v-model="price"
              :rules="nameRules"
              solo
              label="Enter price"
              clearable
            ></v-text-field
          ></v-card-text>
        </v-form>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="black" small text @click="isModal = false">
            Cancel
          </v-btn>
          <v-btn
            small
            color="green darken-1"
            text
            @click="AddRate()"
            :disabled="!valid"
            :loading="loading"
          >
            Add
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
import datePicker from "../../views/Pages/datePicker.vue";
import RequestService from "../../RequestService";
import VueJsonToCsv from "vue-json-to-csv";
import Vue from "vue";
Vue.component("downloadCsv", VueJsonToCsv);
export default {
  data: () => ({
    price: "",
    depo_id: null,
    location: "",
    nameRules: [(v) => !!v || "This field is required"],
    loggedinUser: JSON.parse(localStorage.getItem("user")),
    depo_name: "",
    loading: true,
    snacbarMessage: "",
    snackbar: false,
    dialog: false,
    snackbarColor: "",
    isModal: false,
    updateAble: "",
    valid: false,
    isDepo: false,
    deleteRate: "",
    search: "",
    total_sales: null,
    start_date: "2022-01-01",
    end_date: new Date().toISOString().substr(0, 10),
    Depoheaders: [
      { text: "Depot Name", value: "depo_name" },
      { text: "Location", value: "location" },
      { text: "Price(per 20MT)", value: "price_per_twenty_million_ton" },
      { text: "Update At", value: "updated_at" },
    ],
  }),
  components: {
    datePicker,
  },
  computed: {
    ...mapGetters(["getRates"]),

    getIcon() {
      return this.snackbarColor == "success"
        ? "mdi-checkbox-marked-circle"
        : "mdi-close-circle";
    },
  },
  created() {
    if (this.loggedinUser.company_email == "superadmin@gmail.com") {
      let editable = { text: "Edit", value: "actions1", sortable: false };
      let deleteAble = { text: "Delete", value: "actions2", sortable: false };

      this.Depoheaders.push(editable);
      this.Depoheaders.push(deleteAble);
    }
    eventBus.$on("responseArrived", () => {
      this.loading = false;
    });
    eventBus.$on("selectedRateListDateFilter", (value) => {
      this.loading = true;
      this.getRateListing(value);
    });
  },
  methods: {
    addRateModal() {
      this.depo_name = "";
      this.location = "";
      this.price = "";
      this.depo_id = null;
      this.updateAble = false;
      this.isModal = true;
    },
    deleteItemModal(item) {
      this.deleteRate = item;
      this.dialog = true;
    },
    editItem(item) {
      this.depo_name = item.depo_name;
      this.location = item.location;
      this.price = item.price_per_twenty_million_ton;
      this.added_by_admin = true;
      this.depo_id = item.id;
      this.isModal = true;
      this.updateAble = true;
    },
    deleteItem() {
      this.dialog = false;
      let requestBody = {
        depo_id: this.deleteRate.id,
        added_by_admin: true,
      };
      RequestService.post("depo/delete", requestBody).then((response) => {
        if (response.data.status == 200) {
          this.loading = true;
          this.snackbar = true;
          this.snackbarColor = "success";
          this.snacbarMessage = "Your data deleted successfully";
          let requestBody = {
            start_date: this.start_date,
            end_date: this.end_date.concat(" 23:59:00"),
          };
          this.$store.dispatch("getRateListing", requestBody);
        }
      });
    },
    AddRate() {
      this.isModal = false;
      this.loading = false;
      let requestBody = {
        depo_name: this.depo_name,
        location: this.location,
        price_per_twenty_million_ton: this.price,
        added_by_admin: true,
        depo_id: this.depo_id,
      };
      let apiName = "";
      if (this.updateAble && this.depo_id) apiName = "depo/update";
      else apiName = "depo/create";
      RequestService.post(apiName, requestBody)
        .then((res) => {
          if (res.data.status == 201 && !this.depo_id)
            this.snacbarMessage = "Depo rate(s) added successfully";
          else if (this.depo_id)
            this.snacbarMessage = "Depo rate(s) updated successfully";

          this.snackbar = true;
          this.snackbarColor = "success";
          this.loading = false;
          this.depo_name = "";
          this.location = "";
          this.price = "";
          this.depo_id = null;
          this.updateAble = false;
          let requestBody = {
            start_date: this.start_date,
            end_date: this.end_date.concat(" 23:59:00"),
          };
          this.$store.dispatch("getRateListing", requestBody);
        })
        .catch((err) => {
          if (err.response) {
            this.loading = false;
            this.isModal = false;
            this.snackbar = true;
            this.snackbarColor = "red";
            this.snacbarMessage = " Something went wrong";
          }
        });
    },
    getRateListing(date) {
      let requestBody = {
        start_date: date[0],
        end_date: date[1].concat(" 23:59:00"),
      };
      this.$store.dispatch("getRateListing", requestBody);
    },
    btnClick() {
      document.getElementById("myBtn").click();
    },
  },
  watch: {},
  mounted() {
    this.getRateListing([this.start_date, this.end_date]);
    this.$store.commit("setSelectedDateRange", "All");
  },
};
</script>
<style scoped>
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
  width: 500px;
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
