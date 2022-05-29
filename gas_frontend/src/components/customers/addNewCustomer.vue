<template>
    <div class="main-container">
        <div class="d-flex align-start justify-start">
           <v-icon>mdi-chevron-left</v-icon> <span>Back</span>
        </div>
        <div class="mt-3">
            <div class="d-flex align-start justify-start"> <b>New Customer</b></div>
            <div  class="d-flex align-start justify-start fonts mt-1">Enter the following details to create a customer profile</div>
            <v-form v-model="valid" class="mt-5">
                <div>
                    <v-text-field
                        v-model="name"
                        label="Enter Name"
                        outlined
                        dense
                        hide-details
                        class="mt-1"
                        style="width:300px"
                    ></v-text-field>
                </div>
                <div>
                    <v-text-field
                        v-model="phone_number"
                        label="Phone Number"
                        outlined
                        dense
                        hide-details
                        class="mt-1"
                        style="width:300px"
                    ></v-text-field>
                </div>
                 <div>
                    <v-text-field
                        v-model="email"
                        label="Email Address"
                        outlined
                        dense
                        hide-details
                        class="mt-1"
                        style="width:300px"
                    ></v-text-field>
                </div>
                 <div>
                    <v-text-field
                        v-model="street"
                        label="Enter Address"
                        outlined
                        dense
                        hide-details
                        class="mt-1"
                        style="width:300px"
                    ></v-text-field>
                </div>
                 <div class="d-flex" style="width:300px">
                 <div>
                        <v-text-field
                            label="City"
                            outlined
                            dense
                            placeholder="City"
                            hide-details
                            class="city-feild mt-2 mr-3"
                            v-model="state"
                        ></v-text-field>
                   </div>
                   <div class="mt-2">
                        <v-select
                        :items="status"
                        label="Select Status"
                        outlined
                      small
                      dense
                        hide-details
                    >
                    </v-select>
                   </div>
               </div>
               
                 <div class="mt-3" style="width:300px">
                 <v-select
                        :items="status"
                        label="User Type"
                        outlined
                        hide-details
                        small
                        dense
                    >
                    </v-select>
                </div>
                <div class="mt-5  mb-5">
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