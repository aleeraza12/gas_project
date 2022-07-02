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
            <b> Promos</b>
          </div>
        </div>
        <div
          class="d-flex mt-5 pa-5"
          style="background-color: #eff0fa; border-radius: 5px"
        >
          <div>
            <div class="d-flex align-start justify-start">
              <b>Total Promos</b>
            </div>
            <div class="d-flex align-start justify-start">
              {{ getPromos.length }}
            </div>
          </div>
          <v-spacer></v-spacer>
          <div class="d-flex align-end justify-end">
            <v-btn small dense outlined color="#2b3896" @click="isModal = true"
              >Add New <v-icon small dense class="ml-2">mdi-plus</v-icon></v-btn
            >
          </div>
        </div>
        <div class="d-flex mt-3">
          <div class="mt-4"><b>Promo Codes</b></div>
          <v-spacer></v-spacer>
          <div class="mr-3"><date-picker /></div>
        </div>
        <div class="mt-3">
          <v-data-table
            :loading="loading"
            loading-text="Loading... Please wait"
            :headers="headers"
            :items="getPromos"
            :items-per-page="5"
            class="elevation-1"
            hide-default-header
            height="calc(100vh - 400px)"
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
      </v-card-text>
    </v-card>
    <v-dialog v-model="dialog" persistent max-width="390">
      <v-card>
        <v-card-title class="text-h7">
          Are you sure to delete this promo?
        </v-card-title>
        <!--<v-card-text>By deleting, All of its data will be lost.</v-card-text>-->
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

    <v-dialog v-model="isModal" persistent max-width="390">
      <v-card>
        <v-card-title class="text-h5 text-center align-center display-center">
          Enter New Promo
        </v-card-title>
        <v-form v-model="valid">
          <v-card-text>
            <v-text-field
              v-model="promo_name"
              solo
              label="Enter Promo Name"
              hide-details="auto"
              class="ma-3"
              :readonly="isReadOnly"
              :rules="nameRules"
            ></v-text-field>
            <v-text-field
              hide-details="auto"
              v-model="promo_percentage"
              solo
              label="Enter Promo Discount Percentage"
              clearable
              :rules="nameRules"
              class="ma-3"
            ></v-text-field>
          </v-card-text>
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
            @click="addNewPromo()"
            :disabled="!valid"
            :loading="loading"
          >
            Add
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
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
    nameRules: [(v) => !!v || "This field is required"],
    isReadOnly: false,
    isModal: false,
    valid: false,
    search: "",
    promo_id: null,
    company_id: null,
    deleteable: "",
    promo_name: "",
    promo_percentage: "",
    dialog: false,
    snacbarMessage: "",
    snackbar: false,
    snackbarColor: "",
    start_date: "2022-01-01",
    end_date: new Date().toISOString().substr(0, 10),
    loggedinUser: JSON.parse(localStorage.getItem("user")),
    headers: [
      {
        text: "Promo Name",
        align: "start",
        sortable: false,

        value: "promo_name",
      },
      { text: "Promo Percentage", value: "promo_percentage" },
      { text: "Created At", value: "created_at" },
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
    ...mapGetters(["getPromos"]),
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
    eventBus.$on("selectedPromoDateFilter", (value) => {
      this.getPromosListing(value);
    });
  },
  mounted() {
    this.getPromosListing([this.start_date, this.end_date]);
    this.$store.commit("setSelectedDateRange", "All");
  },
  methods: {
    getPromosListing(date) {
      this.loading = true;
      let requestBody = {
        start_date: date[0],
        end_date: date[1].concat(" 23:59:00"),
      };
      this.$store.dispatch("getPromosListing", requestBody);
    },
    addNewPromo() {
      this.isModal = false;
      let requestBody = {
        promo_id: this.promo_id,
        promo_name: this.promo_name,
        promo_percentage: this.promo_percentage,
      };
      if (this.company_id != null) requestBody.company_id = this.company_id;
      RequestService.post("promo/create", requestBody)
        .then((response) => {
          if (response.data.status == 201 || response.data.status == 200) {
            this.loading = true;
            this.snackbar = true;
            this.snackbarColor = "success";
            this.snacbarMessage = "Your promo(s) added successfully";
            let requestBody = {
              start_date: this.start_date,
              end_date: this.end_date.concat(" 23:59:00"),
            };
            this.$store.dispatch("getPromosListing", requestBody);
          }
        })
        .catch((err) => {
          if (err.response.status == 422) {
            this.snackbar = true;
            this.snackbarColor = "red";
            let errorArray = [];
            for (let item in err.response.data.errors) {
              errorArray.push(item);
            }
            let error = err.response.data.errors[errorArray[0]];
            console.log(error);
            this.snacbarMessage = error[0];
          } else {
            this.snackbar = true;
            this.snackbarColor = "red";
            this.snacbarMessage = "Something went wrong";
            this.loading = false;
          }
        });
    },
    editItem(item) {
      this.isReadOnly = true;
      this.promo_id = item.id;
      this.promo_name = item.promo_name;
      this.promo_percentage = item.promo_percentage;
      this.company_id = item.company_id;
      this.isModal = true;
    },
    setModal(item) {
      this.dialog = true;
      this.deleteable = item;
    },
    deleteItem() {
      this.dialog = false;
      let requestBody = {
        promo_id: this.deleteable.id,
      };
      RequestService.post("promo/delete", requestBody).then((response) => {
        if (response.data.status == 200) {
          this.loading = true;
          this.snackbar = true;
          this.snackbarColor = "success";
          this.snacbarMessage = "Your promo(s) deleted successfully";
          let requestBody = {
            start_date: this.start_date,
            end_date: this.end_date.concat(" 23:59:00"),
          };
          this.$store.dispatch("getPromosListing", requestBody);
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
