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
         <b> Reconcilation</b>
        </div>
        
      </div>
      <div class="d-flex mt-5">
        <div>
          <v-card height="80" width="1000px"  style="background-color:#EBEBEA">
            <v-card-text>
              <div class="d-flex">
                <div>
                  <div class="d-flex align-start justify-start"><b>Total Reconcilation</b></div>
                  <div  class="d-flex align-start justify-start">78</div>
                </div>
                <v-spacer></v-spacer>
                <div  class="d-flex align-end justify-end">
                 <v-btn small dense outlined >View All <v-icon small dense  class="ml-2">mdi-eye-outline</v-icon></v-btn>
                </div>
              </div>
            </v-card-text>
          </v-card>
        </div>
      </div>
      <div class=" d-flex mt-3">
       <div><b>Reconcilation</b></div>
       <v-spacer></v-spacer>
       <div class="mr-3" style="border-bottom:1px solid grey">Export Csv</div>
       <div class="mr-3"><b>Date Picker</b></div>
      </div>
      <div class="mt-3">
        <v-data-table
          :headers="headers"
          :items="desserts"
          :items-per-page="5"
          class="elevation-1"
            hide-default-footer
            hide-default-header
          height="400px"
        >
          <template v-slot:[`body.prepend`]= "{headers}">
           <th v-for="(header , i) in headers" :key="i" class="table-head">
             <div class="d-flex ml-3">
                {{header.text}}
             </div>
           </th>
          
       </template>
        </v-data-table>
      </div>
    </v-card-text>
  </v-card>
</div>
</template>

<script>

  export default {
    data: () => ({
       headers: [
          {
            text: 'Date',
            align: 'start',
            sortable: false,
            value: 'name',
          },
          { text: 'Order Id', value: 'id' },
          { text: 'Customer Name', value: 'name' },
          { text: 'Gas Quantity', value: 'quantity' },
          { text: 'Amount', value: 'amount' },
          { text: 'Status', value: 'status' },
          { text: 'Update by', value: 'update_by' },
          { text: 'Payment Mode', value: 'payment' },
           { text: 'Views', value: 'actions' },
        ],
        desserts: [
          {
            date: '04 april 2022 01:32 am',
            id: '100',
            name: 'John',
            quantity: 6,
            amount: 2400,
            status: 'Paid',
            update_by:'abc',
            payment: 'cash',
          },
          {
            date: '04 april 2022 01:32 am',
            id: '101',
            name: 'John',
            quantity: 6,
            amount: 2400,
            status: 'Paid',
            update_by:'abc',
            payment: 'cash',
          },
          {
            date: '04 april 2022 01:32 am',
            id: '102',
            name: 'John',
            quantity: 6,
            amount: 2400,
            status: 'Paid',
            update_by:'abc',
            payment: 'cash',
          },
          {
            date: '04 april 2022 01:32 am',
            id: '103',
            name: 'John',
            quantity: 6,
            amount: 2400,
            status: 'Paid',
            update_by:'abc',
            payment: 'cash',
          },
          {
            date: '04 april 2022 01:32 am',
            id: '104',
            name: 'John',
            quantity: 6,
            amount: 2400,
            status: 'Paid',
            update_by:'abc',
            payment: 'cash',
          },
          {
            date: '04 april 2022 01:32 am',
            id: '105',
            name: 'John',
            quantity: 6,
            amount: 2400,
            status: 'Paid',
            update_by:'abc',
            payment: 'cash',
          },
          {
            date: '04 april 2022 01:32 am',
            id: '106',
            name: 'John',
            quantity: 6,
            amount: 2400,
            status: 'Paid',
            update_by:'abc',
            payment: 'cash',
          },
        ],
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
  border-radius: 20px;
}
.searchbar{
  border-radius: 10px;
  background-color: white !important;
   width: 500px;
}
.table-head{
  background-color: #EBEBEA;
  font-size: 12px;
  height: 50px;
}
</style>