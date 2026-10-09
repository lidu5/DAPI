<template>
  <div class="app-container" v-if="project.id">
    <div v-if="project.status === 'new'">
      <div>
        {{ project.name }} is not yet approved for registration.
        <el-button class="margin-left" v-if="requester" v-permission="['request cert registration']" type="primary" @click="requestRegistration()"
          :loading="cert_button">Request Registration</el-button>      
      </div>
    </div>
      <div>
        <el-card v-if="!valid" class="missing-card">
          <template #header>
            <div class="card-header">
              <span>Missing information to apply for registration</span>
            </div>
          </template>
          <div v-for="info in message" class="text item">{{ info }}</div>
        </el-card>
    </div>
    <el-row v-if="project.status === 'registration rejected'">
      <p>Your project has been declined by validater. For more please view message</p>
      <el-button class="margin-left" v-if="requester" v-permission="['request cert registration']" type="primary" @click="requestRegistration()"
          :loading="cert_button">Request Validation</el-button>
    </el-row>
    <el-row v-if="project.status === 'request registration'">
      {{ project.name }} is under review for registration.
      <el-button class="margin-left" v-if="requester" v-permission="['request cert registration']" type="primary" @click="withdrawRegistration()"
          :loading="cert_button">Withdraw Request</el-button>      
    </el-row>
    <div v-if="project.status === 'registration'">
      <p>
        {{ project.name }} is approved for registration. 
      </p>
      <div v-if="project.dhs_implemeted === 'Public'">
        <el-alert type="info" title="Certification of Competence" show-icon :closable="false">
          <p>{{ project.name }} is implemented on Public sector. The DHLEO will evaluate and certify the competence or get back to you for more information</p>
        </el-alert>      
      </div>
    </div>
    <div v-if="project.status === 'request cert competence'">
      <el-alert type="info" title="Certification of Competence" show-icon :closable="false">
        <p>{{ project.name }} is implemented on Public sector. The DHLEO will evaluate and certify the competence or get back to you for more information</p>
      </el-alert>    
    </div>
    <el-row v-if="project.status === 'cert competence rejected'">
      <p>Your project has been declined by qa_approver. For more please view message</p>
      <el-button class="margin-left" v-permission="['request cert competence']" type="primary" @click="requestCompetenceCertificate()"
          :loading="approval_button">Request Competence Certificate</el-button>
    </el-row>
    <el-row v-if="project.status === 'cert competence'">
      <p>{{ project.name }} is certified for competence on {{ project.certificates.find((cert) => cert.type == 'COMPETENCE').certify_date }}</p>
    </el-row>
    <el-row class="float-right">
      <el-button v-if="project.status == 'request cert competence' || project.status == 'cert competence'" v-permission="['project evaluation', 'view project']" type="primary"
        @click="evaluateProject()">
        <el-icon class="el-icon--left">
          <Tickets />
        </el-icon>
        Evaluate Project
      </el-button>
      <el-button circle @click="decline_dialog(-1)">
        <el-icon class="el-icon--left">
          <Message />
        </el-icon>
      </el-button>
    </el-row>

    <el-tabs v-model="activeName" class="demo-tabs">
      <el-tab-pane label="General" name="General">
        <GeneralView :project="project" />
      </el-tab-pane>
      <el-tab-pane label="Technologies" name="Technologies">
        <TechnologyView :project="project" />
      </el-tab-pane>
      <el-tab-pane label="Interoperability and Standards" name="Interoperability and Standards">
        <InteroperabilityStandardView :project="project" />
      </el-tab-pane>
      <el-tab-pane label="Implementations" name="Implementations">
        <ImplementationView :project="project" />
      </el-tab-pane>
      <el-tab-pane label="Coverages" name="Coverages">
        <CoverageView :coverages="project.coverages" :id="project.id" :user_id="project.user_id" :edit="true"/>
      </el-tab-pane>
      <el-tab-pane label="Activities" name="Activities">
        <ActivityView :activities="project.activities" :id="project.id" :user_id="project.user_id" :edit="true"/>
      </el-tab-pane>
      <el-tab-pane label="Resources" name="Resources">
        <ResourceView :resources="project.resources" :id="project.id" :user_id="project.user_id" :status="project.status" :edit="true"/>
      </el-tab-pane>
      <el-tab-pane label="Others" name="Others">
        <OtherView :project="project" />
      </el-tab-pane>
    </el-tabs>
    <div class="cert_registration" v-if="project.status == 'request registration'" v-permission="['cert registration']">
      <el-alert type="info" title="Approval Statement for Registration" show-icon :closable="false">
        <p>To approve the project registration, I have confirmed the DHS information is correct and appropriately set based on the pre-registration evaluation checklist.</p>
        <el-button type="primary" @click="approveRegistration()">Approve Registration</el-button>
        <el-button type="danger" @click="decline_dialog(0)">Decline Request</el-button>
      </el-alert>      
    </div>

    <el-collapse-transition>
      <el-card class="box-card transition-box" v-if="evaluation_metrics">
        <template #header>
          <div class="card-header">
            <span>Evaluation Matrix</span>
            <el-badge :value="score" class="item right" :type="score < 75 ? 'warning' : 'primary'">
              <el-button>Score</el-button>
            </el-badge>
          </div>
        </template>
        <el-form v-model="evaluations" class="login_form" label-position="top">
          <el-scrollbar height="60vh">
            <div v-for="evaluation in evaluations" :key="evaluation.id" class="text item">
              {{ evaluation.name + " (Weight: " + evaluation.weight + ") " }}
              <hr />
              <el-form-item v-for="metrics in evaluation.evaluation_metrics" :key="metrics.id"
                :label="metrics.elements + ' (Weight: ' + metrics.weight + ') '">
                <el-input-number v-model="metrics.score" :disabled="disableValidate" :min="0" :max="metrics.weight" />
              </el-form-item>
            </div>
            <div v-if="project.status != 'cert competence'">
              <el-alert type="info" title="Certification of Competence" show-icon :closable="false">
                <p>{{ project.name }} should score at least 75% in each of the categories:  Performance, interoperability, accessibility, Scalability, Security, Sustainability, Technology, Documentation quality test. Failing to score at least 75% in one of the categories will result in rejection of the system.</p>
                <p>Not applicable metrics can be decided by QA team with justifications</p>
                <p>For non-measurable  applications that can’t be measured by the above quality assurance metrics parameter, the committee is mandated to handle quality assurance with suitable justification.</p>
              </el-alert>      
            </div>
            <!-- Button area -->
            <el-row v-if="project.status != 'cert competence'" v-permission="['cert competence']" justify="end">
              <el-form-item>
                <el-button type="danger" @click="decline_dialog(1)">Decline</el-button>
                <el-button type="success" :loading="loading" @click="certifyCompetence()">Certify Competence</el-button>
              </el-form-item>
            </el-row>
          </el-scrollbar>
        </el-form>
      </el-card>
    </el-collapse-transition>

    <el-dialog title="Decline request" v-model="dialogVisible" width="50%">
      <el-form v-show="decline_type != -1 && (checkPermission(['cert registration']) || checkPermission(['cert competence']))" ref="ruleFormRef" :model="decline_data" :label-position="'top'">
        <el-form-item label="Decline message" required>
          <el-input v-model="decline_data.message" type="textarea" />
        </el-form-item>
      </el-form>
      <el-scrollbar height="30vh">
        <el-descriptions
          class="margin-top"
          size="large"
          :column="1"
          border
        >
          <el-descriptions-item v-for="dec in decline_messages" :key="dec.id" :label="dec.name+' ['+dec.pivot.type+']'">
            {{ dec.pivot.message }}
          </el-descriptions-item>
        </el-descriptions>
        <p v-if="decline_messages.length == 0">No decline message!</p>
      </el-scrollbar>
      <template #footer>
        <el-button @click="dialogVisible = false">
          {{ $t("table.cancel") }}
        </el-button>
        <el-button v-show="decline_type != -1" type="danger" @click="decline()">
          Decline Request
        </el-button>
      </template>
    </el-dialog>
  </div>
</template>

<script>
import DHPI from "@/api/project";
import Evaluation from "@/api/evaluation";

import GeneralView from "./components/View/GeneralView";
import InteroperabilityStandardView from "./components/View/InteroperabilityStandardView";
import ImplementationView from "./components/View/ImplementationView";
import CoverageView from "./components/View/CoverageView";
import ActivityView from "./components/View/ActivityView";
import ResourceView from "./components/View/ResourceView";
import OtherView from "./components/View/OtherView";
import TechnologyView from "./components/View/TechnologyView";

import checkPermission from "@/utils/permission"; // Permission checking

import { mapGetters } from 'vuex';

const dhpi = new DHPI();
const evaluation = new Evaluation();

export default {
  name: "Project View",
  data() {
    return {
      activeName: "General",
      project: {},
      evaluations: [],
      loading: false,
      cert_button: false,
      approval_button: false,
      evaluation_metrics: false,
      query: {},
      decline_data: {},
      disableValidate: true,
      decline_messages: [],
      decline_type: null,
      dialogVisible: false,
      valid: true,
      message: [],
      score: 0
    };
  },
  computed: {
    ...mapGetters([
      'userId'
    ]),
    requester(){
      if(this.project.user_id === this.userId){
        return true
      }

      return false
    }
  },
  created() {
    const id = this.$route.params && this.$route.params.id;
    this.getProject(id);
  },
  methods: {
    checkPermission,
    isEmpty(value){
      return value == undefined || value == null || value.length === 0
    },
    validateForRegistration(){
      this.valid = true
      const message = []

      if(this.isEmpty(this.project.name)){
        message.push("DHS name missing")
        this.valid = false
      }        
      if(this.isEmpty(this.project.organization)){
        message.push("DHS lead organization missing")
        this.valid = false
      }
      if(this.isEmpty(this.project.start_date)){
        message.push("DHS start date missing")
        this.valid = false
      }
      if(this.isEmpty(this.project.contact_name)){
        message.push("DHS contact name missing")
        this.valid = false
      }
      if(this.isEmpty(this.project.contact_email)){
        message.push("DHS contact email missing")
        this.valid = false
      }
      if(this.isEmpty(this.project.contact_phone)){
        message.push("DHS contact phone missing")
        this.valid = false
      }
      if(this.isEmpty(this.project.objective)){
        message.push("DHS objective missing")
        this.valid = false
      }
      if(this.isEmpty(this.project.budget)){
        message.push("DHS budget missing")
        this.valid = false
      }
      if(this.isEmpty(this.project.legal_document)){
        message.push("DHS legal document missing")
        this.valid = false
      }
      if(this.isEmpty(this.project.license)){
        message.push("DHS license missing")
        this.valid = false
      }
      if(this.isEmpty(this.project.osi_licenses)){
        message.push("DHS OSI approved license missing")
        this.valid = false
      }
      if(this.isEmpty(this.project.ownership_type)){
        message.push("DHS ownership missing")
        this.valid = false
      }
      if(this.isEmpty(this.project.applications)){
        message.push("DHS application type missing")
        this.valid = false
      }
      if(this.isEmpty(this.project.operating_systems)){
        message.push("DHS supported operating systems missing")
        this.valid = false
      }
      if(this.isEmpty(this.project.tech_stacks)){
        message.push("DHS language/framework missing")
        this.valid = false
      }
      if(this.isEmpty(this.project.databases)){
        message.push("DHS database missing")
        this.valid = false
      }
      if(this.isEmpty(this.project.components)){
        message.push("DHS eHA component missing")
        this.valid = false
      }
      if(this.isEmpty(this.project.fhir_compliant)){
        message.push("DHS FHIR compliant missing")
        this.valid = false
      }
      if(this.isEmpty(this.project.standards)){
        message.push("DHS standards missing")
        this.valid = false
      }
      if(this.isEmpty(this.project.focus_areas)){
        message.push("DHS health focus area(s) missing")
        this.valid = false
      }
      if(this.isEmpty(this.project.challenges)){
        message.push("DHS health focus area(s) missing")
        this.valid = false
      }
      if(this.isEmpty(this.project.dhs_implemeted)){
        message.push("DHS implemented location missing")
        this.valid = false
      }
      if(this.isEmpty(this.project.current_version)){
        message.push("DHS current version missing")
        this.valid = false
      }
      if(this.isEmpty(this.project.deployment_locations)){
        message.push("DHS deployment locations missing")
        this.valid = false
      }
      if (this.project.resources == undefined || !this.project.resources.some((proj) => proj.title === 'Proof of Safety')){
        message.push("DHS proof of safety document missing")
        this.valid = false
      }

      if(message.length > 0)
        message.push("Reload the page after fixing the problem(s)")

      return message
    },
    async getProject(id) {
      this.loading = true;
      try {
        const { data } = await dhpi.get(id);
        this.project = data;
      } catch (err) {
        if (err.message == "Request failed with status code 404") {
          this.$router.push(`/404`);
        }
      }
      this.loading = false;
    },
    requestRegistration() {
      if (this.project.status === "new" || this.project.status === "registration rejected") {
        this.message = this.validateForRegistration()
        if (this.valid){
          ElMessageBox.confirm(
          'Request for Registration by admiting all DHS required informations are provided!',
          'Request Registration',
          {
            confirmButtonText: 'Request',
            cancelButtonText: 'Cancel',
            type: 'warning',
          }
        )
          .then(() => {
            this.cert_button = true;
            dhpi
              .requestRegistration(this.project.id)
              .then((response) => {
                this.cert_button = false;
                this.project.status = response.data.status;
                ElMessage({
                  type: 'success',
                  message: `Request has been sent to DHLEO Governance Desk. We will get back to you soon!`,
                })
              })
              .catch((err) => {
                this.cert_button = false;
                console.log(err);
              });
          })
          .catch(() => {
          })
        }        
      }
    },
    approveRegistration(){
      if (this.project.status === "request registration") {
        this.message = this.validateForRegistration()
        if (this.valid){
          ElMessageBox.confirm(
            `To approve ${this.project.name} registration, I have confirmed informations are correctly and appropriately set based on the pre-registration evaluation checklist. Please click Approve button to confirm`,
            'Approve Registration',
            {
              confirmButtonText: 'Approve',
              cancelButtonText: 'Cancel',
              type: 'warning',
            }
          )
          .then(() => {
            this.cert_button = true;
            evaluation
            .approve_registration(this.project.id)
            .then((response) => {
              this.loading = false;
              this.project.certificates = response
              this.project.status = "registration approved";
              this.$message({
                message: `${this.project.name} has been approved for registration!`,
                type: "success",
              });
            })
            .catch((err) => console.log(err));
          })
          .catch(() => {
          })
        }
      }
    },
    requestCompetenceCertificate() {
      if (this.project.status === "registration approved" || this.project.status === "cert competence rejected") {
        this.approval_button = true;
        dhpi
          .request_cert_comp(this.project.id)
          .then((response) => {
            this.approval_button = false;
            this.project.status = response.data.status;
          })
          .catch((err) => {
            this.approval_button = false;
            console.log(err);
          });
      }
    },
    async evaluateProject() {
      this.query.project_id = this.project.id;
      if (this.evaluations.length == 0) {
        this.score = 0
        const data = await evaluation.list(this.query);
        this.evaluations = data;
        this.evaluations.map((evaluation) => {
          evaluation.evaluation_metrics.map((metrics) => {
            if (metrics.projects.length !== 0) {
              metrics.score = metrics.projects[0].pivot.score;
              this.score += metrics.score
            }
          });
        });
        this.disableValidate = !this.checkPermission(["cert competence"]) || this.project.status == 'cert competence';
      }
      this.evaluation_metrics = !this.evaluation_metrics;
    },
    certifyCompetence() {
      const result = this.evaluations.some((evaluation) =>
        evaluation.evaluation_metrics.some(
          (metrics) => metrics.score === undefined
        )
      );
      if (result) {
        this.$message.error("All metrics must be filled");
      } else {
        this.score = 0;
        this.evaluations.map((evaluation) => {
          evaluation.evaluation_metrics.map((metrics) => {
            this.score += metrics.score;
          });
        });

        let button = 'Certify'
        if(this.score < 75){
          button = 'Total score < 75%. Certify anyways!'
        }

        ElMessageBox.confirm(
            `To certify ${this.project.name}, I have confirmed informations are correctly and appropriately set based on the quality assurance evaluation checklist. Please click Certify button to confirm`,
            'Certify Competence',
            {
              confirmButtonText: button,
              cancelButtonText: 'Cancel',
              type: 'warning',
            }
          )
          .then(() => {
            this.cert_button = true;
            evaluation
            .cert_competence(this.project.id, this.evaluations)
            .then((response) => {
              this.loading = false;
              this.project.certificates = response
              this.project.status = "cert competence";

              this.$message({
                message: "DHS competence certificate has been given!",
                type: "success",
              });
            })
            .catch((err) => console.log(err));
          })
          .catch(() => {
          })
      }
    },
    async decline_dialog(type) {
      const data = await evaluation.decline_messages(this.project.id);
      this.decline_messages = data;
      this.decline_type = type;
      this.dialogVisible = true;
    },
    decline() {
      if(this.decline_data.message == undefined){
        this.$message({
          message: "Please provide why you are declining the request",
          type: "error",
          duration: 5 * 1000,
        });
        return
      }

      if (this.decline_type == 0 && this.checkPermission(["cert registration"])) {
        evaluation
          .decline_registration(this.project.id, this.decline_data)
          .then((response) => {
            this.loading = false;
            this.project.status = "registration rejected"

            this.decline_messages = response
            this.decline_data = {}
            this.dialogVisible = false;
            this.$message({
              message: "Registration request declined",
              type: "warning",
            });            
          })
          .catch((err) => console.log(err))
      } else if (this.decline_type == 1 && this.checkPermission(["cert competence"])) {
        evaluation
          .decline_cert_comp(this.project.id, this.decline_data)
          .then((response) => {
            this.loading = false;
            this.project.status = "cert competence rejected"

            this.decline_messages = response
            this.decline_data = {}
            this.dialogVisible = false;
            this.evaluation_metrics = false
            this.$message({
              message: "Competence certification request declined",
              type: "warning",
            });
          })
          .catch((err) => console.log(err))
      }
    },
    withdrawRegistration() {
      if (this.project.status === "request registration") {
          ElMessageBox.confirm(
          'Withdraw Request for Registration to edit your project further.',
          'Withdraw Registration Request',
          {
            confirmButtonText: 'Withdraw',
            cancelButtonText: 'Cancel',
            type: 'warning',
          }
        )
          .then(() => {
            this.cert_button = true;
            dhpi
              .withdrawRegistration(this.project.id)
              .then((response) => {
                this.cert_button = false;
                this.project.status = response.data.status;
                ElMessage({
                  type: 'success',
                  message: `Request has been succesfully cancelled. We will get back to you soon!`,
                })
              })
              .catch((err) => {
                this.cert_button = false;
                console.log(err);
              });
          })
          .catch(() => {
          })       
      }
    },
  },
  components: {
    GeneralView,
    InteroperabilityStandardView,
    ImplementationView,
    CoverageView,
    ActivityView,
    ResourceView,
    OtherView,
    TechnologyView,
  },
};
</script>

<style scoped>
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
  color: #B3450E
}

.item {
  margin-bottom: 18px;
}

.box-card {
  width: 480px;
}

.margin-left {
  margin-left: 20px;
}

.missing-card {
  width: 600px;
}

.cert_registration {
  width: 500px;
  margin-left: 50px;
}
.cert_registration button{
  margin-top: 5px;
}
</style>
