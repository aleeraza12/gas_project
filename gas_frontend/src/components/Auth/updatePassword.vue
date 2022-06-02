<template>
<div class="main-container">
  <v-card>
    <v-card-text class="pa-0">
      <div class="d-flex">
        <div class="grey-side">
        </div>
        <div class="login-screen">
          <div class="sign-in-content d-flex align-start justify-start">Update Password</div>
          <div class="sign-in-subcontent  d-flex align-start justify-start">Create a new password for your account</div>
          <v-form v-model="valid">

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
            class="password-feild mt-3 ml-16"
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
            class="password-feild mt-3 ml-16"
            v-model="confirm_password"
          ></v-text-field>
          </div>
          <div class="mt-10 ml-16"> 
            <v-btn block large class="elevation-0 btn-login" @click="updatePassword()" dense >
             Reset Password 
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
     password:"",
     confirm_password:"",
    }),
    components:{},
    created(){
     
    },
    methods:{
      updatePassword(){
        this.$router.push({
          name:"Reset Message"
        })
      }
    }
  }
</script>
<style scoped>
.grey-side{
  height: 100vh;
  width: 746px;
  left: 0px;
  top: 0px;
  border-radius: 0px;
  background-color: #EBEBEA;

}
.login-screen{
  height: 100vh;
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
  margin-left:15rem
}
.sub-content-welcome{
  font-weight: 300;
  font-size:14px;
  color:black;
  margin-top:0.5rem;
  margin-left:13rem
}
.sign-in-content{
 font-weight: 600;
 font-size:18px;
 color:black;
 margin-top:6rem;
 margin-left: 4.5rem;
}
.sign-in-subcontent {
 font-weight: 400;
 font-size:14px;
 color:black;
 margin-top:1rem;
 margin-left: 4.5rem;
}
.username-feild{
  width: 400px;
  border-color: #D6D6D6;
  border-radius: 8px;
}
.password-feild{
  width: 400px;
  border-color: #D6D6D6;
  border-radius: 8px;
}
.forget-passowrd{
  font-size: 12px;
  color:black;
  font-weight: 500;
  margin-left:23rem;
  cursor:pointer
}
.btn-login {
  background-color: #464646 !important;
  color:#fff;
  min-width:400px !important;
  border-radius: 8px !important;
  cursor: pointer;
}
</style>