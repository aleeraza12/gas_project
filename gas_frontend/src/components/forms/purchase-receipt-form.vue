<template>
  <div class="main-container">
    <div class="d-flex">
      <div>
           <div class="d-flex align-start justify-start">
      <v-icon>mdi-chevron-left</v-icon> <span>Back</span>
    </div>
        <div class="mt-5 ml-3 d-flex align-start justify-start">
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
            <div>
              <v-text-field
                label="Receipt Number"
                outlined
                :rules="nameRules"
                dense
                placeholder="Enter Receipt Number"
                hide-details
                class="username-feild mt-3"
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
                class="username-feild mt-3"
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
                class="username-feild mt-3"
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
                class="username-feild mt-3"
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
                  class="city-feild mt-3 mr-3"
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
                  class="city-feild mt-3"
                  v-model="amount"
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
                class="username-feild mt-3"
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
                class="username-feild mt-3"
                v-model="recepient_name"
                :rules="nameRules"
              ></v-text-field>
            </div>
            <div class="">
              <v-btn
                class="elevation-0 mt-3 btn-create"
                @click="savePurchase()"
                :loading="loading"
                dense
              >
                Submit
              </v-btn>
            </div>
          </v-form>
        </div>
      </div>
      <div>
        <div
          style="height: 300px; width: 300px; margin-top: 10rem;cursor: pointer;"
          class="pa-10 ml-16"
      
        >
          <div v-if="decodedBase64 != ''">
            <img :src="decodedBase64" height="70" width="80" />
            <v-icon @click="decodedBase64 = ''" class="ml-3" size="30">mdi-delete-sweep</v-icon>
          </div>
          <label for="file-input" v-else>
            <v-icon size="80"  class="pointer">mdi-image</v-icon
            ><v-icon>mdi-plus</v-icon>
            <input
              id="file-input"
              type="file"
              class="d-none"
              @change="onFileChange"
            />
          </label>
          <div style="text-decoration:underline"><b>Add Image</b></div>
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
import RequestService from "../../RequestService";
export default {
  data: () => ({
    valid: false,
    show: false,
    datepicker: false,
    show1: false,
    gas_quantity: "",
    company_name: "",
    recepient_name: "",
    company_phone_number: "",
    amount: "",
    unit_price: "",
    receipt_number: "",
    driver_name: "",
    nameRules: [(v) => !!v || "This field is required"],
    decodedBase64: "",
    array_to_push: [],
    validFileSize: false,
    snacbarMessage: "",
    snackbar: false,
    snackbarColor: "",
    files: "",
    loading: false,
    date: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
      .toISOString()
      .substr(0, 10),
    menu: false,
    modal: false,
    menu2: false,
  }),
  components: {},
  computed: {
    getIcon() {
      return this.snackbarColor == "primary"
        ? "mdi-checkbox-marked-circle"
        : "mdi-close-circle";
    },
    //...mapGetters(["getAdminInfo"]),
  },
  created() {},
  watch: {},
  methods: {
    onFileChange() {
      console.log("nsde f");
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
            if (fileType == "jpg") {
              fileType = "jpeg";
            }
            that.decodedBase64 = fileBase64.replace(
              "data:image/" + fileType + ";base64,",
              ""
            );
            console.log("requsetbody", that.decodedBase64);
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
      let requestBody = {
        date: this.date,
        receipt_number: this.receipt_number,
        company_name: this.company_name,
        company_phone_number: this.company_phone_number,
        driver_name: this.driver_name,
        gas_quantity: this.gas_quantity,
        amount: this.amount,
        unit_price: this.unit_price,
        recepient_name: this.recepient_name,
        attachment: this.decodedBase64,
      };
      console.log("requsetbody", requestBody, this.decodedBase64);
      RequestService.post("purchase/create", requestBody)
        .then((res) => {
          console.log("status in purchase", res.data.status);
          if (res.data.status == 201) {
            console.log("this is inside");
            this.snackbar = true;
            this.snackbarColor = "success";
            this.snacbarMessage = "Your purchase(s) uploaded successfully";
            this.loading = false;
          }
        })
        .catch(() => {
          //if (err.response) {
          this.snackbar = true;
          this.snackbarColor = "red";
          this.snacbarMessage = " Something went wrong";
          //}
        });
    },
  },
};
</script>
<style scoped>
.btn-create {
  background-color: #464646 !important;
  color: #fff;
  min-width: 230px !important;
  border-radius: 8px !important;
  cursor: pointer;
}
</style>
