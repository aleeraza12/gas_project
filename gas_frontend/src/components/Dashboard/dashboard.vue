<template>
<div class="main-container">
  <v-card class="dashboard-card pa-0 elevation-0">
    <v-card-text>
      <div class="d-flex top-bar pt-2">
        <div class="ml-2">
          <v-text-field
            placeholder="search..."
            outlined
            dense
            prepend-inner-icon="mdi-magnify"
            hide-details
            class="searchbar"
          ></v-text-field>
        </div>
        <v-spacer></v-spacer>
        <div class="mr-5 mt-2">
          <v-icon> mdi-bell-outline</v-icon>
        </div>
      </div>
      <div class="d-flex mt-5">
        <div>
         <b> Welcome Ola,</b>
        </div>
        <v-spacer></v-spacer>
        <div>
          <div>Current gas price</div>
          <div> <b>N1 300</b></div>
           <div>Monday 4th, April 2022</div>
        </div>
      </div>
      <div class="d-flex mt-5">
        <div>
          <v-card height="120" width="250"  style="background-color:#EBEBEA">
            <v-card-text>
              <div class="d-flex">
                <div>
                  <div class="d-flex align-start justify-start"><b>600 Kg</b></div>
                  <div  class="d-flex align-start justify-start">NA 000000000000000</div>
                </div>
                <v-spacer></v-spacer>
                <div  class="d-flex align-end justify-end">
                  <v-icon>mdi-image</v-icon>
                </div>
              </div>
              <div  class="d-flex align-start justify-start mt-5">
                <b>Total Available Gas</b>
              </div>
            </v-card-text>
          </v-card>
        </div>
        <div>
          <v-card height="120" width="250" class="ml-5"  style="background-color:#EBEBEA">
            <v-card-text>
              <div class="d-flex">
                <div>
                  <div class="d-flex align-start justify-start"><b>124</b></div>
                  <div  class="d-flex align-start justify-start">3 New Customers</div>
                </div>
                <v-spacer></v-spacer>
                <div  class="d-flex align-end justify-end">
                  <v-icon>mdi-image</v-icon>
                </div>
              </div>
              <div  class="d-flex align-start justify-start mt-5">
                <b>Total Customers</b>
              </div>
            </v-card-text>
          </v-card>
        </div>
          <div>
          <v-card height="120" width="250" class="ml-5" style="background-color:#EBEBEA">
            <v-card-text>
              <div class="d-flex">
                <div>
                  <div class="d-flex align-start justify-start"><b>124,00000000</b></div>
                  <div  class="d-flex align-start justify-start">45 New Connections</div>
                </div>
                <v-spacer></v-spacer>
                <div  class="d-flex align-end justify-end">
                  <v-icon>mdi-image</v-icon>
                </div>
              </div>
              <div  class="d-flex align-start justify-start mt-5">
                <b>Total Sales</b>
              </div>
            </v-card-text>
          </v-card>
        </div>
      </div>
    </v-card-text>
  </v-card>
</div>
</template>

<script>

  export default {
    data: () => ({

    }),
    components:{},
    created(){
     
    },
    methods:{
     
    }
  }
</script>
<style scoped>
.dashboard-card{
  height:600px;
 
  border-radius: 0px !important;
}
.top-bar{
  background-color: #EBEBEA;
  height: 55px;
  width: 930px;
  border-radius: 20px;
}
.searchbar{
  border-radius: 10px;
  background-color: white !important;
   width: 500px;
}
</style>