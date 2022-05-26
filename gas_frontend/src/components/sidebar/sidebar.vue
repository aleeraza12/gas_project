<template>
  <div>
    <v-card class="sidebar-card elevation-0" >
      <v-navigation-drawer
        v-model="drawer"
        :mini-variant.sync="mini"
        permanent
        class="navaigation-side"
      >
        <v-list-item class="d-flex align-center justify-center ma-2">
          <v-list-item-avatar>
            <v-img src="https://randomuser.me/api/portraits/men/85.jpg"></v-img>
          </v-list-item-avatar> 
        </v-list-item>
        <v-divider></v-divider>
        <v-list dense>
          <v-list-item class="d-flex align-center pl-4 sidebar-item"
          v-for="(link , i ) in links" :key="i" router 
          @click.stop="mini = !mini"
         :to="link.route"
        >
         <!-- sidebar icons -->
         <div :id="link.icon">
           <v-icon class="mr-7 py-4" :color="link.color" v-text="link.icon" size="25"></v-icon>
         </div>
         <v-tooltip content-class="arrow-left"
         nudge-right="1" right color="#ffe7b8"
         >
         <span class="black--text"> {{link.text}} </span>
         </v-tooltip>
         <!--sidebar text -->
         <div>
           <span class="text-capitalize body-2 font-weight-bold">
              {{link.text}}         
           </span>
         </div>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
  </v-card>
  </div>
</template>
<script>

  export default {
    data: () => ({
      drawer: true,
      titleName:"",
     links: [
          { text: 'Dashboard', icon: 'mdi-view-dashboard', route:'/dashboard' ,tabName : "Dashboard" , color:"black" },
          { text: 'Orders', icon: 'mdi-folder', route:'/orders' ,tabName : "Orders" , color:"black" },
           { text: 'Sales', icon: 'mdi-folder', route:'/sales' ,tabName : "Sales" , color:"black" },
            { text: 'Settings', icon: 'mdi-folder', route:'/settings' ,tabName : "Settings" , color:"black" },
        ],
      mini: false,
    }),
    components:{},
    created(){
     
    },
    methods:{
        getColor(link,titleName,index){
        titleName == link.tabName ? (this.links[index].color = '#215549') : (this.links[index].color = 'black' );
      },
    }
  }
</script>
<style scoped>
.sidebar-card{
    height:600px;
    border-radius:0px !important
}
.navaigation-side{
background-color:#EBEBEA !important;
}
.sidebar-item:hover{
  background-color: #fff;
}
</style>