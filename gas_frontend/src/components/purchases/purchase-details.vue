<template>
  <div class="main-container">
    <div
      class="sales-details-page mb-5"
      :class="$vuetify.breakpoint.smAndDown ? 'ml-1' : ''"
      :style="$vuetify.breakpoint.smAndDown ? 'width: 85%' : ''"
    >
      <div class="d-flex">
        <div @click="goToPurchases()">
          <v-icon class="ml-3 mt-5"> mdi-close</v-icon>
        </div>
      </div>
      <div class="mt-6">
        <b>Purchase Details</b>
      </div>
      <v-divider class="ml-5 mr-5 mt-2"></v-divider>
      <div class="d-flex align-center justify-center mt-5">
        <div
          v-if="
            (image === '' && decodedBase64 === '') ||
            (getSinglePurchase.receipt_attachment_path === null &&
              decodedBase64 === '')
          "
          :style="
            $vuetify.breakpoint.smAndDown
              ? 'height: 100px; width: 100px'
              : 'height: 150px; width: 150px'
          "
          style="background-color: #c4c4c4"
        ></div>
        <img
          v-else
          style="border: 1px solid grey; border-radius: 5px"
          max-width="70"
          v-bind:src="decodedBase64 != '' ? decodedBase64 : image"
          height="150"
        />
      </div>
      <div class="d-flex align-center justify-center mt-1">
        <label for="file-input">
          <div
            style="text-decoration: underline; cursor: pointer"
            class="fonts mr-2"
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
        <div :class="$vuetify.breakpoint.smAndDown ? 'ml-3' : 'ml-10'">
          <v-chip
            dense
            label
            class="pa-3"
            style="background-color: #ebffef; color: #5fba7e"
          >
            <v-icon size="10" color="#5FBA7E" class="mr-4">mdi-circle</v-icon>
            {{ getStatus(getSinglePurchase) }}
          </v-chip>
        </div>
        <v-spacer></v-spacer>
        <div
          class="fonts"
          :class="$vuetify.breakpoint.smAndDown ? 'mr-3' : 'mr-8'"
        >
          <div>
            <b>{{ getDate(getSinglePurchase.date) }}</b>
          </div>
          <div>{{ getTme(getSinglePurchase.date) }}</div>
        </div>
      </div>
      <div
        class="d-flex align-start justify-start mt-10"
        style="font-size: 16px; font-weight: 600"
        :class="$vuetify.breakpoint.smAndDown ? 'ml-3' : 'ml-5'"
      >
        Company Info
      </div>
      <div class="d-flex">
        <div
          class="mt-5"
          :class="$vuetify.breakpoint.smAndDown ? 'ml-3' : 'ml-5'"
        >
          <div class="d-flex align-start justify-start">
            <b>{{ getSinglePurchase.company_name }}</b>
          </div>
          <div class="d-flex align-start justify-start fonst">
            {{ getSinglePurchase.company_phone_number }}
          </div>
          <div class="d-flex align-start justify-start fonts">
            {{ getSinglePurchase.company_address }}
          </div>
        </div>
        <v-spacer></v-spacer>
        <div
          class="mt-5"
          :class="$vuetify.breakpoint.smAndDown ? 'mr-3' : 'mr-8'"
        >
          <div class="fonts">Transaction Id</div>
          <div class="fonts">{{ getSinglePurchase.receipt_number }}</div>
        </div>
      </div>
      <div
        class="mt-5 d-flex align-start justify-start"
        :class="$vuetify.breakpoint.smAndDown ? 'ml-3' : 'ml-5'"
      >
        <b>Purchase Info</b>
      </div>
      <div class="d-flex">
        <div
          class="mt-5"
          :class="$vuetify.breakpoint.smAndDown ? 'ml-3' : 'ml-5'"
        >
          <div class="d-flex">
            <div class="fonts"><b>Unit Gas Price:&nbsp;</b></div>
            <div class="fonts">N{{ getSinglePurchase.unit_price }}</div>
          </div>
          <div class="d-flex">
            <div class="fonts"><b>Total Amount:&nbsp;</b></div>
            <div class="fonts">N{{ getSinglePurchase.amount }}</div>
          </div>
          <div class="d-flex">
            <div class="fonts"><b>Admin Cost:&nbsp;</b></div>
            <div class="fonts">N{{ getSinglePurchase.admin_cost }}</div>
          </div>
        </div>
        <v-spacer></v-spacer>
        <div
          class="mt-7"
          :class="$vuetify.breakpoint.smAndDown ? 'mr-4' : 'mr-8'"
        >
          <div class="row">
            <div class="fonts">Gas Quanity:&nbsp;</div>
            <div class="fonts_">{{ getSinglePurchase.gas_quantity }}</div>
          </div>
          <div class="row">
            <div class="fonts">Logistics:&nbsp;</div>
            <div class="fonts_">{{ getSinglePurchase.logistics_cost }}</div>
          </div>
          <div class="row">
            <div class="fonts">Total Amount:&nbsp;</div>
            <div class="fonts_">
              {{
                parseInt(getSinglePurchase.amount) +
                parseInt(getSinglePurchase.logistics_cost) +
                parseInt(getSinglePurchase.gas_quantity)
              }}
            </div>
          </div>
        </div>
      </div>

      <div
        class="mt-5 d-flex align-start justify-start"
        :class="$vuetify.breakpoint.smAndDown ? 'ml-3' : 'ml-5'"
      >
        <div class="fonts">Driver's Name:&nbsp;</div>
        <div class="fonts_">N{{ getSinglePurchase.driver_name }}</div>

        <v-spacer></v-spacer>
        <div
          class="mt-3"
          :class="$vuetify.breakpoint.smAndDown ? 'mr-4' : 'mr-8'"
        >
          <div class="row">
            <div class="fonts">Recepient By:&nbsp;</div>
            <div class="fonts_">{{ getSinglePurchase.recepient_name }}</div>
          </div>
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
          class="mt-5 btn-create text-capitalize"
          @click="updatePurchaseStatus()"
          :loading="loading"
        >
          Save
        </v-btn>
      </div>
      <div class="d-flex align-center justify-center">
        <div>
          <v-btn
            dense
            outlined
            small
            class="mt-5 mb-10 text-capitalize"
            @click="updatePurchase()"
            :style="
              $vuetify.breakpoint.smAndDown ? 'width: 70px' : 'width: 150px'
            "
            style="border-color: #464646; border-radius: 20px"
          >
            Edit
          </v-btn>
        </div>
        <div>
          <v-btn
            dense
            outlined
            small
            style="border-radius: 20px"
            :style="
              $vuetify.breakpoint.smAndDown ? 'width: 70px' : 'width: 150px'
            "
            class="mt-5 ml-2 mb-10 text-capitalize"
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
  watch: {},
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
    if (this.getSinglePurchase.length == 0) this.$router.push("/purchases");

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
      return date[0];
    },
    getTme(item) {
      let date = item.split(" ");
      let time = date[1];
      return moment(time, "HH:mm:ss").format("hh:mm a");
    },
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
            if (fileType == "jpg") {
              fileType = "jpeg";
            }
            that.decodedBase64 = fileBase64.replace(
              "data:image/" + fileType + ";base64,",
              ""
            );
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
  background-color: #2e3995 !important;
  color: #fff;
  min-height: 30px;
  min-width: 55% !important;
  border-radius: 20px !important;
  cursor: pointer;
}
.sales-details-page {
  /* height: 100vh; */

  width: 45%;
  background-color: #ebebea;
  margin-left: 12rem;
}
.fonts {
  font-size: 12px;
}
.fonts_ {
  font-size: 12px;
  font-weight: bold;
}
</style>
