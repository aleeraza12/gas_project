<template>
    <div class="main-container">
        <div class="d-flex align-start justify-start">
           <v-icon>mdi-chevron-left</v-icon> <span>Back</span>
        </div>
        <div class="mt-3">
            <div class="d-flex align-start justify-start"> <b>Add New User</b></div>
            <div  class="d-flex align-start justify-start fonts mt-1">Enter the following details to create a user profile</div>
            <v-form v-model="valid" class="mt-5">
                <div>
                    <v-text-field
                        v-model="created_by"
                        label="Created By"
                        outlined
                        dense
                        hide-details
                        class="mt-1"
                        style="width:200px"
                    ></v-text-field>
                </div>
                <div>
                    <v-text-field
                        v-model="username"
                        label="User Name"
                        outlined
                        dense
                        hide-details
                        class="mt-1"
                        style="width:200px"
                    ></v-text-field>
                </div>
            </v-form>
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