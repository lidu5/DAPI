<template>
    <div class="full-page-container">
        <Hero />
        <About />
        <Roadmap />
    </div>
  </template>
  
  <script>
  import Hero from './components/Hero.vue';
  import Roadmap from './components/Roadmap.vue';
  import Dashboard from './components/Dashboard.vue';
  import About from './components/About.vue';

  export default {
    name: 'HomePage',
    components: {
      Hero,
      Roadmap,
      About,
      Dashboard,
    }
  };
  </script>
  
  <style scoped>
  .full-page-container {
    display: flex;
    flex-direction: column;
    width: 100%;
    overflow-x: hidden;
  }
  
  * {
    box-sizing: border-box; 
  }
  
  </style>
  