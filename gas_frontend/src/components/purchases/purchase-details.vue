<template>
  <div class="main-container">
    <div class="sales-details-page">
      <div class="d-flex">
        <div @click="goToPurchases()">
          <v-icon class="ml-3 mt-3"> mdi-close</v-icon>
        </div>
      </div>
      <div class="mt-6"><b>Purchase Details</b></div>
      <v-divider></v-divider>
      <div class="d-flex align-center justify-center mt-3">
        <div
          v-if="
            (getSinglePurchase.base64 == '' && decodedBase64 == '') ||
            (getSinglePurchase.receipt_attachment_path == null &&
              decodedBase64 == '')
          "
          style="height: 150px; width: 150px; background-color: #c4c4c4"
        ></div>
        <img
          v-else
          style="border: 1px solid grey; border-radius: 5px"
          max-width="70"
          v-bind:src="
            'data:image/jpeg;base64,' + decodedBase64 != ''
              ? decodedBase64
              : getSinglePurchase.base64
          "
          height="120"
        />
      </div>
      <div class="d-flex align-center justify-center mt-1">
        <label for="file-input">
          <div
            style="text-decoration: underline; cursor: pointer"
            class="fonts"
          >
            Change Image
          </div>
          <input
            id="file-input"
            type="file"
            class="d-none"
            @change="onFileChange"
          />
        </label>
      </div>

      <div class="d-flex mt-5">
        <div class="ml-10">
          <v-chip small dense color="success" label class="pa-3">
            {{ getSinglePurchase.payment_status }}
          </v-chip>
        </div>
        <v-spacer></v-spacer>
        <div class="mr-10 fonts">
          <div>
            <b>{{ getSinglePurchase.date }}</b>
          </div>
          <div>02:33 pm</div>
        </div>
      </div>
      <div
        class="d-flex align-start justify-start ml-5"
        style="font-size: 16px; font-weight: 600"
      >
        Company Info
      </div>
      <div class="d-flex">
        <div class="ml-5 mt-3">
          <div class="d-flex align-start justify-start">
            <b>{{ getSinglePurchase.company_name }}</b>
          </div>
          <div class="d-flex align-start justify-start fonst">
            {{ getSinglePurchase.company_phone_number }}
          </div>
          <div class="d-flex align-start justify-start fonts">
            office no abc , nowrelad activty sometec howdy
          </div>
        </div>
        <v-spacer></v-spacer>
        <div class="mr-8 mt-3">
          <div class="fonts">Transaction Id</div>
          <div class="fonts">{{ getSinglePurchase.transaction_id }}</div>
        </div>
      </div>
      <div class="mt-3" style="text-decoration: underline">
        <b>Purchase Info</b>
      </div>
      <div class="d-flex">
        <div class="ml-5 mt-3">
          <div class="d-flex">
            <div class="fonts"><b>Unit Gas Price:</b></div>
            <div class="fonts">N {{ getSinglePurchase.unit_price }}</div>
          </div>
          <div class="d-flex">
            <div class="fonts"><b>Total Amount:</b></div>
            <div class="fonts">N {{ getSinglePurchase.amount }}</div>
          </div>
          <div class="d-flex">
            <div class="fonts"><b>Payment Mode:</b></div>
            <div class="fonts">Prepaid</div>
          </div>
        </div>
        <v-spacer></v-spacer>
        <div class="mr-8 mt-3">
          <div class="fonts">Gas Quantity</div>
          <div class="fonts">{{ getSinglePurchase.gas_quantity }}</div>
        </div>
      </div>
      <div class="mt-3" style="text-decoration: underline">
        <b>Status History</b>
      </div>
      <div class="fonts mt-3">
        <div class="d-flex align-start justify-start ml-3">
          <v-radio
            label="Deleivered"
            color="primary"
            value="Deleivered"
          ></v-radio>
        </div>
        <div class="d-flex align-start justify-start ml-8">
          23rd ,april 20222
        </div>
      </div>
      <div class="fonts">
        <div class="d-flex align-start justify-start ml-3">
          <v-radio label="paid" color="primary" value="paid"></v-radio>
        </div>
        <div class="d-flex align-start justify-start ml-8">
          23rd ,april 20222
        </div>
      </div>
      <div>
        <v-btn dense outlined small style="width: 230px" class="mt-3">
          save
        </v-btn>
      </div>
      <div class="d-flex align-center justify-center">
        <div>
          <v-btn
            dense
            outlined
            small
            style="width: 100px"
            class="mt-3 mr-3"
            color="primary"
          >
            Edit
          </v-btn>
        </div>
        <div>
          <v-btn
            dense
            outlined
            small
            style="width: 100px"
            class="mt-3"
            color="red"
          >
            Delete
          </v-btn>
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
import { mapGetters } from "vuex";
export default {
  data: () => ({
    loading: false,
    decodedBase64: "",
    validFileSize: false,
    snacbarMessage: "",
    snackbar: false,
    snackbarColor: "",
    files: "",
  }),
  watch: {
    getSinglePurchase() {
      console.log("data", this.getSingleReceipt);
    },
  },
  computed: {
    ...mapGetters(["getSinglePurchase"]),
    getIcon() {
      return this.snackbarColor == "primary"
        ? "mdi-checkbox-marked-circle"
        : "mdi-close-circle";
    },
  },
  mounted() {
    console.log("nsde mounted", this.getSinglePurchase);
  },
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
    goToPurchases() {
      this.$router.push("/purchases");
    },
  },
};
</script>
<style scoped>
.sales-details-page {
  height: 600px;
  width: 600px;
  background-color: #ebebea;
  margin-left: 12rem;
}
.fonts {
  font-size: 12px;
}
</style>
