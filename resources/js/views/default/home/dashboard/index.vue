<template>
    <div id="dashboard" class="full-page-container">
       <div class="">
        <Dashboard />
      </div>
    </div>
</template>
<script>
  import Dashboard from '../components/Dashboard.vue';

  export default {
    name: 'Dashboard Page',
    components: {
      Dashboard,
    }
  };
</script>
  
<style scoped>
.full-page-container {
  scroll-behavior: smooth; 
  display: flex;
  flex-direction: column; 
  width: 100%;
  
}

</style>