<template>
<div class="main-container">
  <v-card class="elevation-0">
    <v-card-text class="pa-0">
      <div class="d-flex">
           <div class="grey-side">
            <div style="position: absolute;">
              <img src="../../assets/images/sidePic.png"  width="650"/>
            </div>
            <div style="position:relative;margin-top:15rem" >
              <img src="../../assets/images/side2.png" />
            </div>
           
          </div>
        <div class="login-screen">
          <div  class="d-flex justify-start align-start mt-16" style="margin-left:5.5rem">
                <img src="../../assets/images/Message Sent.png" height="200" width="200"/>
          </div>
          <div class="sign-in-content  d-flex align-start justify-start">Password Reset Successful</div>
          <div class="sign-in-subcontent  d-flex align-start justify-start">You have successfully reset your password</div>
            <div class="mt-7 ml-16"> 
            <v-btn block large class="elevation-0 btn-login" @click="login()" dense >
             Login
            </v-btn>
          </div>
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
      email:""
    }),
    components:{},
    created(){
     
    },
    methods:{
      login(){
         this.$router.push({
           name:"Login"
         })
      }
    }
  }
</script>
<style scoped>
.grey-side{
  width: 746px;
  left: 0px;
  top: 0px;
  border-radius: 0px;

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
  height: 250px;
  width: 300px;
  background-color:  #D2D2D2;
  margin-top:4rem;
  margin-left:4rem
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
}
.btn-login {
  background-color: #2E3995 !important;
  color: #fff;
  min-width: 200px !important;
  cursor: pointer;
   border-radius: 20px !important;
  margin-left: 3rem;
}
.resend-text{
  margin-left:4.5rem;
  cursor: pointer;
}
</style>