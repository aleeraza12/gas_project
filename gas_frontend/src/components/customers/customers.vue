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
            <b> Customers</b>
          </div>
        </div>
        <div class="d-flex mt-5 pa-5" style="background-color:#EBEBEA;border-radius:5px;">
       
                  <div>
                    <div class="d-flex align-start justify-start">
                      <b>Total Customers</b>
                    </div>
                    <div class="d-flex align-start justify-start">
                      {{ getCustomers.length }}
                    </div>
                  </div>
                  <v-spacer></v-spacer>
                  <div class="d-flex align-end justify-end">
                    <v-btn small dense outlined @click="addNewCustomer()"
                      >Add New
                      <v-icon small dense class="ml-2">mdi-plus</v-icon></v-btn
                    >
                  </div>
           
        </div>
        <div class="d-flex mt-3">
          <div><b>Transactions</b></div>
          <v-spacer></v-spacer>
          <div class="mr-3" style="border-bottom: 1px solid grey">
            Export Csv
          </div>
          <div class="mr-3"><b>Date Picker</b></div>
        </div>
        <div class="mt-3">
          <v-data-table
            :loading="loading"
            loading-text="Loading... Please wait"
            :headers="headers"
            :items="getCustomers"
            :items-per-page="5"
            class="elevation-1"
            hide-default-footer
            hide-default-header
             height="400px"
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
                mdi-eye
              </v-icon>
            </template>
            <template v-slot:item.actions2="{ item }">
              <v-icon small class="mr-2" @click="setModal(item)">
                mdi-eye
              </v-icon>
            </template>
          </v-data-table>
        </div>
      </v-card-text>
    </v-card>

    <v-dialog v-model="dialog" persistent max-width="390">
      <v-card>
        <v-card-title class="text-h7">
          Are you sure to delete this customer?
        </v-card-title>
        <v-card-text>By deleting, All of its sales will be lost.</v-card-text>
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
export default {
  data: () => ({
    loading: true,
    deleteable: "",
    dialog: false,
    snacbarMessage: "",
    snackbar: false,
    snackbarColor: "",
    headers: [
      {
        text: "Customer Name",
        align: "start",
        sortable: false,
        value: "name",
      },
      { text: "Phone Number", value: "phone_number" },
      { text: "Email Address", value: "email" },
      { text: "Location", value: "address" },
      { text: "Customer Type", value: "customer_type" },
      { text: "Total Sales", value: "total_sale" },
      { text: "Edit", value: "actions1", sortable: false },
      { text: "Delete", value: "actions2", sortable: false },
    ],
  }),
  components: {},
  created() {
    eventBus.$on("responseArrived", () => {
      console.log("emt ar");
      this.loading = false;
    });
  },
  watch: {
    getCustomers() {
      console.log("response", this.getCustomers);
    },
  },
  computed: {
    ...mapGetters(["getCustomers"]),
    getIcon() {
      return this.snackbarColor == "success"
        ? "mdi-checkbox-marked-circle"
        : "mdi-close-circle";
    },
  },
  mounted() {
    this.$store.dispatch("getCustomersListing");
  },
  methods: {
    addNewCustomer() {
      this.$router.push("/new-customer");
    },
    editItem(item) {
      console.log(item);
      this.$router.push("/new-customer");
      setTimeout(() => {
        eventBus.$emit("updateCustomer", item);
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
        customer_id: this.deleteable.id,
      };
      RequestService.post("customer/delete", requestBody).then((response) => {
        if (response.data.status == 200) {
          console.log("customer deleted");
          this.loading = true;
          this.snackbar = true;
          this.snackbarColor = "success";
          this.snacbarMessage = "Your customer(s) deleted successfully";
          this.$store.dispatch("getCustomersListing");
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
