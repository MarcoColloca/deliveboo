<script>
  import AppHeader from './components/AppHeader.vue';
  import AppFooter from './components/AppFooter.vue';
  import AppMain from './components/AppMain.vue';
  import { RouterView } from 'vue-router';
  import {watch} from 'vue';
  import {store, initializeStore} from './store.js'

  export default{
    components:{
      AppHeader,
      AppMain,
      AppFooter,
    },

    data(){
      return{
        test: 'Hello!',
      }
    },
    created(){
      initializeStore(watch);
      return {
        store
      }
    }
  }
</script>




<template>
  <AppHeader></AppHeader>

  <AppMain>
  </AppMain>

  <AppFooter></AppFooter>
</template>




<style lang="scss">
</style>
