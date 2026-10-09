<template>
  <section class="project">
    <div class="content" v-if="project.id">
      <div class="section-title">
        <h2>{{ project.name }}</h2>
        <p>
          {{ project.summary }}
        </p>
      </div>
      <el-row :gutter="20">
        <el-col :xs="24" :sm="24" :md="20">
          <el-tabs v-model="activeName" :tab-position="computedTabPosition" class="demo-tabs">
            <el-tab-pane label="General" name="General">
              <GeneralView :project="project" :edit="false" :frontend="false"/>
            </el-tab-pane>
            <el-tab-pane label="Technologies" name="Technologies">
              <TechnologyView :project="project" :edit="false"/>
            </el-tab-pane>
            <el-tab-pane label="Interoperability and Standards" name="Interoperability and Standards">
              <InteroperabilityStandardView :project="project" :edit="false"/>
            </el-tab-pane>
            <el-tab-pane label="Implementations" name="Implementations">
              <ImplementationView :project="project" :edit="false"/>
            </el-tab-pane>
            <el-tab-pane label="Coverages" name="Coverages">
              <CoverageView :coverages="project.coverages" :id="project.id" :user_id="project.user_id" :edit="false"/>
            </el-tab-pane>
            <el-tab-pane label="Activities" name="Activities">
              <ActivityView :activities="project.activities" :id="project.id" :user_id="project.user_id" :edit="false"/>
            </el-tab-pane>
            <el-tab-pane label="Others" name="Others">
              <OtherView :project="project" :edit="false"/>
            </el-tab-pane>
          </el-tabs>
        </el-col>

        <div class="flex-wrapper">
        <el-col :xs="24" :sm="24" :md="4" v-if="project.certificates.length > 0">          <router-link :to="`/project/${project.uuid}/certificate`">
            <QRCodeVue3 :width="150" :height="150" :value="certificateUrl"
              :qrOptions="{ typeNumber: 0, mode: 'Byte', errorCorrectionLevel: 'H' }"
              :imageOptions="{ hideBackgroundDots: true, imageSize: 0.4, margin: 0 }" :dotsOptions="{
                type: 'extra-rounded',
                color: '#086ad4',
                gradient: null
              }" :backgroundOptions="{
                color: '#ffffff',
              }" image='data:image/png;base64,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'
                            :cornersSquareOptions="{ type: 'extra-rounded', color: '#0d0d0c' }" :cornersSquareOptionsHelper="{
                              colorType: {
                                single: true,
                                gradient: false
                              },
                              gradient: {
                                linear: true,
                                radial: false,
                                color1: '#000000',
                                color2: '#000000',
                                rotation: '0'
                              }
                            }" :cornersDotOptions="{ type: undefined, color: '#967008' }" :cornersDotOptionsHelper="{
                colorType: {
                  single: true,
                  gradient: false
                },
                gradient: {
                  linear: true,
                  radial: false,
                  color1: '#000000',
                  color2: '#000000',
                  rotation: '0'
                }
              }" :backgroundOptionsHelper="{
                colorType: {
                  single: true,
                  gradient: false
                },
                gradient: {
                  linear: true,
                  radial: false,
                  color1: '#ffffff',
                  color2: '#fffff',
                  rotation: '0'
                }
              }" />
          </router-link>
        </el-col>
        </div>
      </el-row>
    </div>
  </section>
</template>

<script>
import DHPI from "@/api/project";

import GeneralView from "@/views/home/project/components/View/GeneralView";
import InteroperabilityStandardView from "@/views/home/project/components/View/InteroperabilityStandardView";
import ImplementationView from "@/views/home/project/components/View/ImplementationView";
import CoverageView from "@/views/home/project/components/View/CoverageView";
import ActivityView from "@/views/home/project/components/View/ActivityView";
import OtherView from "@/views/home/project/components/View/OtherView";
import TechnologyView from "@/views/home/project/components/View/TechnologyView";

import QRCodeVue3 from "qrcode-vue3";

const dhpi = new DHPI();

export default {
  name: "Project Default View",
  data() {
    return {
      activeName: "General",
      project: {},
      loading: false,
      screenWidth: window.innerWidth
    };
  },
  computed: {
    certificateUrl() {
      return `${window.location.origin}/project/${this.project.uuid}/certificate`
    },
    computedTabPosition() {
      return this.screenWidth >= 992 ? 'left' : 'top';
    }
  },
  created() {
    const uuid = this.$route.params && this.$route.params.uuid;
    this.getProject(uuid);
  },
  mounted() {
    window.addEventListener('resize', this.updateScreenWidth);
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.updateScreenWidth);
  },
  methods: {
    async getProject(uuid) {
      this.loading = true;
      try {
        const { data } = await dhpi.getProjectWithUuid(uuid);
        this.project = data;
      } catch (err) {
        if (err.message == "Request failed with status code 404") {
          this.$router.push(`/404`);
        }
      }
      this.loading = false;
    },
    updateScreenWidth() {
      this.screenWidth = window.innerWidth;
    }
  },
  components: {
    GeneralView,
    InteroperabilityStandardView,
    ImplementationView,
    CoverageView,
    ActivityView,
    OtherView,
    TechnologyView,
    QRCodeVue3,
  },
};
</script>

<style scoped>
/*--------------------------------------------------------------
# Sections
--------------------------------------------------------------*/
section {
  overflow: hidden;
  padding: 60px 0;
}

/* Sections Header
--------------------------------*/
.section-header .section-title {
  font-size: 32px;
  color: #111;
  text-transform: uppercase;
  text-align: center;
  font-weight: 700;
  margin-bottom: 5px;
}

.section-header .section-description {
  text-align: center;
  padding-bottom: 40px;
  color: #999;
}

.section-bg {
  background-color: #f1f1f1;
}

.section-title {
  text-align: center;
  padding-bottom: 30px;
}

.section-title h2 {
  font-size: 32px;
  font-weight: bold;
  text-transform: uppercase;
  margin-bottom: 20px;
  padding-bottom: 0;
  color: #5f3703;
}

.section-title p {
  margin-bottom: 0;
}

.project .content {
  padding: 30px 0;
  max-width: 90%;
  margin: auto;
}

.float-right {
  position: absolute;
  top: 2vh;
  right: 2vh;
}

.box-card {
  position: absolute;
  top: 8vh;
  right: 2vh;
  z-index: 2;
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.text {
  font-size: 14px;
}

.item {
  margin-bottom: 18px;
}

.box-card {
  width: 480px;
}

.demo-tabs {
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;

}

.flex-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%; 
}
.demo-tabs {
  overflow-x: auto; 
  -webkit-overflow-scrolling: touch;
}

.el-tabs__header {
  display: flex;
  flex-wrap: nowrap; 
}

.el-tabs__nav-wrap {
  display: flex;
  overflow-x: auto; 
  flex: 1;
}

.el-tabs__nav {
  display: flex;
  white-space: nowrap; 
}

.el-tabs__item {
  white-space: nowrap;
}
@media (max-width: 992px) {
  .el-tabs__header {
    display: block;
    overflow-x: auto;
  }

  .el-tabs__nav-wrap {
    flex-wrap: nowrap;
    overflow-x: auto;
  }

  .el-tabs__nav {
    flex-wrap: nowrap;
    overflow-x: auto;
    display: flex;
  }
}
</style>
