<template>
  <div class="main-container">
    <div class="sales-details-page pa-6">
      <div class="d-flex">
        <div @click="goToSales()">
          <v-icon class="ml-3 mt-5"> mdi-close</v-icon>
        </div>
        <v-spacer></v-spacer>
        <div>
          <v-btn
            height="35"
            min-width="25"
            dense
            color="#2e3995"
            @click="goToinvoicePage()"
          >
            <img
              height="20"
              width="20"
              src="../../assets/images/Vector (1).png"
            />
          </v-btn>
        </div>
      </div>
      <div class="mt-6 mb-2">
        <b>Sales Details</b>
      </div>
      <v-divider></v-divider>
      <div class="d-flex mt-5">
        <div class="ml-10">
          <v-chip
            dense
            label
            class="pa-3"
            style="background-color: #ebffef; color: #5fba7e"
          >
            <v-icon size="10" color="#5FBA7E" class="mr-4">mdi-circle</v-icon>
            {{ getStatus(getSingleReceipt) }}
          </v-chip>
        </div>
        <v-spacer></v-spacer>
        <div class="mr-10 fonts">
          <div>
            <b>{{ getDate(getSingleReceipt.created_at) }}</b>
          </div>
          <div>{{ getTme(getSingleReceipt.created_at) }}</div>
        </div>
      </div>
      <div
        class="d-flex align-start justify-start ml-5 mt-10"
        style="font-size: 16px; font-weight: 600"
      >
        Customer Info
      </div>
      <div class="d-flex">
        <div class="ml-5 mt-5">
          <div class="d-flex align-start justify-start fonts">
            {{ getSingleReceipt.customer_type }}
          </div>
          <div class="d-flex align-start justify-start">
            <b>{{ getSingleReceipt.customer_name }}</b>
          </div>
          <div class="d-flex align-start justify-start fonst">
            {{ getSingleReceipt.customer_phone_number }}
          </div>
          <div class="d-flex align-start justify-start fonts">
            {{ getSingleReceipt.customer_address }}
          </div>
        </div>
        <v-spacer></v-spacer>
        <div class="mr-8 mt-5">
          <div class="fonts">Transcation Id</div>
          <div class="fonts font-weight-bold">
            00000000{{ getSingleReceipt.transaction_id }}
          </div>
        </div>
      </div>
      <div class="mt-5 ml-5 d-flex justify-start align-start">
        <b>Sales Info</b>
      </div>
      <div class="d-flex">
        <div class="ml-5 mt-5">
          <div class="d-flex">
            <div class="fonts"><b>Unit Gas Price:</b></div>
            <div class="fonts">{{ getSingleReceipt.price }}</div>
          </div>
          <div class="d-flex">
            <div class="fonts"><b>Total Amount:</b></div>
            <div class="fonts">{{ getSingleReceipt.total_amount }}</div>
          </div>
          <div class="d-flex">
            <div class="fonts"><b>Payment Mode:</b></div>
            <div class="fonts">{{ getSingleReceipt.payment_mode }}</div>
          </div>
        </div>
        <v-spacer></v-spacer>
        <div class="mr-8 mt-5">
          <div class="fonts">
            Gas Quantity: {{ getSingleReceipt.gas_quantity }}
          </div>
           <div class="fonts">
            Promo Used: {{ getSingleReceipt.discount_code }}
          </div>
          <div class="fonts">Updated By: {{ getSingleReceipt.updated_by }}</div>
        </div>
      </div>
      <!--<div class="mt-5" style="text-decoration: underline">
        <b>Status History</b>
      </div>-->
      <!--<div class="fonts mt-5">
        <div class="d-flex align-start justify-start ml-3">
          <v-radio-group v-model="Delivered" column>
            <v-radio
              label="Delivered"
              color="primary"
              value="Delivered"
            ></v-radio>
          </v-radio-group>
        </div>
        <div class="d-flex align-start justify-start ml-8">
          23rd ,april 20222
        </div>
      </div>
      <div class="fonts">
        <div class="d-flex align-start justify-start ml-3">
          <v-radio-group v-model="Paid" column>
            <v-radio label="paid" color="primary" value="Paid"></v-radio>
          </v-radio-group>
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
                <div>{{ getPaidAtDate(getSingleReceipt.delivered_at) }}</div>
              </div>
            </template>
          </v-radio>
          <v-radio value="paid">
            <template v-slot:label>
              <div>
                <strong>Paid</strong>
                <div>{{ getPaidAtDate(getSingleReceipt.paid_at) }}</div>
              </div>
            </template>
          </v-radio>
        </v-radio-group>
      </v-container>
      <div>
        <v-btn
          class="mt-5 btn-create"
          @click="updateSaleStatus()"
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
            style="border-color: #464646; width: 150px"
            @click="updateSale()"
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
import RequestService from "../../RequestService";
import { eventBus } from "@/main";
import moment from "moment";
export default {
  data: () => ({
    loading: false,
    Delivered: "",
    Paid: "",
    radios: "",
    deleteable: "",
    dialog: false,
    snacbarMessage: "",
    snackbar: false,
    snackbarColor: "",
  }),
  watch: {
    getSingleReceipt() {
      console.log("data", this.getSingleReceipt);
    },
    radios() {
      console.log(this.radios);
    },
  },
  computed: {
    ...mapGetters(["getSingleReceipt"]),
    getIcon() {
      return this.snackbarColor == "success"
        ? "mdi-checkbox-marked-circle"
        : "mdi-close-circle";
    },
  },
  mounted() {
    this.getRadioStatus(this.getSingleReceipt);
    if (this.getSingleReceipt.length == 0) {
      this.$router.push("/sales");
    }
  },
  methods: {
    goToinvoicePage() {
      this.$router.push("/sale-invoice");
    },
    getPaidAtDate(date) {
      if (date == null) return;
      return moment(date).format("h:mm a, Do MMMM YYYY");
    },
    getRadioStatus() {
      if (
        this.getSingleReceipt.paid === null &&
        this.getSingleReceipt.delivered === null
      )
        this.radios = "";
      else if (
        this.getSingleReceipt.paid !== null &&
        this.getSingleReceipt.delivered === null
      )
        this.radios = "paid";
      else if (
        this.getSingleReceipt.paid !== null &&
        this.getSingleReceipt.delivered !== null
      )
        this.radios = "paid";
      else if (
        this.getSingleReceipt.paid == null &&
        this.getSingleReceipt.delivered !== null
      )
        this.radios = "delivered";
    },
    updateSaleStatus() {
      console.log(this.radios);
      let requestBody = {
        sale_id: this.getSingleReceipt.id,
        status: this.radios,
      };
      RequestService.post("sale/update_sale_status", requestBody).then(
        (response) => {
          if (response.data.status == 200) {
            console.log("sale status updated");
            this.loading = true;
            this.snackbar = true;
            this.snackbarColor = "success";
            this.snacbarMessage = "Your sale status updated successfully";
            setTimeout(() => {
              this.$router.push("/sales");
            }, 1500);
          }
        }
      );
    },
    updateSale() {
      if (this.getSingleReceipt.length != 0)
        this.$router.push("/sale-receipt-form");
      setTimeout(() => {
        eventBus.$emit("updateSale", this.getSingleReceipt);
      }, 10);
      //this.$store.commit("SET_SINGLE_CUSTOMER_DATA", item);
    },
    deleteItem() {
      this.dialog = false;
      let requestBody = {
        sale_id: this.getSingleReceipt.id,
      };
      RequestService.post("sale/delete", requestBody).then((response) => {
        if (response.data.status == 200) {
          console.log("sale deleted");
          this.loading = true;
          this.snackbar = true;
          this.snackbarColor = "success";
          this.snacbarMessage = "Your sale(s) deleted successfully";
          setTimeout(() => {
            this.$router.push("/sales");
          }, 1500);
        }
      });
    },
    getDate(item) {
      let date = item.split(" ");
      return date[0] + " " + date[1] + " " + date[2];
    },
    getTme(item) {
      let date = item.split(" ");
      return date[3] + date[4];
    },
    getStatus(item) {
      if (item.paid === null && item.delivered === null) return "Unpaid";
      else if (item.paid !== null && item.delivered === null) return "Paid";
      else if (item.paid !== null && item.delivered !== null) return "Paid";
      else if (item.paid == null && item.delivered !== null) return "Delivered";
    },
    goToSales() {
      this.$router.push("/sales");
    },
  },
};
</script>
<style scoped>
.btn-create {
  /*background-color: #464646 !important;
  color: #fff;
  min-width: 320px !important;
  border-radius: 8px !important;
  cursor: pointer;*/
  background-color: #2e3995 !important;
  color: #fff;
  min-width: 310px !important;
  border-radius: 4px !important;
  cursor: pointer;
  /*margin-right: 8rem;*/
}
.sales-details-page {
  height: 770px;
  width: 600px;
  background-color: #ebebea;
  margin-left: 12rem;
}
.fonts {
  font-size: 12px;
}
</style>
