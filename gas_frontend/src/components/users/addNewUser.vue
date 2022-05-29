<template>
    <div class="main-container">
        <div class="d-flex align-start justify-start">
           <v-icon>mdi-chevron-left</v-icon> <span>Back</span>
        </div>
        <div class="mt-3">
            <div class="d-flex align-start justify-start"> <b>Add New User</b></div>
            <div  class="d-flex align-start justify-start fonts mt-1">Enter the following details to create a user profile</div>
            <v-form v-model="valid" class="mt-5">
                <div>
                    <v-text-field
                        v-model="created_by"
                        label="Created By"
                        outlined
                        dense
                        hide-details
                        class="mt-1"
                        style="width:300px"
                    ></v-text-field>
                </div>
                <div>
                    <v-text-field
                        v-model="username"
                        label="User Name"
                        outlined
                        dense
                        hide-details
                        class="mt-1"
                        style="width:300px"
                    ></v-text-field>
                </div>
                 <div>
                    <v-text-field
                        v-model="password"
                        label="password"
                        outlined
                        dense
                        hide-details
                        class="mt-1"
                        style="width:300px"
                    ></v-text-field>
                </div>
                 <div>
                    <v-text-field
                        v-model="desgination"
                        label="Desgination"
                        outlined
                        dense
                        hide-details
                        class="mt-1"
                        style="width:300px"
                    ></v-text-field>
                </div>
                <div class="mt-3" style="width:300px">
                 <v-select
                        :items="status"
                        label="Select Status"
                        outlined
                        hide-details
                    >
                    </v-select>
                </div>
                 <div class="mt-3" style="width:300px">
                 <v-select
                        :items="status"
                        label="User Type"
                        outlined
                        hide-details
                    >
                    </v-select>
                </div>
                <div class="d-flex justify-start align-start mt-3"><b>Access Granted</b></div>
                <div class="d-flex fonts">
                   <v-radio-group
      v-model="row"
      row
    >
      <v-radio
        label="Dashboard"
        value="radio-1"
      ></v-radio>
      <v-radio
        label="Sales"
        value="radio-2"
      ></v-radio>
       <v-radio
        label="Orders"
        value="radio-3"
      ></v-radio>
       <v-radio
        label="Purchases"
        value="radio-4"
      ></v-radio>
    </v-radio-group>
                </div>
                <div class="d-flex fonts">
                   <v-radio-group
      v-model="row"
      row
    >
      <v-radio
        label="Customers"
        value="radio-1"
      ></v-radio>
      <v-radio
        label="Users"
        value="radio-2"
      ></v-radio>
       <v-radio
        label="Wallet"
        value="radio-3"
      ></v-radio>
       <v-radio
        label="Reconilcation"
        value="radio-4"
      ></v-radio>
    </v-radio-group>
                </div>
                <div class="mt-5  mb-5 ml-16">
                <v-btn
                  block
                  large
                  class="elevation-0 btn-create"
                  :loading="loading"
                  :disabled="!valid"
                  @click="createAccount()"
                  dense
                >
                 Save
                </v-btn>
              </div>
            </v-form>
        </div>
    </div>
</template>
<script>
  export default {
    data: () => ({
      status: ['Foo', 'Bar', 'Fizz', 'Buzz'],
    }),
  }
</script>
<style scoped>
.fonts{
    font-size: 12px;
}
.btn-create {
  background-color: #464646 !important;
  color: #fff;
  min-width: 300px !important;
  border-radius: 8px !important;
  cursor: pointer;
}
</style>