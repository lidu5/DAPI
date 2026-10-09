<template>
    <div class="dashboard-editor-container">
        <el-col :span="24" class="section-title-container">
            <h2 class="section-title">Project Analytics</h2>
            <p class = "text">Explore real-time data and insights on the current state of Digital Health Solutions (DHS) in Ethiopia, highlighting the progress, challenges, and impact of technology in transforming healthcare across the nation.</p>
    </el-col>
      <panel-group />
  
      <el-row :gutter="32">
        <el-col :xs="24" :sm="24" :md="24" :lg="12">
          <div class="chart-wrapper">
            <e-h-a-components-projects-count/>
          </div>
        </el-col>
        <el-col :xs="24" :sm="24" :md="24" :lg="12">
          <div class="chart-wrapper">
            <regional-projects-count />
          </div>
        </el-col>      
      </el-row>
      <el-row :gutter="32">
        <el-col :xs="24" :sm="24" :md="24" :lg="12">
          <div class="chart-wrapper">
            <top-lead-organizations/>
          </div>
        </el-col>
        <el-col :xs="24" :sm="24" :md="24" :lg="12">
          <div class="chart-wrapper">
            <top-partners/>
          </div>
        </el-col>
      </el-row>
      <el-row>
        <el-col :xs="24" :sm="24" :md="24" :lg="12">
          <div class="chart-wrapper">
            <top-focus-areas/>
          </div>
        </el-col>
        <el-col :xs="24" :sm="24" :md="24" :lg="12">
        <div class="chart-wrapper">
          <projects-by-DHI />
        </div>
      </el-col>
      </el-row>
      <el-row>
      <el-col :xs="24" :sm="24" :md="24" :lg="12">
        <div class="chart-wrapper">
          <top-challenges/>
        </div>
      </el-col>
      <el-col :xs="24" :sm="24" :md="24" :lg="12">
        <div class="chart-wrapper">
          <projects-by-status/>
        </div>
      </el-col>
      </el-row>
      <el-row>
      <el-col :xs="24" :sm="24" :md="24" :lg="12">
        <div class="chart-wrapper">
          <projects-by-license/>
        </div>
      </el-col>
      <el-col :xs="24" :sm="24" :md="24" :lg="12">
        <div class="chart-wrapper">
          <projects-by-implementation/>
        </div>
      </el-col>
    </el-row>
    </div>
  </template>
  
  <script>
  
  import { defineAsyncComponent } from 'vue'
  
  const PanelGroup = defineAsyncComponent(() => import('../../../home/components/MinimizedPanelGroup'))
  const TopLeadOrganizations = defineAsyncComponent(() => import('../../../home/components/TopLeadOrganizations'))
  const RegionalProjectsCount = defineAsyncComponent(() => import('../../../home/components/RegionalProjectsCount'))
  const TopChallenges = defineAsyncComponent(() => import('../../../home/components/TopChallenges'))
  const TopFocusAreas = defineAsyncComponent(() => import('../../../home/components/TopFocusAreas'))
  const EHAComponentsProjectsCount = defineAsyncComponent(() => import('../../../home/components/EHAComponentsProjectsCount'))
  const TopPartners = defineAsyncComponent(() => import('../../../home/components/TopPartners'))
  const ProjectsByStatus = defineAsyncComponent(() => import('../../../home/components/ProjectsByStatus'))
  const ProjectsByImplementation = defineAsyncComponent(() => import('../../../home/components/ProjectsByImplementation'))
  const ProjectsByLicense = defineAsyncComponent(() => import('../../../home/components/ProjectsByLicense.vue'))
  const ProjectsByDHI = defineAsyncComponent(() => import('../../../home/components/ProjectsByDHI.vue'))

  export default {
    name: 'DashboardAdmin',
    components: {
      PanelGroup,
      TopLeadOrganizations,
      RegionalProjectsCount,
      TopChallenges,
      TopFocusAreas,
      EHAComponentsProjectsCount,
      ProjectsByImplementation,
      ProjectsByStatus,
      TopPartners,
      ProjectsByDHI,
      ProjectsByLicense
    },
  };
  </script>
  
  <style rel="stylesheet/scss" lang="scss" scoped>
.dashboard-editor-container {
  display: flex;
  flex-direction: column;
  align-items: center; /* Center align all items horizontally */
  padding: 4%;
  background-color: white;

  .chart-wrapper {
    background: #fff;
    padding: 16px 16px 0;
    margin-bottom: 32px;
    width: 100%; 
    max-width: 600px; 
    text-align: center; 
    height: 100%;
  }
}

.el-row {
  width: 100%; 
  justify-content: center; 
}

.section-title-container {
  margin-bottom: 50px;
}

.section-title {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 20px;
    padding-bottom: 0;
    font-family: Georgia, 'Times New Roman', Times, serif;
    text-align: center;
}

.text {
  text-align: center;
  width: 80%;
  margin: auto;
  padding: 5px;
}
@media (max-width: 1100) {
    .text {
      width: 70%; 
    }
  }
</style>
