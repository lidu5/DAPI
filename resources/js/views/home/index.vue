<template>
  <div class="dashboard-editor-container">
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

const EHAComponentsProjectsCount = defineAsyncComponent(() => import('./components/EHAComponentsProjectsCount'))
const RegionalProjectsCount = defineAsyncComponent(() => import('./components/RegionalProjectsCount'))
const PanelGroup = defineAsyncComponent(() => import('./components/PanelGroup'))
const TopLeadOrganizations = defineAsyncComponent(() => import('./components/TopLeadOrganizations'))
const TopFocusAreas = defineAsyncComponent(() => import('./components/TopFocusAreas'))
const TopChallenges = defineAsyncComponent(() => import('./components/TopChallenges'))
const ProjectsByStatus = defineAsyncComponent(() => import('./components/ProjectsByStatus'))
const TopPartners = defineAsyncComponent(() => import('./components/TopPartners'))
const ProjectsByImplementation = defineAsyncComponent(() => import('./components/ProjectsByImplementation'))
const ProjectsByLicense = defineAsyncComponent(() => import('./components/ProjectsByLicense.vue'))
const ProjectsByDHI = defineAsyncComponent(() => import('./components/ProjectsByDHI.vue'))


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
    ProjectsByLicense,
    ProjectsByDHI
  },
};
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.dashboard-editor-container {
  padding: 32px;
  background-color: white;
  .chart-wrapper {
    background: #fff;
    padding: 16px 16px 0;
    margin-bottom: 32px;
  }
}
</style>
