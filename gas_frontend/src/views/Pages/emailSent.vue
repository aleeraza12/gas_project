<template>
  <div>
      <EmailSent />
  </div>
</template>
<script>
export default {
  data: () => ({
   
  }),
  components:{
    EmailSent :()=>import("../../components/Auth/emailSent.vue")
  },
  mounted() {
    
  },
  methods: {
  }
};
</script>
