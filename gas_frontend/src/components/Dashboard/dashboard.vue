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