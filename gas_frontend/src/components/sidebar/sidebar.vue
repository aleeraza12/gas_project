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
          <v-list-item
            v-for="item in items"
            :key="item.title"
            link
            @click.stop="mini = !mini"
            class="sidebar-item"
          >
            <v-list-item-icon>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item-content>
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
      items: [
        { title: 'Home', icon: 'mdi-home-city' },
        { title: 'My Account', icon: 'mdi-account' },
        { title: 'Users', icon: 'mdi-account-group-outline' },
      ],
      mini: false,
    }),
    components:{},
    created(){
     
    },
    methods:{
     
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