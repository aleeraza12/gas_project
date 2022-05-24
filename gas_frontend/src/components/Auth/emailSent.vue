<template>
<div class="main-container">
  <v-card>
    <v-card-text class="pa-0">
      <div class="d-flex">
        <div class="grey-side">
        </div>
        <div class="login-screen">
          <div class="inner-box">
             
          </div>
          <div class="sign-in-content">Recovery Email Sent</div>
          <div class="sign-in-subcontent">Kindly check your email for the password reset link that has been sent to you</div>
           <div class="mt-5 resend-text" @click="resend()">Didn’t receive any email? <b>Resend</b></div>
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
      resend(){
         this.$router.push({
           name:"PasswordRecover"
         })
      }
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
.login-screen{
  height: 600px;
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
 margin-top:3rem;
 margin-left: 2.5rem;
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
  background-color: #464646 !important;
  color:#fff;
  min-width:400px !important;
  border-radius: 8px !important;
  cursor: pointer;
}
.resend-text{
  margin-left:4.5rem;
  cursor: pointer;
}
</style>