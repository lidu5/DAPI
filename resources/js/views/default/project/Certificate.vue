<template>
  <div v-if="project.id" class="container pm-certificate-container">
    <el-carousel :interval="5000" height="598px" arrow="always">
      <el-carousel-item v-if="project.certificates.find((cert) => cert.type == 'REGISTRATION')" label="Certificate of Registration">
        <div class="outer-border"></div>
        <div class="inner-border"></div>

        <div class="pm-certificate-border">
          <div class="pm-certificate-header">
            <el-row>
              <el-col :span="8">
                <img src="@/assets/moh/logo-main.png" class="sidebar-logo"/>
              </el-col>
              <el-col :span="16">
                <div class="pm-certificate-title cursive">
                  <h2>Certificate of Registration</h2>
                </div>
              </el-col>
            </el-row>        
          </div>

          <div class="pm-certificate-body">

            <div class="pm-certificate-block">
              <el-row>
                <el-col :span="4" /><!-- LEAVE EMPTY -->
                <el-col :span="16">
                  <div class="pm-earned text-center">
                    <span class="pm-credits-text block bold sans">This is to certify</span>
                  </div>
                </el-col>
                <el-col :span="4" /><!-- LEAVE EMPTY -->
              </el-row>

              <el-row>
                <el-col :span="4" /><!-- LEAVE EMPTY -->
                <el-col :span="16">
                  <div class="pm-certificate-name underline margin-0 text-center">
                    <span class="pm-name-text bold">{{ project.name }}</span>
                  </div>
                </el-col>
                <el-col :span="4" /><!-- LEAVE EMPTY -->
              </el-row>

              <el-row>
                <el-col :span="24">
                  <div class="pm-earned pm-course-title col-xs-8 text-center">
                    <span class="pm-earned-text block sans">is duly registered on the Ministry of Health Digital Health Projects Inventory System in conformance to the minimum acceptable registration requirement. </span>
                  </div>
                </el-col>
              </el-row>
            </div>

            <!-- <div class="pm-certificate-footer">
              <el-row>
                <el-col :span="12">
                  <div class="col-xs-4 pm-certified col-xs-4 text-center">
                    <span class="pm-credits-text block sans">Date</span>
                    <span class="block underline">{{ project.certificates.find((cert) => cert.type == 'REGISTRATION') }}</span>
                  </div>
                </el-col>
                <el-col :span="4" />
                <el-col :span="8">
                  <div class="col-xs-4 pm-certified col-xs-4 text-center">
                    <span class="pm-credits-text block sans">Signature</span>
                    <span class="pm-empty-space block underline"></span>
                  </div>
                </el-col>
              </el-row>
            </div> -->
          </div>
        </div>
      </el-carousel-item>
      <el-carousel-item v-if="project.certificates.find((cert) => cert.type == 'COMPETENCE')" label="Comptence Certification">
        <div class="outer-border"></div>
        <div class="inner-border"></div>

        <div class="pm-certificate-border">
          <div class="pm-certificate-header">
            <el-row>
              <el-col :span="8">
                <img src="@/assets/moh/logo-main.png" class="sidebar-logo"/>
              </el-col>
              <el-col :span="16">
                <div class="pm-certificate-title cursive">
                  <h2>Competence Certificate</h2>
                </div>
              </el-col>
            </el-row>        
          </div>

          <div class="pm-certificate-body">

            <div class="pm-certificate-block">
              <el-row>
                <el-col :span="4" /><!-- LEAVE EMPTY -->
                <el-col :span="16">
                  <div class="pm-earned text-center">
                    <span class="pm-credits-text block bold sans">This is to certify</span>
                  </div>
                </el-col>
                <el-col :span="4" /><!-- LEAVE EMPTY -->
              </el-row>

              <el-row>
                <el-col :span="4" /><!-- LEAVE EMPTY -->
                <el-col :span="16">
                  <div class="pm-certificate-name underline margin-0 text-center">
                    <span class="pm-name-text bold">{{ project.name }}</span>
                  </div>
                </el-col>
                <el-col :span="4" /><!-- LEAVE EMPTY -->
              </el-row>

              <el-row>
                <el-col :span="24">
                  <div class="pm-earned pm-course-title col-xs-8 text-center">
                    <span class="pm-earned-text block sans">
                      has passed the Ministry of Health Digital Health Solution quality assurance evaluation on {{ project.published_date }} based on the quality metrics and guidelines published by the Ministry of Health. 
                      This certification is valid until {{ new Date(new Date(project.published_date).setFullYear(new Date().getFullYear() + 2)).toDateString() }} is subject to periodic quality audits.
                    </span>
                  </div>
                </el-col>
              </el-row>
            </div>

            <!-- <div class="pm-certificate-footer">
              <el-row>
                <el-col :span="12">
                  <div class="col-xs-4 pm-certified col-xs-4 text-center">
                    <span class="pm-credits-text block sans">Date</span>
                    <span class="block underline">{{ project.published_date }}</span>
                  </div>
                </el-col>
                <el-col :span="4" />
                <el-col :span="8">
                  <div class="col-xs-4 pm-certified col-xs-4 text-center">
                    <span class="pm-credits-text block sans">Signature</span>
                    <span class="pm-empty-space block underline"></span>
                  </div>
                </el-col>
              </el-row>
            </div> -->
          </div>
        </div>
      </el-carousel-item>
    </el-carousel>
  </div>
</template>

<script>
import DHPI from "@/api/project";

const dhpi = new DHPI();

export default {
  name: "Project Certificate",
  data() {
    return {
      project: {},
      loading: false,
    };
  },
  created() {
    const uuid = this.$route.params && this.$route.params.uuid;
    this.getProject(uuid);
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
    }
  },
};
</script>

<style scoped lang="scss">
@import url('https://fonts.googleapis.com/css?family=Open+Sans|Pinyon+Script|Rochester');

.cursive {
  font-family: 'Pinyon Script', cursive;
}

.sans {
  font-family: 'Open Sans', sans-serif;
}

.bold {
  font-weight: bold;
}

.block {
  display: block;
}

.underline {
  border-bottom: 1px solid #777;
  padding: 5px;
  margin-bottom: 15px;
}

.margin-0 {
  margin: 0;
}

.padding-0 {
  padding: 0;
}

.pm-empty-space {
  height: 40px;
  width: 100%;
}

body {
  padding: 20px 0;
  background: #ccc;
}

.pm-certificate-container {
  position: relative;
  width: 1200px;
  // height: 600px;
  background-color: #618597;
  padding: 30px;
  color: #333;
  font-family: 'Open Sans', sans-serif;
  box-shadow: 0 0 5px rgba(0, 0, 0, .5);

  .outer-border {
    width: 1190px;
    height: 594px;
    position: absolute;
    left: 33.5%;
    margin-left: -397px;
    top: 50%;
    margin-top: -297px;
    border: 2px solid #fff;
  }

  .inner-border {
    width: 1105px;
    height: 530px;
    position: absolute;
    left: 34.5%;
    margin-left: -365px;
    top: 50%;
    margin-top: -265px;
    border: 2px solid #fff;
  }
}

.pm-certificate-border {
    position: relative;
    width: 1099px;
    height: 520px;
    padding: 0;
    border: 1px solid #E1E5F0;
    background-color: rgba(255, 255, 255, 1);
    background-image: none;
    left: 34%;
    margin-left: -356px;
    top: 50%;
    margin-top: -260px;

    .pm-certificate-block {
      width: 650px;
      height: 200px;
      position: relative;
      left: 50%;
      margin-left: -325px;
      top: 70px;
      margin-top: 0;
    }

    .pm-certificate-header {
      margin-bottom: 10px;
    }

    .pm-certificate-title {
      position: relative;
      top: 40px;

      h2 {
        font-size: 34px !important;
      }
    }

    .pm-certificate-body {

      .pm-name-text {
        font-size: 20px;
      }
    }

    .pm-earned {
      margin: 15px 0 20px;

      .pm-earned-text {
        font-size: 20px;
        width: 800px;
        margin-left: -62px
      }

      .pm-credits-text {
        font-size: 15px;
      }
    }

    .pm-course-title {
      .pm-earned-text {
        font-size: 20px;
      }

      .pm-credits-text {
        font-size: 15px;
      }
    }

    .pm-certified {
      font-size: 12px;

      .underline {
        margin-bottom: 5px;
      }
    }

    .pm-certificate-footer {
      width: 650px;
      height: 100px;
      position: relative;
      left: 50%;
      margin-left: -325px;
      bottom: -105px;
    }
  }

.container {
  margin: 80px auto;
}

.sidebar-logo {
    position: relative;
    top: 30px;
    left: 50px;
  }
</style>