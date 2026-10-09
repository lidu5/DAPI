<template>
    <div class="hero-section" justify="center">
      <div :span="12" class="hero-text">
        <h1 class="hero-title">{{ title }}</h1>
        <p class="hero-subtitle">{{ subtitle }}</p>
        <el-button class="hero-button" @click="goToPage('/projects/explore')">Browse Projects</el-button>
      </div>
      <div :span="12" class="hero-image">
        <img src="@/assets/home/Digiculture_monitor_mockup.png" alt="Digital Agriculture Image" />
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'Hero',
    data() {
      return {
        title: 'Digital Agriculture Project Inventory',
        subtitle: 'A digital clearinghouse and certification platform.',
        imageSrc: require('@/assets/home/Digiculture_monitor_mockup.png')
      };
    },
    methods: {
      goToPage(path) {
        this.$router.push(path);
      }
    }
  };
  </script>
  
  <style scoped>
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @keyframes fadeInRight {
    from {
      opacity: 0;
      transform: translateX(50px);
    }
    to {
      opacity: 1;
      transform: translateX(0);
    }
  }

  @keyframes pulse-glow {
    0%, 100% {
      box-shadow: 0 0 20px rgba(181, 167, 17, 0.5);
    }
    50% {
      box-shadow: 0 0 30px rgba(181, 167, 17, 0.8);
    }
  }

  .hero-section {
  background: rgb(2, 0, 36);
  background: linear-gradient(218deg, rgb(4, 63, 31) 3%, rgb(6, 79, 34) 12%, rgb(7, 102, 36) 24%, rgb(11, 68, 49) 54%, rgb(21, 116, 69) 67%, rgb(6, 85, 28) 84%, rgb(7, 81, 44) 94%);
  color: white;
  padding: 40px;
  text-align: left;
  height: 100vh;
  font-family: Georgia, serif;
  align-items: center;
  justify-content: center;
  display: flex;
  position: relative;
}

.hero-text {
  padding: 20px;
  position: relative;
  z-index: 2;
  animation: fadeInUp 0.8s ease-out;
}

.hero-title {
  font-size: 3.25rem;
  margin-bottom: 20px;
  animation: fadeInUp 0.8s ease-out 0.2s both;
}


.hero-subtitle {
  font-size: 1.5rem;
  margin-bottom: 30px;
  color:#b5a711;
  font-weight: bold;
  animation: fadeInUp 0.8s ease-out 0.4s both;
}

.hero-image {
  animation: fadeInRight 0.8s ease-out 0.6s both;
}

.hero-image img {
  margin-top: 10px;
  max-width: 100%;
  height: auto;
   position: relative;
  z-index: 2;
}

.hero-button {
  width: 200px; 
  height: auto;
  font-size: 20px; 
  padding: 20px 40px;
  background-color: #b5a711;
  color: white;
  border: 1px solid #b5a711;
  border-radius: 15px;
  margin-top: 6px;
  animation: fadeInUp 0.8s ease-out 0.6s both;
  transition: all 0.3s ease;
  cursor: pointer;
}

.hero-button:hover {
  transform: translateY(-3px);
  animation: pulse-glow 1.5s ease-in-out infinite;
}
@media (max-width: 768px) {
  .hero-section {
    flex-direction: column-reverse;
    justify-content: flex-start; 
  }

  .hero-text {
    text-align: center;
    padding: 20px;
  }

  .hero-title {
    font-size: 2.5rem; 
  }

  .hero-subtitle {
    font-size: 1.25rem; 
  }

  .hero-button {
    width: 100%; 
    font-size: 18px; 
  }

  .hero-image img {
    max-width: 90%; 
    margin-top: 30px; 
  }

  .hero-image {
    margin-top: 40px;
  }
}
  </style>
  