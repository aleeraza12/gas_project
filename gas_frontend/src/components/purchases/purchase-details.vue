<template>
  <div class="main-container">
    <div class="sales-details-page mb-5">
      <div class="d-flex">
        <div @click="goToPurchases()">
          <v-icon class="ml-3 mt-5"> mdi-close</v-icon>
        </div>
      </div>
      <div class="mt-6">
        <b>Purchase Details</b>
      </div>
      <v-divider></v-divider>
      <div class="d-flex align-center justify-center mt-5">
        <div
          v-if="
            (image === '' && decodedBase64 === '') ||
            (getSinglePurchase.receipt_attachment_path === null &&
              decodedBase64 === '')
          "
          style="height: 150px; width: 150px; background-color: #c4c4c4"
        ></div>
        <img
          v-else
          style="border: 1px solid grey; border-radius: 5px"
          max-width="70"
          v-bind:src="decodedBase64 != '' ? decodedBase64 : image"
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
          <v-chip  dense label class="pa-3" style="background-color:#EBFFEF;color:#5FBA7E">
           <v-icon size="10" color="#5FBA7E" class="mr-4">mdi-circle</v-icon> {{ getStatus(getSinglePurchase) }}
          </v-chip>
        </div>
        <v-spacer></v-spacer>
        <div class="mr-10 fonts">
          <div>
            <b>{{ getDate(getSinglePurchase.date) }}</b>
          </div>
          <div>{{ getTme(getSinglePurchase.date) }}</div>
        </div>
      </div>
      <div
        class="d-flex align-start justify-start ml-5"
        style="font-size: 16px; font-weight: 600"
      >
        Company Info
      </div>
      <div class="d-flex">
        <div class="ml-5 mt-5">
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
        <div class="mr-8 mt-5">
          <div class="fonts">Transcation Id</div>
          <div class="fonts">000000010000</div>
        </div>
      </div>
      <div class="mt-5" style="text-decoration: underline">
        <b>Purchase Info</b>
      </div>
      <div class="d-flex">
        <div class="ml-5 mt-5">
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
        <div class="mr-8 mt-5">
          <div class="fonts">Transcation Id</div>
          <div class="fonts">000000010000</div>
        </div>
      </div>
      <!--<div class="mt-5" style="text-decoration: underline">
        <b>Status History</b>
      </div>
      <div class="fonts mt-5">
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
      </div>-->
      <v-container fluid>
        <v-radio-group v-model="radios" dense>
          <template v-slot:label>
            <div><strong>Status History</strong></div>
          </template>
          <v-radio value="delivered">
            <template v-slot:label>
              <div>
                <strong>Delivered</strong>
                <div>{{ getPaidAtDate(getSinglePurchase.delivered_at) }}</div>
              </div>
            </template>
          </v-radio>
          <v-radio value="paid">
            <template v-slot:label>
              <div>
                <strong>Paid</strong>
                <div>{{ getPaidAtDate(getSinglePurchase.paid_at) }}</div>
              </div>
            </template>
          </v-radio>
        </v-radio-group>
      </v-container>
      <div>
        <v-btn
          class="mt-5 btn-create"
          @click="updatePurchaseStatus()"
          :loading="loading"
        >
          save
        </v-btn>
      </div>
      <div class="d-flex align-center justify-center">
        <div>
          <v-btn
            dense
            outlined
            small
            class="mt-5 mb-10"
            @click="updatePurchase()"
            style="border-color: #464646; width: 150px"
          >
            Edit
          </v-btn>
        </div>
        <div>
          <v-btn
            dense
            outlined
            small
            style="width: 150px"
            class="mt-5 ml-2 mb-10"
            color="red"
            @click="dialog = true"
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
    <v-dialog v-model="dialog" persistent max-width="390">
      <v-card>
        <v-card-title class="text-h7">
          Are you sure to delete this sale?
        </v-card-title>
        <v-card-text
          >By deleting, All of its transcation will be lost.</v-card-text
        >
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
  </div>
</template>
<script>
import { mapGetters } from "vuex";
import RequestService from "../../RequestService";
import { eventBus } from "@/main";
import moment from "moment";

export default {
  data: () => ({
    loading: false,
    Delivered: "",
    Paid: "",
    radios: "",
    decodedBase64: "",
    validFileSize: false,
    snacbarMessage: "",
    snackbar: false,
    snackbarColor: "",
    files: "",
    deleteable: "",
    dialog: false,
    image: "",
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
    this.getRadioStatus();
    console.log("nsde mounted", this.getSinglePurchase);
    if (this.getSinglePurchase.base64 && this.getSinglePurchase.base64 != "")
      this.image = "data:image/jpeg;base64," + this.getSinglePurchase.base64;
  },
  methods: {
    getPaidAtDate(date) {
      if (date == null) return;
      return moment(date).format("h:mm a, Do MMMM YYYY");
    },
    getRadioStatus() {
      if (
        this.getSinglePurchase.paid === null &&
        this.getSinglePurchase.delivered === null
      )
        this.radios = "";
      else if (
        this.getSinglePurchase.paid !== null &&
        this.getSinglePurchase.delivered === null
      )
        this.radios = "paid";
      else if (
        this.getSinglePurchase.paid !== null &&
        this.getSinglePurchase.delivered !== null
      )
        this.radios = "paid";
      else if (
        this.getSinglePurchase.paid == null &&
        this.getSinglePurchase.delivered !== null
      )
        this.radios = "delivered";
    },
    updatePurchaseStatus() {
      console.log(this.radios);
      let requestBody = {
        purchase_id: this.getSinglePurchase.id,
        status: this.radios,
        attachment:
          this.decodedBase64 != ""
            ? this.decodedBase64.replace("data:image/jpeg;base64,", "")
            : this.image.replace("data:image/jpeg;base64,", ""),
      };
      RequestService.post("purchase/update_purchase_status", requestBody).then(
        (response) => {
          if (response.data.status == 200) {
            console.log("purchase status updated");
            this.loading = true;
            this.snackbar = true;
            this.snackbarColor = "success";
            this.snacbarMessage = "Your purchase status updated successfully";
            setTimeout(() => {
              this.$router.push("/purchases");
            }, 1500);
          }
        }
      );
    },
    getStatus(item) {
      if (item.paid === null && item.delivered === null) return "Unpaid";
      else if (item.paid !== null && item.delivered === null) return "Paid";
      else if (item.paid !== null && item.delivered !== null) return "Paid";
      else if (item.paid == null && item.delivered !== null) return "Delivered";
    },
    updatePurchase() {
      if (this.getSinglePurchase.length != 0)
        this.$router.push("/purchase-receipt-form");
      setTimeout(() => {
        eventBus.$emit("updatePurchase", this.getSinglePurchase);
      }, 10);
    },
    deleteItem() {
      this.dialog = false;
      let requestBody = {
        purchase_id: this.getSinglePurchase.id,
      };
      RequestService.post("purchase/delete", requestBody).then((response) => {
        if (response.data.status == 200) {
          console.log("purchase deleted");
          this.loading = true;
          this.snackbar = true;
          this.snackbarColor = "success";
          this.snacbarMessage = "Your purchase deleted successfully";
          setTimeout(() => {
            this.$router.push("/purchases");
          }, 1500);
        }
      });
    },
    getDate(item) {
      let date = item.split(" ");
      console.log(date);
      return date[0];
    },
    getTme(item) {
      let date = item.split(" ");
      console.log(date[1]);
      let time = date[1];
      return moment(time, "HH:mm:ss").format("hh:mm a");
    },
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
.btn-create {
  background-color: #464646 !important;
  color: #fff;
  min-width: 320px !important;
  border-radius: 8px !important;
  cursor: pointer;
}
.sales-details-page {
  /* height: 100vh; */
  width: 600px;
  background-color: #ebebea;
  margin-left: 12rem;
}
.fonts {
  font-size: 12px;
}
</style>
