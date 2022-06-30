<template>
  <div class="main-container">
    <div class="d-flex">
      <div>
        <div class="d-flex align-start justify-start" @click="goToPurchase()">
          <v-icon color="#2e3995">mdi-chevron-left</v-icon>
          <span style="color: #2e3995">Back</span>
        </div>
        <div class="mt-4 ml-3 d-flex align-start justify-start">
          <b>Purchase Recepit Form</b>
        </div>
        <div class="mt-2 ml-3 d-flex align-start justify-start">
          Enter the following details to Purchase Recepit
        </div>
        <div style="width: 400px" class="pa-8">
          <v-form v-model="valid">
            <div>
              <v-text-field
                label="Date"
                outlined
                dense
                @click="modal = true"
                placeholder="Enter Date"
                hide-details
                class="username-feild"
                v-model="date"
                :rules="nameRules"
              ></v-text-field>
            </div>
            <div v-if="loggedinUser.is_super_admin">
              <v-select
                :items="
                  Object.keys(purchased_company_names).map((key) => ({
                    text: purchased_company_names[key].name,
                    value: purchased_company_names[key],
                  }))
                "
                label="Select one company for purchase"
                v-model="purchased_company_name"
                :rules="nameRules"
                outlined
                class="username-feild mt-3"
                dense
                small
                hide-details
              ></v-select>
            </div>
            <div>
              <v-text-field
                label="Receipt Number"
                outlined
                :rules="nameRules"
                dense
                placeholder="Enter Receipt Number"
                hide-details
                class="username-feild mt-4"
                v-model="receipt_number"
              ></v-text-field>
            </div>
            <div>
              <v-text-field
                label="Company Name"
                outlined
                dense
                placeholder="Enter Company Name"
                hide-details
                class="username-feild mt-4"
                v-model="company_name"
                :rules="nameRules"
              ></v-text-field>
            </div>
            <div>
              <v-text-field
                label="Phone Number"
                outlined
                dense
                placeholder="Enter Company Phone Number"
                hide-details
                class="username-feild mt-4"
                v-model="company_phone_number"
                :rules="nameRules"
              ></v-text-field>
            </div>
            <div>
              <v-text-field
                label="Price"
                outlined
                dense
                placeholder="Enter Price"
                hide-details
                class="username-feild mt-4"
                v-model="unit_price"
                :rules="nameRules"
              ></v-text-field>
            </div>
            <div class="d-flex">
              <div>
                <v-text-field
                  label="Quantity"
                  outlined
                  dense
                  placeholder="Enter Gas Quantity"
                  hide-details
                  class="city-feild mt-4 mr-3"
                  v-model="gas_quantity"
                  :rules="nameRules"
                ></v-text-field>
              </div>
              <div>
                <v-text-field
                  label="Amount"
                  outlined
                  dense
                  placeholder="Enter Amount"
                  hide-details
                  class="city-feild mt-4"
                  v-model="amount"
                  :rules="nameRules"
                ></v-text-field>
              </div>
            </div>
            <div class="d-flex">
              <div>
                <v-text-field
                  label="Logistics Cost"
                  outlined
                  dense
                  placeholder="Enter Logistics Cost"
                  hide-details
                  class="city-feild mt-4 mr-3"
                  v-model="logistics_cost"
                  :rules="nameRules"
                ></v-text-field>
              </div>
              <div>
                <v-text-field
                  label="Admin Cost"
                  outlined
                  dense
                  placeholder="Enter Admin Cost"
                  hide-details
                  class="city-feild mt-4"
                  v-model="admin_cost"
                  :rules="nameRules"
                ></v-text-field>
              </div>
            </div>
            <div>
              <v-text-field
                label="Driver Name"
                outlined
                dense
                placeholder="Enter Driver Name"
                hide-details
                class="username-feild mt-4"
                v-model="driver_name"
                :rules="nameRules"
              ></v-text-field>
            </div>
            <div>
              <v-text-field
                label="Recepient Name"
                outlined
                dense
                placeholder="Enter Recepient Name"
                hide-details
                class="username-feild mt-4"
                v-model="recepient_name"
                :rules="nameRules"
              ></v-text-field>
            </div>
            <div class="">
              <v-btn
                class="elevation-0 mt-4 btn-create text-capitalize"
                @click="savePurchase()"
                :disabled="!valid"
                :loading="loading"
                dense
              >
                Save
              </v-btn>
            </div>
          </v-form>
        </div>
      </div>
      <div class="myDiv">
        <div
          style="height: 300px; width: 300px; margin-top: 7rem; cursor: pointer"
          class="pa-10 ml-10"
        >
          <div v-if="decodedBase64 != ''">
            <img :src="decodedBase64" height="70" width="80" />
            <v-icon @click="decodedBase64 = ''" class="ml-3" size="30"
              >mdi-delete-sweep</v-icon
            >
          </div>
          <label for="file-input" v-else>
            <img height="100" src="../../assets/images/imageicon.png" />
            <input
              id="file-input"
              type="file"
              class="d-none"
              @change="onFileChange"
            />
            <div
              style="
                text-decoration: underline;
                color: #2e3995;
                cursor: pointer;
              "
            >
              <b>Add Image</b>
            </div>
          </label>
        </div>
      </div>
    </div>
    <v-dialog
      ref="dialog"
      v-model="modal"
      :return-value.sync="date"
      persistent
      width="290px"
    >
      <v-date-picker v-model="date" scrollable>
        <v-spacer></v-spacer>
        <v-btn text color="primary" @click="modal = false"> Cancel </v-btn>
        <v-btn text color="primary" @click="$refs.dialog.save(date)">
          OK
        </v-btn>
      </v-date-picker>
    </v-dialog>

    <v-snackbar
      v-model="snackbar"
      :timeout="2000"
      :value="true"
      absolute
      class="mt-4"
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
import RequestService from "../../RequestService";
import { mapGetters } from "vuex";
import { eventBus } from "@/main";
export default {
  data: () => ({
    valid: false,
    show: false,
    purchase_id: null,
    datepicker: false,
    show1: false,
    gas_quantity: "",
    company_name: "",
    recepient_name: "",
    company_phone_number: "",
    amount: "",
    logistics_cost: "",
    admin_cost: "",
    unit_price: "",
    receipt_number: "",
    purchased_company_names: [],
    purchased_company_name: "",
    driver_name: "",
    nameRules: [(v) => !!v || "This field is required"],
    decodedBase64: "",
    array_to_push: [],
    validFileSize: false,
    snacbarMessage: "",
    snackbar: false,
    snackbarColor: "",
    emitData: "",
    files: "",
    loading: false,
    start_date: "2022-01-01",
    end_date: new Date().toISOString().substr(0, 10),
    updateable: false,
    loggedinUser: JSON.parse(localStorage.getItem("user")),
    date: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
      .toISOString()
      .substr(0, 10),
    menu: false,
    modal: false,
    menu2: false,
    company_id: null,
  }),
  components: {},
  computed: {
    getIcon() {
      return this.snackbarColor == "primary"
        ? "mdi-checkbox-marked-circle"
        : "mdi-close-circle";
    },
    ...mapGetters(["getPrice", "getCompanies"]),
  },
  created() {
    eventBus.$on("updatePurchase", (data) => {
      this.assembleData(data);
      this.updateable = true;
    });
    eventBus.$on("validationFailed", (err) => {
      this.snackbar = true;
      this.snackbarColor = "red";
      let errorArray = [];
      for (let item in err.response.data.errors) {
        errorArray.push(item);
      }
      let error = err.response.data.errors[errorArray[0]];
      this.snacbarMessage = error[0];
    });
  },
  watch: {
    gas_quantity() {
      this.amount = this.gas_quantity * this.unit_price;
    },
    unit_price() {
      this.amount = this.gas_quantity * this.unit_price;
    },
    // getPrice() {
    //   this.unit_price = this.getPrice
    //     ? this.getPrice.price_per_twenty_million_ton
    //     : this.unit_price;
    // },
    getCompanies() {
      this.customer_names = [];
      for (let j = 0; j < this.getCompanies.length; j++) {
        let company = {
          name: this.getCompanies[j].company_name,
          id: this.getCompanies[j].id,
        };
        this.purchased_company_names.push(company);
      }
      let updateAblecompany = {
        name: this.emitData.created_company_name,
        id: this.emitData.company_id,
      };
      this.purchased_company_name = updateAblecompany;
    },
  },

  mounted() {
    if (this.loggedinUser.is_super_admin) {
      let requestBody = {
        start_date: this.start_date,
        end_date: this.end_date.concat(" 23:59:00"),
      };
      this.$store.dispatch("getCompaniesListing", requestBody);
    }
    setTimeout(() => {
      if (!this.updateable) this.$store.dispatch("getCurrentPrice");
    }, 1000);
  },
  methods: {
    assembleData(data) {
      this.emitData = data;
      this.receipt_number = data.receipt_number;
      this.company_name = data.company_name;
      this.company_phone_number = data.company_phone_number;
      this.driver_name = data.driver_name;
      this.gas_quantity = data.gas_quantity;
      this.amount = data.amount;
      this.logistics_cost = data.logistics_cost;
      this.admin_cost = data.admin_cost;
      this.unit_price = data.unit_price;
      this.recepient_name = data.recepient_name;
      this.company_id = data.company_id;
      if (data.base64 && data.base64 != "")
        this.decodedBase64 = "data:image/jpeg;base64," + data.base64;
      else this.decodedBase64 = "";
      this.purchase_id = data.id;
      this.date = this.formatDate(data.date);
    },
    formatDate(item) {
      let date = item.split(" ");
      return date[0];
    },
    goToPurchase() {
      this.$router.go(-1);
    },
    //onInputClick(event) {
    //  event.target.value = "";
    //},
    onFileChange() {
      let file_size = document.querySelector("input[type=file]").files[0].size;
      this.validFileSize = true;
      let fileBase64;
      if (file_size > 2097152) {
        this.validFileSize = false;
      }
      if (!this.validFileSize) {
        this.snackbar = true;
        this.snackbarColor = "red";
        this.snacbarMessage = " File size should not be greater then 2 MB";
        this.loading = false;
        this.files = [];
      } else {
        let that = this;
        const file = document.querySelector("input[type=file]").files[0];
        const reader = new FileReader();
        reader.addEventListener(
          "load",
          function () {
            fileBase64 = reader.result; //extract file type
            let i = file.name.lastIndexOf(".");
            let fileType;
            if (i > 0) {
              fileType = file.name.substring(i + 1);
            }
            if (fileType == "jpg" || fileType == "png") {
              fileType = "jpeg";
            }
            that.decodedBase64 = fileBase64;
            event.target.value = null;
          },
          false
        );
        if (file) {
          reader.readAsDataURL(file);
        }
      }
    },
    savePurchase() {
      this.loading = true;
      var d = new Date();
      let requestBody = {
        date:
          this.date +
          " " +
          d.getHours() +
          ":" +
          d.getMinutes() +
          ":" +
          d.getSeconds(),
        receipt_number: this.receipt_number,
        company_name: this.company_name,
        company_phone_number: this.company_phone_number,
        driver_name: this.driver_name,
        gas_quantity: this.gas_quantity,
        amount: this.amount,
        logistics_cost: this.logistics_cost,
        admin_cost: this.admin_cost,
        unit_price: this.unit_price,
        recepient_name: this.recepient_name,
        attachment: this.decodedBase64.replace("data:image/jpeg;base64,", ""),
        purchase_id: this.purchase_id,
        users_id:
          "user_id" in this.loggedinUser
            ? this.loggedinUser.user_id
            : this.loggedinUser.id,
      };
      if (this.company_id != null && !this.loggedinUser.is_super_admin) {
        requestBody.company_id = this.company_id;
      }
      if (
        this.purchased_company_name !== "" &&
        this.loggedinUser.is_super_admin
      ) {
        requestBody.company_id = this.purchased_company_name.id;
      }
      let apiName = "";
      this.purchase_id == null
        ? (apiName = "purchase/create")
        : (apiName = "purchase/update");
      RequestService.post(apiName, requestBody)
        .then((res) => {
          if (res.data.status == 201) {
            this.snacbarMessage = "Your purchase(s) added successfully";
          } else if (res.data.status == 200) {
            this.snacbarMessage = "Your purchase(s) updated successfully";
          }
          this.snackbar = true;
          this.snackbarColor = "success";
          this.loading = false;
          setTimeout(() => {
            this.$router.push("/purchases");
          }, 1000);
        })
        .catch(() => {
          //if (err.response) {
          //this.snackbar = true;
          //this.snackbarColor = "red";
          //this.snacbarMessage = " Something went wrong";
          setTimeout(() => {
            this.$router.go(-1);
          }, 1000);
        });
    },
  },
};
</script>
<style scoped>
.btn-create {
  background-color: #2e3995 !important;
  color: #fff;
  min-height: 40px;
  min-width: 250px !important;
  border-radius: 20px !important;
  cursor: pointer;
}
.myDiv {
  position: absolute;
  width: 384px;
  height: 400px;
  left: 470px;
  top: 150px;

  background: #f7f7fe;
  border-radius: 12px;
}
</style>
