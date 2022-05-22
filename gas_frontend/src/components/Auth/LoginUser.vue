<template>
<div class="main-container">
  <v-card>
    <v-card-text>
      <div class="d-flex">
        <div class="grey-side">
          <div class="inner-box">
             
          </div>
          <div class="content-welcome">Welcome Back! </div>
          <div class="sub-content-welcome">Sign in to access your dashboard</div>
        </div>
        <div class="login-screen">
          <div class="sign-in-content">Sign In</div>
          <div class="sign-in-subcontent">Enter your username and password</div>
          <v-form v-model="valid">
          <div>
            <v-text-field
            label="Username"
            outlined
            dense
            placeholder="Username"
            hide-details
            class="username-feild mt-6 ml-16"
            v-model="username"
          ></v-text-field>
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
            class="password-feild mt-3 ml-16"
            v-model="password"
          ></v-text-field>
          </div>
          <div class="forget-passowrd  mt-3" @click="forgetPassword()">Forgot Password?</div>
          <div class="mt-10 ml-16"> 
            <v-btn block large class="elevation-0 btn-login" @click="login()" dense >
              Sign In
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
     username:"",
     password:"",
    }),
    components:{},
    created(){
     
    },
    methods:{
      forgetPassword(){
        this.$router.push({
          name:"PasswordRecover"
        })
      }
    }
  }
</script>
<style scoped>
.grey-side{
  height: 630px;
  width: 746px;
  left: 0px;
  top: 0px;
  border-radius: 0px;
  background-color: #EBEBEA;

}
.login-screen{
  height: 630px;
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
  background-color: black !important;
  color:#fff;
  min-width:400px !important;
  border-radius: 8px !important;
  cursor: pointer;
}
</style>