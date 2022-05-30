<template>
  <div class="main-container">
    <div class="d-flex">
      <div>
        <div class="mt-4 ml-3 d-flex align-start justify-start">
          <v-btn small dense outlined> back</v-btn>
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
                class="username-feild"
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
                class="username-feild"
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
                class="username-feild mt-2"
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
                class="username-feild mt-2"
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
                  class="city-feild mt-2 mr-3"
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
                  class="city-feild mt-2"
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
                class="username-feild mt-2"
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
                class="username-feild mt-2"
                v-model="recepient_name"
                :rules="nameRules"
              ></v-text-field>
            </div>
            <div class="">
              <v-btn
                class="elevation-0 mt-2 btn-create"
                @click="savePurchase()"
                :disabled="!valid"
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
          style="height: 300px; width: 300px; margin-top: 10rem"
          class="pa-10 ml-16"
        >
          <v-file-input
            v-model="files"
            label="File input"
            filled
            hide-input
            prepend-icon="mdi-image"
          ></v-file-input>

          <!--<v-icon size="80">mdi-image</v-icon><v-icon>mdi-plus</v-icon>-->
        </div>
      </div>
    </div>
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
    show1: false,
    gas_quantity: "",
    company_name: "",
    recepient_name: "",
    company_phone_number: "",
    amount: "",
    unit_price: "",
    receipt_number: "",
    date: "",
    driver_name: "",
    nameRules: [(v) => !!v || "This field is required"],
    decodedBase64: "",
    array_to_push: [],
    validFileSize: false,
    snacbarMessage: "",
    snackbar: false,
    snackbarColor: "",
    files: [],
    loading: false,
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
  methods: {
    savePurchase() {
      this.loading = true;
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
            console.log("base64", that.decodedBase64);
            //that.array_to_push.push({
            //  base64: that.decodedBase64,
            //  extension: fileType,
            //});
            event.target.value = null;
            //let user_id = JSON.parse(localStorage.getItem("user"));
            let requestBody = {
              date: that.date,
              receipt_number: that.receipt_number,
              company_name: that.company_name,
              company_phone_number: that.company_phone_number,
              driver_name: that.driver_name,
              gas_quantity: that.gas_quantity,
              amount: that.amount,
              unit_price: that.unit_price,
              status: that.status,
              recepient_name: that.recepient_name,
              //payment_status_id: this.payment_status_id,
              attachment: that.decodedBase64,
            };
            console.log("requsetbody", requestBody, that.decodedBase64);
            RequestService.post("purchase/create", requestBody)
              .then((res) => {
                console.log("status in purchase", res.data.status);
                if (res.data.status == 200) {
                  console.log("this is inside");
                  that.snackbar = true;
                  that.snackbarColor = "success";
                  that.snacbarMessage = "Images uploaded successfully";
                  that.loading = false;
                }
              })
              .catch(() => {
                //if (err.response) {
                that.snackbar = true;
                that.snackbarColor = "red";
                that.snacbarMessage = " Something went wrong";
                //}
              });
          },
          false
        );
        if (file) {
          reader.readAsDataURL(file);
        }
      }
    },
  },
};
</script>
<style scoped>
.btn-create {
  background-color: black !important;
  color: #fff;
  min-width: 230px !important;
  border-radius: 8px !important;
  cursor: pointer;
}
</style>
