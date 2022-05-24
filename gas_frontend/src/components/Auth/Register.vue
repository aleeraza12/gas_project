<template>
<div class="main-container">
  <v-card class="elevation-0">
    <v-card-text class="pa-0">
      <div class="d-flex">
        <div class="grey-side">
          <div class="inner-box">
             
          </div>
          <div class="content-welcome d-flex align-start justify-start">Hello! </div>
          <div class="sub-content-welcome  d-flex align-start justify-start">Welcome to GAS360 where you are guaranteed <br/> access to clean cooking LPG fuel</div>
        </div>
        <div class="create-screen">
          <div class="sign-in-content  d-flex align-start justify-start">Welcome</div>
          <div class="sign-in-subcontent  d-flex align-start justify-start">Create your account to  get started</div>
          <v-form v-model="valid">
          <div>
            <v-text-field
            label="Owners Full Name"
            outlined
            dense
            placeholder="Owners Full Name"
            hide-details
            class="username-feild mt-2 ml-16"
            v-model="owners_name"
          ></v-text-field>
          </div>
          <div>
            <v-text-field
            label="Company Name"
            outlined
            dense
            placeholder="Company Name"
            hide-details
            class="username-feild mt-2 ml-16"
            v-model="company_name"
          ></v-text-field>
          </div>
          <div>
            <v-text-field
            label="Email Address"
            outlined
            dense
            placeholder="Email Address"
            hide-details
            class="username-feild mt-2 ml-16"
            v-model="email_address"
          ></v-text-field>
          </div>
          <div>
            <v-text-field
            label="Phone Number"
            outlined
            dense
            placeholder="Phone Number"
            hide-details
            class="username-feild mt-2 ml-16"
            v-model="phone_number"
          ></v-text-field>
          </div>
          <div>
            <v-text-field
            label="Address"
            outlined
            dense
            placeholder="Address"
            hide-details
            class="username-feild mt-2 ml-16"
            v-model="address"
          ></v-text-field>
          </div>
          <div class="d-flex">
            <div>
              <v-text-field
                label="City"
                outlined
                dense
                placeholder="City"
                hide-details
                class="city-feild mt-2 ml-16"
                v-model="city"
              ></v-text-field>
            </div>
            <div class="mt-2 ml-2">
             <v-select
                :items="states"
                label="State"
                outlined
                dense
              ></v-select>
            </div>
          </div>
          <div class="ml-16 mt-0" style="width:410px ;position:absolute">
             <v-select
                :items="plants"
                label="Select Plants"
                outlined
                dense
                small 
              ></v-select>
          </div>
           <div>
            <v-text-field
            outlined
            :append-icon="show ? 'mdi-eye-outline' : 'mdi-eye-off-outline'"
            :type="show ? 'text' : 'password'"
            @click:append="show = !show"
            label="Password"
            dense
            placeholder="Password"
            hide-details
            class="password-feild mt-13 ml-16"
            v-model="password"
          ></v-text-field>
          </div>
           <div>
            <v-text-field
            outlined
            :append-icon="show1 ? 'mdi-eye-outline' : 'mdi-eye-off-outline'"
            :type="show1 ? 'text' : 'confirm_password'"
            @click:append="show1 = !show1"
            label="Confirm Password"
            dense
            placeholder="Confirm Password"
            hide-details
            class="password-feild mt-2 ml-16"
            v-model="confirm_password"
          ></v-text-field>
          </div>
          <div class="mt-5 ml-16"> 
            <v-btn block large class="elevation-0 btn-create" @click="createAccount()" dense >
             Create Account
            </v-btn>
          </div>
          </v-form>
        </div>
      </div>
    </v-card-text>
  </v-card>
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
.grey-side{
  height: 600px;
  width: 746px;
  left: 0px;
  top: 0px;
  border-radius: 0px;
  background-color: #EBEBEA;

}
.create-screen{
  height: 600px;
  width: 746px;
  left: 0px;
  top: 0px;
  border-radius: 0px;
  background-color: #fff;
}
.inner-box{
  height: 300px;
  width: 300px;
  background-color:  #D2D2D2;
  margin-top:6rem;
  margin-left:10rem
}
.content-welcome{
  font-weight: 600;
  font-size:18px;
  color:black;
   margin-top:2rem;
  margin-left:18rem
}
.sub-content-welcome{
  font-weight: 300;
  font-size:14px;
  color:black;
  margin-top:0.5rem;
  margin-left:10rem
}
.sign-in-content{
 font-weight: 600;
 font-size:16px;
 color:black;
 margin-top:1rem;
 margin-left: 4.5rem;
}
.sign-in-subcontent {
 font-weight: 400;
 font-size:12px;
 color:black;
 margin-top:0.5rem;
 margin-left: 4.5rem;
}
.username-feild{
  width: 400px;
  border-color: #D6D6D6;
  border-radius: 8px;
}
.city-feild {
    width: 150px;
  border-color: #D6D6D6;
  border-radius: 8px;
}
.password-feild{
  width: 400px;
  border-color: #D6D6D6;
  border-radius: 8px;
}
.btn-create {
  background-color: black !important;
  color:#fff;
  min-width:400px !important;
  border-radius: 8px !important;
  cursor: pointer;
}
</style>