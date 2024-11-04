<template>
    <Navbar />
    <router-view></router-view>
</template>
  
  <script>
  import Register from './Register.vue';
  import Login from './Login.vue';
  import Navbar from './Navbar.vue';
  import Titels from './Titels.vue';
  import TitelDetail from './TitelDetail.vue';
  import User from './User.vue';
  import { slider, slideritem } from 'vue-concise-slider';
  
  export default {
    components: {
      Register,
      Login,
      Navbar,
      Titels,
      TitelDetail,
      User,
      slider,
      slideritem,
    },
  };
  </script>
  