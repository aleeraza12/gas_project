<template>
    <div class="main-container">
        <div class="d-flex">
          <div >
                 <div class="mt-4 ml-3 d-flex align-start justify-start">
           <v-btn small dense outlined> back</v-btn>
       </div>
       <div  class="mt-5 ml-3 d-flex align-start justify-start"> <b>Purchase Recepit Form</b></div>
       <div  class="mt-2 ml-3 d-flex align-start justify-start">Enter the following details to  Purchase Recepit</div>
       <div style="width:400px" class="pa-8">
            <v-form v-model="valid">
                <div>
                    <v-text-field
                    label="Date"
                    outlined
                    dense
                    placeholder="Date"
                    hide-details
                    class="username-feild "
                    v-model="date"
                ></v-text-field>
               </div>
                 <div>
                    <v-text-field
                    label="Recepit Number"
                    outlined
                    dense
                    placeholder="Recepeit Number"
                    hide-details
                    class="username-feild "
                    v-model="recepit_number"
                ></v-text-field>
               </div>
               <div>
                    <v-text-field
                    label="Company Name"
                    outlined
                    dense
                    placeholder="Company Name"
                    hide-details
                    class="username-feild "
                    v-model="company_name"
                ></v-text-field>
               </div>
               <div>
                    <v-text-field
                    label="Phone Number"
                    outlined
                    dense
                    placeholder="Phone Number"
                    hide-details
                    class="username-feild mt-2 "
                    v-model="phone_number"
                ></v-text-field>
                </div>
                <div>
                    <v-text-field
                    label="Enter Price"
                    outlined
                    dense
                    placeholder="Enter Price"
                    hide-details
                    class="username-feild mt-2 "
                    v-model="price"
                ></v-text-field>
                </div>
               <div class="d-flex">
                 <div>
                        <v-text-field
                            label="Quantity"
                            outlined
                            dense
                            placeholder="Quantity"
                            hide-details
                            class="city-feild mt-2 mr-3"
                            v-model="city"
                        ></v-text-field>
                   </div>
                   <div>
                        <v-text-field
                            label="Amount"
                            outlined
                            dense
                            placeholder="Amount"
                            hide-details
                            class="city-feild mt-2"
                            v-model="city"
                        ></v-text-field>
                   </div>
               </div>
               <div>
                    <v-text-field
                    label="Driver Name"
                    outlined
                    dense
                    placeholder="Driver Name"
                    hide-details
                    class="username-feild mt-2"
                    v-model="driver_name"
                ></v-text-field>
               </div>
                <div>
                    <v-text-field
                    label="Recepitant Name"
                    outlined
                    dense
                    placeholder="Recepitane Name"
                    hide-details
                    class="username-feild mt-2"
                    v-model="recpitance_name"
                ></v-text-field>
               </div>
                <div class=""> 
                    <v-btn  class="elevation-0 mt-2  btn-create" @click="save()" dense >
                    Submit
                    </v-btn>
               </div>
          </v-form>
       </div>
          </div>
          <div>
            <div style="height:300px;width:300px;;margin-top:10rem" class="pa-10 ml-16">
              <v-icon size="80">mdi-image</v-icon><v-icon>mdi-plus</v-icon>

           </div>
          </div>
        </div>
    </div>
</template>
<script>

  export default {
    data: () => ({
      valid: false,
      show:false,
      show1:false,
     owners_name:"",
     company_name:"",
     email_address:"",
     phone_number:"",
     address:"",
     password:"",
     confirm_password:"",
     city:"",
     states: ['Punjab', 'KPK', 'Balochistan', 'Sindh'],
     plants:["plant 1","plant 2","plant 3" ,"plant 4","plant 5"]
    }),
    components:{},
    created(){
     
    },
    methods:{
    }
  }
</script>
<style scoped>
.btn-create {
  background-color:  #464646 !important;
  color:#fff;
  min-width:230px !important;
  border-radius: 8px !important;
  cursor: pointer;
}
</style>