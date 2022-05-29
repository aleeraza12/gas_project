<template>
    <div class="main-container">
        <div class="d-flex align-start justify-start">
           <v-icon>mdi-chevron-left</v-icon> <span>Back</span>
        </div>
        <div class="d-flex align-center justify-center mt-3">
             <div>
                 <img height="300px" width="300px" src="../../assets/images/no-data.png"/>
                 <div class="fonts"> Sorry, you have not yet created any sales <br>
Kindly create sales to begin</div>
<div class="mt-5 ml-16">
                <v-btn
                 small
                 dense
                  class="elevation-0 btn-create"
                  :loading="loading"
                
                  @click="createAccount()"
                >
                  Create New Sale
                </v-btn>
              </div>
             </div>
        </div>
    </div>
</template>
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