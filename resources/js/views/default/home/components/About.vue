<template>
    <div class="slideshow-container">
        <h1 class="title">About Us</h1>
      <div v-show="currentSlide === 1" class="section problem-section">
        <div class="text" v-show="currentSlide === 1" @transitionend="textTransitionEnd">
          <h2 class="fade-in header">The Challenges in Digital Agriculture Implementation</h2>
          <p class="fade-in content">The Ministry of Agriculture of Ethiopia (MoA) faces significant challenges in efficiently managing the growing number of digital agriculture solutions across the country. These solutions vary in scale, focus, and interventions, making it increasingly difficult to coordinate efforts, track costs, and measure their impact effectively.</p>
        </div>
        <div class="image fade-in" v-show="currentSlide === 1">
        <img src="@/assets/home/moa_challenge.jpg" alt="Digital Agriculture Systems" />
        </div>
      </div>
  
      <div v-show="currentSlide === 2" class="section solution-section">
        <div class="image fade-in" v-show="currentSlide === 2">
          <img src="@/assets/home/moa_qa.png" alt="Digital Agriculture System" />
        </div>
        <div class="text" v-show="currentSlide === 2" @transitionend="textTransitionEnd">
          <h2 class="fade-in header">Introducing the Digital Agriculture Projects Inventory System</h2>
          <p class="fade-in content">To address these challenges, the MoA has developed the Digital Agriculture Projects Inventory System. This automated platform streamlines the registration, validation, and certification of digital Agriculture solutions, enabling better coordination, informed decision-making, and insightful visualizations of the digital Agriculture landscape.</p>
        </div>
      </div>
  
      <div class="nav-buttons">
        <button @click="prevSlide" class="nav-button prev-button"><el-icon><ArrowLeftBold /></el-icon></button>
        <button @click="nextSlide" class="nav-button next-button"><el-icon><ArrowRightBold /></el-icon></button>
      </div>
    </div>

  </template>
  
<script>
export default {
  name: 'About',
  data() {
    return {
      currentSlide: 1,
    };
  },
  methods: {
    nextSlide() {
      if (this.currentSlide < 2) {
        this.currentSlide++;
      } else {
        this.currentSlide = 1; 
      }
    },
    prevSlide() {
      if (this.currentSlide > 1) {
        this.currentSlide--;
      } else {
        this.currentSlide = 2; 
      }
    },
    textTransitionEnd(event) {
      event.target.classList.add('transitioned');
    },
  },
  mounted() {
    setInterval(this.nextSlide, 5000);
  },
};
</script>  
<style scoped>
.slideshow-container {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  overflow: hidden;
  position: relative;
  margin: 0;
  padding: 4% 12%;
}

.section {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: row;
  padding: 0 5%; 
}

.problem-section {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.solution-section {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.problem-section .image {
  flex: 1;
  text-align: center;
  margin-left: 20px;

}

.solution-section .image {
  flex: 1;
  text-align: center; 
  margin-right: 20px;
}

.problem-section .text,
.solution-section .text {
  flex: 1;
  text-align: left;
  align-self: center;;
}

.image img {
  object-fit: cover;
  border-radius: 18px 0 18px 0;
  align-self: left;  
  height: 350px; 
  width: 450px;

}

.fade-in {
  opacity: 0;
  animation: fadeIn 0.5s forwards;
}

@keyframes fadeIn {
  to {
    opacity: 1;
  }
}

.transitioned {
  opacity: 1;
}

.nav-button {
  background-color: transparent;
  color: #249907d2;
  border: none;
  font-size: 2rem;
  cursor: pointer;
  margin: 10px 0;
  transition: color 0.3s;
}

.nav-button:hover {
  color: #249907d2;
}

.next-button {
  position: absolute;
  top: 50%;
  right: 0;
  transform: translateY(-50%);
}

.prev-button {
  position: absolute;
  top: 50%;
  left: 0;
  transform: translateY(-50%);
}

.title {
  margin-top: 0px;
  margin-bottom: 50px;
  font-size: 44px;
  color: #333;
}

.header {
  font-size: 28px;
  font-family:Georgia, 'Times New Roman', Times, serif;
  color: #249907d2;
}

.content {
  font-size: 16px;
}

.custom-hr-container {
  text-align: center;
}

.custom-hr {
  border: none;
  height: 10px;
  width: 50%;
  margin: 20px auto;
  background: radial-gradient(circle, #00ff556bff 30%, transparent 30%) 0 0 / 20px 20px repeat-x;
}

@media (max-width: 768px) {
  .problem-section{
    flex-direction: column;
  }

  .solution-section {
    flex-direction: column-reverse; 
  }

  .problem-section .image,
  .solution-section .image {
    margin-bottom: 20px;
  }

  .problem-section .text,
  .solution-section .text {
    text-align: center; 
  }

  .image img {
    height: auto;
    width: 75%;
    max-width: 100%;
    border-radius: 18px 18px 0 0;
    margin:auto;
  }

  .title {
    font-size: 30px;
    margin-top: 20px;
  }

  .header {
    font-size: 24px;
  }

  .content {
    font-size: 14px;
    margin-bottom: 20px;
  }
}
</style>