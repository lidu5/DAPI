<template>
  <el-row class="roadmap-section" justify="center" :gutter="30">
    <el-col :span="24" class="section-title-container">
      <h2 class="section-title">Getting Started?</h2>
      <p>Here's what you have to do</p>
    </el-col>

    <el-col :span="6" :xs="{ span: 24 }">
      <div class="feature-card">
        <div class="step-number">1</div>
        <img src="@/assets/home/add-user.png" alt="Create an Account">
        <h3>Create an Account</h3>
        <p>Register for an implementor account.</p>
      </div>
    </el-col>

    <el-col :span="6" :xs="{ span: 24 }">
      <div class="feature-card">
        <div class="step-number">2</div>
        <img src="@/assets/home/new-project.png" alt="Add Project">
        <h3>Add Project</h3>
        <p>Add your project and request certification.</p>
      </div>
    </el-col>

    <el-col :span="6" :xs="{ span: 24 }">
      <div class="feature-card">
        <div class="step-number">3</div>
        <img src="@/assets/home/quality.png" alt="Get Certified">
        <h3>Get Certified</h3>
        <p>Get QA assessment and get certified.</p>
      </div>
    </el-col>
  </el-row>
</template>

<script>
export default {
  name: 'Roadmap',
};
</script>

<style scoped>
.roadmap-section {
  padding: 60px 0;
  background-color: #fff;
  text-align: center;
}

.section-title-container {
  margin-bottom: 50px;
}

.section-title {
  font-size: 36px;
  font-weight: bold;
  color: #333;
  margin: 0;
  text-align: center;
}

.feature-card {
  position: relative;
  padding: 20px;
  background-color: #fff;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  margin-bottom: 30px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.feature-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
}

.step-number {
  position: absolute;
  top: -20px;
  left: 50%;
  transform: translateX(-50%);
  background-color: #11b5358c;
  color: #fff;
  width: 30px;
  height: 30px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  font-weight: bold;
}

.feature-card img {
  max-width: 100%;
  height: auto;
  margin-bottom: 15px;
}

.feature-card h3 {
  margin-top: 10px;
  font-size: 20px;
}

.feature-card p {
  font-size: 14px;
  color: #555;
}

@media (max-width: 768px) {
  .roadmap-section {
    padding: 30px 15px;
  }

  .section-title {
    font-size: 28px;
  }

  .section-title-container p {
    font-size: 16px;
  }

  .feature-card {
    margin-bottom: 20px;
    margin-left: 10px;
    margin-right: 10px;
  }
  
}
</style>
