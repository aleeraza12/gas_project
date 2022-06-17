<template>
  <div>
    <div>
      <v-app-bar color="grey" dense dark>
        <v-toolbar-title class="">Settings</v-toolbar-title>

        <v-spacer></v-spacer>
        <v-btn icon @click="goToChangeSettings()">
          <v-icon>mdi-account</v-icon>
        </v-btn>

        <v-menu left bottom>
          <template v-slot:activator="{ on, attrs }">
            <v-btn icon v-bind="attrs" v-on="on">
              <v-icon>mdi-dots-vertical</v-icon>
            </v-btn>
          </template>

          <v-list class="mt-10 cursor">
            <v-list-item @click="dialogStates = true">
              <v-list-item-title>Add States Name</v-list-item-title>
            </v-list-item>
            <v-list-item @click="dialogCustomertype = true">
              <v-list-item-title>Add Customer Types</v-list-item-title>
            </v-list-item>
            <v-list-item @click="dialogUsertype = true">
              <v-list-item-title>Add User types</v-list-item-title>
            </v-list-item>
            <v-list-item @click="dialogPaymentMethods = true">
              <v-list-item-title>Add Payment Statuses</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </v-app-bar>
    </div>
    <div>
      <v-row class="ma-5">
        <v-col cols="3" sm="12" md="3">
          <div class="mt-3">
            <v-data-table
              :loading="loading1"
              loading-text="Loading... Please wait"
              :headers="headersCustomerTypes"
              :items="getAllCustomerTypesSettings"
              :items-per-page="10"
              class="elevation-1"
              hide-default-footer
              hide-default-header
              height="300px"
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
              <template v-slot:item.edit="{ item }">
                <v-icon
                  small
                  class="mr-2"
                  @click="setCRUDItems(item, 'edit', 'Customer Type')"
                >
                  mdi-pencil
                </v-icon>
              </template>
              <template v-slot:item.delete="{ item }">
                <v-icon
                  color="red"
                  small
                  class="mr-2"
                  @click="setCRUDItems(item, 'delete', 'Customer Type')"
                >
                  mdi-delete-empty
                </v-icon>
              </template>
            </v-data-table>
          </div>
        </v-col>
        <v-col cols="3" sm="12" md="3">
          <div class="mt-3">
            <v-data-table
              :loading="loading2"
              loading-text="Loading... Please wait"
              :headers="headersPayment"
              :items="getAllPaymentModesSettings"
              :items-per-page="5"
              class="elevation-1"
              hide-default-footer
              hide-default-header
              height="300px"
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
              <template v-slot:item.edit="{ item }">
                <v-icon
                  small
                  class="mr-2"
                  @click="setCRUDItems(item, 'edit', 'Payment Mode')"
                >
                  mdi-pencil
                </v-icon>
              </template>
              <template v-slot:item.delete="{ item }">
                <v-icon
                  color="red"
                  small
                  class="mr-2"
                  @click="setCRUDItems(item, 'delete', 'Payment Mode')"
                >
                  mdi-delete-empty
                </v-icon>
              </template>
            </v-data-table>
          </div>
        </v-col>
        <v-col cols="3" sm="12" md="3">
          <div class="mt-3">
            <v-data-table
              :loading="loading3"
              loading-text="Loading... Please wait"
              :headers="headersUserTypes"
              :items="getAllUserTypesSettings"
              :items-per-page="5"
              class="elevation-1"
              hide-default-footer
              hide-default-header
              height="300px"
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
              <template v-slot:item.edit="{ item }">
                <v-icon
                  small
                  class="mr-2"
                  @click="setCRUDItems(item, 'edit', 'User Type')"
                >
                  mdi-pencil
                </v-icon>
              </template>
              <template v-slot:item.delete="{ item }">
                <v-icon
                  small
                  color="red"
                  class="mr-2"
                  @click="setCRUDItems(item, 'delete', 'User Type')"
                >
                  mdi-delete-empty
                </v-icon>
              </template>
            </v-data-table>
          </div>
        </v-col>
        <v-col cols="3" sm="12" md="3">
          <div class="mt-3">
            <v-data-table
              :loading="loading4"
              loading-text="Loading... Please wait"
              :headers="headersStates"
              :items="getAllStatesSettings"
              :items-per-page="5"
              class="elevation-1"
              hide-default-footer
              hide-default-header
              height="300px"
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
              <template v-slot:item.edit="{ item }">
                <v-icon
                  small
                  class="mr-2"
                  @click="setCRUDItems(item, 'edit', 'State')"
                >
                  mdi-pencil
                </v-icon>
              </template>
              <template v-slot:item.delete="{ item }">
                <v-icon
                  color="red"
                  small
                  class="mr-2"
                  @click="setCRUDItems(item, 'delete', 'State')"
                >
                  mdi-delete-empty
                </v-icon>
              </template>
            </v-data-table>
          </div>
        </v-col>
      </v-row>
    </div>
    <v-dialog v-model="dialogCustomertype" persistent max-width="290">
      <v-card>
        <v-card-title class="text-h5"> Add Customer Types </v-card-title>
        <v-card-text>
          <v-text-field
            v-model="customer_type"
            solo
            label="Enter Customer Type"
            clearable
          ></v-text-field
        ></v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="black" text @click="dialogCustomertype = false" small>
            Cancel
          </v-btn>
          <v-btn
            color="green darken-1"
            text
            @click="createCustomerTypes()"
            small
          >
            Add
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="dialogUsertype" persistent max-width="290">
      <v-card>
        <v-card-title class="text-h5"> Add User Types </v-card-title>
        <v-card-text>
          <v-text-field
            v-model="user_type"
            solo
            label="Enter User Type"
            clearable
          ></v-text-field
        ></v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="black" text @click="dialogUsertype = false" small>
            Cancel
          </v-btn>
          <v-btn small color="green darken-1" text @click="createUserTypes()">
            Add
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="dialogPaymentMethods" persistent max-width="290">
      <v-card>
        <v-card-title class="text-h5"> Add New Payment Method </v-card-title>
        <v-card-text>
          <v-text-field
            v-model="payment_mode"
            solo
            label="Enter Payment Mode"
            clearable
          ></v-text-field
        ></v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="black" small text @click="dialogPaymentMethods = false">
            Cancel
          </v-btn>
          <v-btn
            color="green darken-1"
            small
            text
            @click="createPaymentMethods()"
          >
            Add
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="dialogStates" persistent max-width="290">
      <v-card>
        <v-card-title class="text-h5"> Add New States </v-card-title>
        <v-card-text>
          <v-text-field
            v-model="states"
            solo
            label="Enter States Name"
            clearable
          ></v-text-field
        ></v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="black" small text @click="dialogStates = false">
            Cancel
          </v-btn>
          <v-btn small color="green darken-1" text @click="createStates()">
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
    <v-dialog v-model="dialog" persistent max-width="450">
      <v-card>
        <v-card-title class="text-h7">
          Are you sure to {{ operation_type }} this {{ operation_text }}?
        </v-card-title>
        <!--<v-card-text>By deleting, All of the data will be lost.</v-card-text>-->
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
import { eventBus } from "@/main";
import RequestService from "../../RequestService";
export default {
  data() {
    return {
      loading1: true,
      loading2: true,
      loading3: true,
      operation_type: "",
      operation_text: "",
      updateAble: "",
      loading4: true,
      dialogCustomertype: false,
      dialogUsertype: false,
      dialogStates: false,
      dialogPaymentMethods: false,
      customer_type: "",
      user_type: "",
      states: "",
      payment_mode: "",
      snacbarMessage: "",
      snackbar: false,
      snackbarColor: "",
      dialog: false,
      customer_type_id: null,
      user_type_id: null,
      payment_mode_id: null,
      states_id: null,
      deleteAPI: null,
      headersStates: [
        {
          text: "States",
          align: "start",
          sortable: false,
          value: "state_name",
        },
        { text: "Edit", value: "edit" },
        { text: "Delete", value: "delete" },
      ],
      headersPayment: [
        {
          text: "Payment Mode",
          align: "start",
          sortable: false,
          value: "payment_mode",
        },
        { text: "Edit", value: "edit" },
        { text: "Delete", value: "delete" },
      ],
      headersUserTypes: [
        {
          text: "User Type",
          align: "start",
          sortable: false,
          value: "user_type",
        },
        { text: "Edit", value: "edit" },
        { text: "Delete", value: "delete" },
      ],
      headersCustomerTypes: [
        {
          text: "Customer Type",
          align: "start",
          sortable: false,
          value: "customer_type",
        },
        { text: "Edit", value: "edit" },
        { text: "Delete", value: "delete" },
      ],
    };
  },
  created() {
    eventBus.$on("responseArrivedPaymentMode", () => {
      this.loading1 = false;
    });
    eventBus.$on("responseArrivedCustomerTypes", () => {
      this.loading2 = false;
    });
    eventBus.$on("responseArrivedUserTypes", () => {
      this.loading3 = false;
    });
    eventBus.$on("responseArrivedStates", () => {
      this.loading4 = false;
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
  watch: {},
  mounted() {
    this.$store.dispatch("getAllStatesSettings");
    this.$store.dispatch("getUserTypesSettings");
    this.$store.dispatch("getCustomerTypesSettings");
    this.$store.dispatch("getPaymentMethodsSettings");
  },
  computed: {
    ...mapGetters([
      "getAllStatesSettings",
      "getAllUserTypesSettings",
      "getAllCustomerTypesSettings",
      "getAllPaymentModesSettings",
    ]),
    getIcon() {
      return this.snackbarColor == "success"
        ? "mdi-checkbox-marked-circle"
        : "mdi-close-circle";
    },
  },
  methods: {
    goToChangeSettings() {
      this.$router.push("/new-customer-company");
    },
    setCRUDItems(item, operation_type, operation_text) {
      console.log(item);
      if (operation_type == "edit") {
        if (operation_text == "Customer Type") {
          this.customer_type = item.customer_type;
          this.customer_type_id = item.id;
          this.dialogCustomertype = true;
        } else if (operation_text == "User Type") {
          this.user_type = item.user_type;
          this.user_type_id = item.id;
          this.dialogUsertype = true;
        } else if (operation_text == "Payment Mode") {
          this.payment_mode = item.payment_mode;
          this.payment_mode_id = item.id;
          this.dialogPaymentMethods = true;
        } else if (operation_text == "State") {
          this.states = item.state_name;
          this.states_id = item.id;
          this.dialogStates = true;
        }
      } else {
        this.dialog = true;
        this.updateAble = item;
        this.operation_type = operation_type;
        this.operation_text = operation_text;
        if (operation_text == "Customer Type") {
          this.deleteAPI = "customer_type/delete";
          this.customer_type_id = item.id;
        } else if (operation_text == "User Type") {
          this.deleteAPI = "user_type/delete";
          this.user_type_id = item.id;
        } else if (operation_text == "Payment Mode") {
          this.deleteAPI = "payment/mode/delete";
          this.payment_mode_id = item.id;
        } else if (operation_text == "State") {
          this.deleteAPI = "states/delete";
          this.states_id = item.id;
        }
      }
    },
    deleteItem() {
      this.dialog = false;
      let requestBody = {};
      if (this.operation_text == "Customer Type")
        requestBody.customer_type_id = this.customer_type_id;
      else if (this.operation_text == "User Type")
        requestBody.user_type_id = this.user_type_id;
      else if (this.operation_text == "Payment Mode")
        requestBody.payment_mode_id = this.payment_mode_id;
      else if (this.operation_text == "State")
        requestBody.states_id = this.states_id;
      RequestService.post(this.deleteAPI, requestBody)
        .then((response) => {
          if (response.data.status == 200) {
            this.snackbar = true;
            this.snackbarColor = "success";
            this.snacbarMessage = `"${this.operation_text} Deleted successfully"`;
            if (this.operation_text == "Customer Type")
              this.$store.dispatch("getCustomerTypesSettings");
            else if (this.operation_text == "User Type")
              this.$store.dispatch("getUserTypesSettings");
            else if (this.operation_text == "Payment Mode")
              this.$store.dispatch("getPaymentMethodsSettings");
            else if (this.operation_text == "State")
              this.$store.dispatch("getAllStatesSettings");
          }
        })
        .catch(() => {});
    },
    createCustomerTypes() {
      this.dialogCustomertype = false;
      let requestBody = {
        customer_type: this.customer_type,
        customer_type_id: this.customer_type_id,
      };
      RequestService.post("customer_type/create", requestBody)
        .then((response) => {
          if (response.data.status == 201) {
            this.customer_type = "";
            this.loading = true;
            this.snackbar = true;
            this.snackbarColor = "success";
            this.snacbarMessage = "Your customer types added successfully";
            this.$store.dispatch("getCustomerTypesSettings");
          }
        })
        .catch(() => {});
    },

    createUserTypes() {
      this.dialogUsertype = false;
      let requestBody = {
        user_type: this.user_type,
        user_type_id: this.user_type_id,
      };
      RequestService.post("user_type/create", requestBody).then((response) => {
        if (response.data.status == 201) {
          this.user_type = "";
          this.loading = true;
          this.snackbar = true;
          this.snackbarColor = "success";
          this.snacbarMessage = "Your user types added successfully";
          this.$store.dispatch("getUserTypesSettings");
        }
      });
    },

    createPaymentMethods() {
      this.dialogPaymentMethods = false;
      let requestBody = {
        payment_mode: this.payment_mode,
        payment_mode_id: this.payment_mode_id,
      };
      RequestService.post("payment/mode/create", requestBody).then(
        (response) => {
          if (response.data.status == 201) {
            this.payment_mode = "";
            this.loading = true;
            this.snackbar = true;
            this.snackbarColor = "success";
            this.snacbarMessage = "Your payment mode added successfully";
            this.$store.dispatch("getPaymentMethodsSettings");
          }
        }
      );
    },

    createStates() {
      this.dialogStates = false;
      let requestBody = {
        state_name: this.states,
        states_id: this.states_id,
      };
      RequestService.post("states/create", requestBody).then((response) => {
        if (response.data.status == 201) {
          this.state_name = "";
          this.loading = true;
          this.snackbar = true;
          this.snackbarColor = "success";
          this.snacbarMessage = "Your states added successfully";
          this.$store.dispatch("getAllStatesSettings");
        }
      });
    },
  },
};
</script>
<style scoped>
.table-head {
  background-color: #ebebea;
  font-size: 12px;
  height: 50px;
}
.cursor {
  cursor: pointer;
}
</style>
