<template>
    <div class="main-container">
        <v-card class="elevation-1">
            <v-card-text>
 <div class="sales-details-page">
          <div class="d-flex mt-3 pa-5">
              <div>
                  <v-icon class="ml-10 " size="80" color="#EBEBEA"> mdi-circle</v-icon>
              </div>
              <v-spacer></v-spacer>
              <div class="mr-5">
                  <div><b>LIT Engineers</b></div>
                  <div class="fonts"><b>18,chokar town auto street 19</b></div>
                  <div class="fonts">015980000045</div>
              </div>
          </div>
          <div  ><b>Sales Recepit</b></div>
          <v-divider></v-divider>
          <div class="d-flex align-start justify-start ml-5" style="font-size:16px;font-weight:600">Customer Details</div>
          <div class="d-flex">
              <div class="ml-5 mt-3">
                 <div class="d-flex align-start justify-start fonts">distributor</div>
                 <div  class="d-flex align-start justify-start"><b>Ola Adlyan</b></div>
                 <div  class="d-flex align-start justify-start fonst">04566000433</div>
                 <div  class="d-flex align-start justify-start fonts">office no abc , nowrelad activty sometec howdy</div>
              </div>
              <v-spacer></v-spacer>
               <div class="mr-8 mt-3">
                 <div class="fonts">Transcation Id</div>
                 <div class="fonts">000000000000</div>
                  <div class="fonts">25,april 2002</div>
              </div>
          </div>
         
          <div class="d-flex" style="background-color:#EBEBEA">
              <div class="ml-5 mt-3">
                  <div class="d-flex">
                     <div class="fonts"><b>Payment Mthod:</b></div>
                     <div class="fonts">Cash</div>
                  </div>
              </div>
              <v-spacer></v-spacer>
               <div class="mr-8 mt-3">
                 <div class="fonts">Amount Paid</div>
                 <div class="fonts">4500090</div>
              </div>
          </div>
         <div class="mt-3">
              <v-simple-table >
    <template v-slot:default>
      <thead style="background-color:#464646">
        <tr>
            <th class="text-left" style="color:#fff;font-size:12px">
            #
          </th>
          <th class="text-left" style="color:#fff;font-size:12px">
            Gas Quantity (kg)
          </th>
          <th class="text-left" style="color:#fff;font-size:12px">
           Unit Price(N)
          </th>
<th class="text-left" style="color:#fff;font-size:12px">
           Amount(N)
          </th>

        </tr>
      </thead>
      <tbody>
        <tr
          v-for="item in desserts"
          :key="item.name"
        >
          <td>{{ item.id }}</td>
          <td>{{ item.quantity }}</td>
           <td>{{ item.unit }}</td>
            <td>{{ item.amount }}</td>
        </tr>
      </tbody>
    </template>
  </v-simple-table>
         </div>
         <v-divider></v-divider>
         <div class="mt-3">
            <div class="d-flex" style="backgorund-color:#F6F6F5">
             <div>Total Amount</div>
             <div class="ml-5">5000000</div>
            </div>
            <div class="d-flex"  style="backgorund-color:#EBEBEA">
             <div>Amount Paid</div>
             <div class="ml-5">NA 5000000</div>
            </div>
             <div class="d-flex"  style="backgorund-color:#F6F6F5">
             <div>Balance</div>
             <div class="ml-12">No</div>
            </div>
         </div>
         <div class="d-flex align-center justify-center"><b>Powered By GA3QSD</b></div>
         <div class="d-flex align-center justify-center mt-3"><v-btn small dense style="  background-color: black !important;
  color: #fff;

  cursor: pointer;">Print</v-btn></div>

        </div>
            </v-card-text>
        </v-card>
       
    </div>
</template>
<script>
  export default {
    data () {
      return {
        desserts: [
          {
            id: 1,
            quantity: 19,
            unit:1500,
            amount:1450000
          },
         
     
        ],
      }
    },
  }
</script>
<style scoped>
.sales-details-page{

}
.fonts{
    font-size:12px;
}
</style>