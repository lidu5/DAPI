<template>
    <div class="app-container">
        <div class="wrapper-stepper">
            <div class="stepper">
                <div class="stepper-progress">
                    <div class="stepper-progress-bar" :style="'width:' + stepperProgress"></div>
                </div>
                <div class="stepper-item" :class="{'current': step == item, 'success': step > item}" v-for="item in maxSteps" :key="item">
                    <div class="stepper-item-counter">
                        <Check class="icon-success"/>
                        <span class="number">
                            {{ item }}
                        </span>                        
                    </div>
                    <span class="stepper-item-title">
                        {{ sleepers[item - 1] }}
                    </span>
                </div>
            </div>
            <div class="stepper-content">
                <div class="stepper-pane" v-if="step == sleepers.indexOf('General') + 1">
                  <General :project="project" ref="General" />
                </div>
                <div class="stepper-pane" v-if="step == sleepers.indexOf('Technologies') + 1">
                  <Technology :project="project" ref="Technologies" />
                </div>
                <div class="stepper-pane" v-if="step == sleepers.indexOf('Interoperability and Standards') + 1">
                  <Interoperability_Standard :project="project" ref="Interoperability and Standards" />
                </div>
                <div class="stepper-pane" v-if="step == sleepers.indexOf('Implementations') + 1">
                  <Implementation :project="project" ref="Implementations" />
                </div>
                <div class="stepper-pane" v-if="step == sleepers.indexOf('Coverages') + 1">
                  <Coverage :project="project" ref="Coverages" />
                </div>
                <div class="stepper-pane" v-if="step == sleepers.indexOf('Activities') + 1">
                  <Activity :project="project" ref="Activities" />
                </div>
                <div class="stepper-pane" v-if="step == sleepers.indexOf('Resources') + 1">
                  <Resource :project="project" ref="Resources" />
                </div>
                <div class="stepper-pane" v-if="step == sleepers.indexOf('Others') + 1">
                  <Other :project="project" ref="Others" />
                </div>
            </div>

            <div class="controls">
                <el-button :loading="buttonLoading" class="btn" @click="handlePrev()" :disabled="step == 1">Previous</el-button>
                <el-button :loading="buttonLoading" class="btn btn--left" type="primary" @click="handleNext()">{{ leftButton }}</el-button>            
            </div>
        </div>
    </div>
</template>

<script>
import General from "./components/General.vue";
import Implementation from "./components/Implementation.vue";
import Technology from "./components/Technology.vue";
import Interoperability_Standard from "./components/Interoperability_Standard.vue";
import Coverage from "./components/Coverage.vue";
import Activity from "./components/Activity.vue";
import Other from "./components/Other.vue";
import Resource from "./components/Resource.vue";

  export default {
    data() {
      return {
        sleepers: [ 'General', 'Technologies', 'Interoperability and Standards', 'Implementations', 'Coverages', 'Activities', 'Resources', 'Others'],
        step: 1,
        project: {
        },
        leftButton: 'Next',
        buttonLoading: false
      };
    },
    created() {
      const query = this.$route.query
      if (query.step){
        this.step = query.step
      }
    },
    computed: {
      stepperProgress() {
        return (100 / (this.maxSteps - 1)) * (this.step - 1) + "%";
      },
      maxSteps(){
        return this.sleepers.length
      }
    },
    components: { General, Implementation, Technology, Interoperability_Standard, Coverage, Activity, Other, Resource },
    methods: {
      async handleNext(){
        this.buttonLoading = true
        const move = await this.beforeChange()
        if(move){
          if(this.step == (this.maxSteps - 1)){
            this.leftButton = 'Submit'
            this.step++
          } else if(this.step < this.maxSteps) {
            if(this.leftButton === 'Submit')
              this.leftButton = 'Next'
            
            this.step++
          } else if(this.step >= this.maxSteps){
            this.$router.push(`/projects/view/${this.project.id}`)
            this.step = 1
            this.project = {}
            this.leftButton = 'Next'
          }
        }    
        this.buttonLoading = false        
      },
      async beforeChange(){
        const validate = await this.$refs[this.sleepers[this.step-1]].validate().catch(err => {
          return err
        })

        if(validate){
          this.updateProject(validate)
          return true
        }
      },
      handlePrev(){
          this.step--
      },
      isEmpty(value){
        return value == undefined || value == null || value.length === 0
      },
      updateProject(response){
        if(!this.isEmpty(response.id)){
          this.project.id = response.id
        }
        if(!this.isEmpty(response.uuid)){
          this.project.uuid = response.uuid
        }
        if(!this.isEmpty(response.name)){
          this.project.name = response.name
        }
        if(!this.isEmpty(response.start_date)){
          this.project.start_date = response.start_date
        }
        if(!this.isEmpty(response.end_date)){
          this.project.end_date = response.end_date
        }
        if(!this.isEmpty(response.contact_name)){
          this.project.contact_name = response.contact_name
        }
        if(!this.isEmpty(response.contact_email)){
          this.project.contact_email = response.contact_email
        }
        if(!this.isEmpty(response.contact_phone)){
          this.project.contact_phone = response.contact_phone
        }
        if(!this.isEmpty(response.objective)){
          this.project.objective = response.objective
        }
        if(!this.isEmpty(response.legal_document)){
          this.project.legal_document = response.legal_document
        }
        if(!this.isEmpty(response.summary)){
          this.project.summary = response.summary
        }
        if(!this.isEmpty(response.organization)){
          this.project.organization = response.organization
          this.project.lead_organization = response.organization.id
        }
        if(!this.isEmpty(response.organization)){
          this.project.organization = response.organization
          this.project.lead_organization = response.organization.id
        }
        if(!this.isEmpty(response.partners)){
          this.project.partner = response.partners.map((partner => partner.id))
        }        

        if(!this.isEmpty(response.golive_date)){
          this.project.golive_date = response.golive_date
        }
        if(!this.isEmpty(response.license)){
          this.project.license = response.license
          this.project.under_license = response.license.id
        }
        if(!this.isEmpty(response.osi_licenses)){
          this.project.osi_licenses = response.osi_licenses
          this.project.osi_license = response.osi_licenses.map((osi_license => osi_license.id))
        }
        if(!this.isEmpty(response.ownership_type)){
          this.project.ownership_type = response.ownership_type
          this.project.ownership = this.project.ownership_type[0]?.id
        }
        if(!this.isEmpty(response.owner)){
          this.project.owner = response.owner
        }
        if(!this.isEmpty(response.documentation_link)){
          this.project.documentation_link = response.documentation_link
        }
        if(!this.isEmpty(response.wiki_page)){
          this.project.wiki_page = response.wiki_page
        }
        if(!this.isEmpty(response.git_link)){
          this.project.git_link = response.git_link
        }
        if(!this.isEmpty(response.applications)){
          this.project.applications = response.applications
          this.project.application = this.project.applications.map(
            (application) => application.id
          );
        }
        if(!this.isEmpty(response.operating_systems)){
          this.project.operating_systems = response.operating_systems
          this.project.os = this.project.operating_systems.map(
            (operating_system) => operating_system.id
          );
        }
        if(!this.isEmpty(response.tech_stacks)){
          this.project.languages = response.tech_stacks.filter((stack) => stack.type == "Language")
          this.project.language = this.project.languages.map(
            (language) => language.id
          );

          this.project.frameworks = response.tech_stacks.filter((stack) => stack.type == "Framework")
          this.project.framework = this.project.frameworks.map(
            (framework) => framework.id
          );
        }
        if(!this.isEmpty(response.databases)){
          this.project.databases = response.databases
          this.project.db = this.project.databases.map((database) => database.id);
        }
        if(!this.isEmpty(response.third_party_tools)){
          this.project.third_party_tools = response.third_party_tools
        }

        if(!this.isEmpty(response.focus_areas)){
          this.project.focus_areas = response.focus_areas
          this.project.focus_area = this.project.focus_areas.map((focus_area) => focus_area.id);
        }
        if(!this.isEmpty(response.challenges)){
          this.project.challenges = response.challenges
          this.project.challenge = this.project.challenges.map((challenge) => challenge.id);
        }
        if(!this.isEmpty(response.moh_contribution)){
          this.project.moh_contribution = response.moh_contribution
        }
        if(!this.isEmpty(response.dhs_implemeted)){
          this.project.dhs_implemeted = response.dhs_implemeted
        }
        if(!this.isEmpty(response.current_status)){
          this.project.current_status = response.current_status
        }
        if(!this.isEmpty(response.current_version)){
          this.project.current_version = response.current_version
        }
        if(!this.isEmpty(response.deployment_locations)){
          this.project.deployment_locations = response.deployment_locations
          this.project.deployment_location = this.project.deployment_locations.map((deployment_location) => deployment_location.id)
        }
        if(!this.isEmpty(response.geographic_scopes)){
          this.project.geographic_scopes = response.geographic_scopes
          this.project.geographic_scope = this.project.geographic_scopes.map((geographic_scope) => geographic_scope.id)
        }
        if(!this.isEmpty(response.national_scopes)){
          this.project.national_scopes = response.national_scopes
        }
        if(!this.isEmpty(response.facility_types)){
          this.project.facility_types = response.facility_types
          this.project.facility_type = this.project.facility_types.map((facility_type) => facility_type.id)
        }
        if(!this.isEmpty(response.targeted_users)){
          this.project.targeted_users = response.targeted_users
          this.project.target_user = this.project.targeted_users.map((target_user) => target_user.id)
        }

        if(!this.isEmpty(response.components)){
          this.project.components = response.components
          this.project.component = this.project.components[0]?.id
        }
        if(!this.isEmpty(response.fhir_compliant)){
          this.project.fhir_compliant = response.fhir_compliant == true ? 1 : 0
        }
        if(!this.isEmpty(response.standards)){
          this.project.standards = response.standards
          this.project.standard = this.project.standards.map((standard) => standard.id)
        }
        if(!this.isEmpty(response.has_api_support)){
          this.project.has_api_support = response.has_api_support == true ? 1 : 0
        }
        if(!this.isEmpty(response.is_api_published)){
          this.project.is_api_published = response.is_api_published == true ? 1 : 0
        }
        if(!this.isEmpty(response.is_openapi)){
          this.project.is_openapi = response.is_openapi == true ? 1 : 0
        }
        if(!this.isEmpty(response.data_is_sent_to_moh)){
          this.project.data_is_sent_to_moh = response.data_is_sent_to_moh == true ? 1 : 0
        }        
        
        if(!this.isEmpty(response.coverages)){
          this.project.coverages = response.coverages
        }
        if(!this.isEmpty(response.activities)){
          this.project.activities = response.activities
        }
        if(!this.isEmpty(response.resources)){
          this.project.resources = response.resources
        }

        if(!this.isEmpty(response.logo)){
          this.project.logo = response.logo
        }
        if(!this.isEmpty(response.bandwidth)){
          this.project.bandwidth = response.bandwidth
        }
        if(!this.isEmpty(response.supports)){
          this.project.supports = response.supports
        }
        if(!this.isEmpty(response.has_impact_evaluation)){
          this.project.has_impact_evaluation = response.has_impact_evaluation == true ? 1 : 0
        }
        if(!this.isEmpty(response.impact_evaluation)){
          this.project.impact_evaluation = response.impact_evaluation
        }
        if(!this.isEmpty(response.retire)){
          this.project.retire = response.retire
        }
        if(!this.isEmpty(response.user_id)){
          this.project.user_id = response.user_id
        }
      }
    }
}

</script>

<style scoped lang="scss">
  @import "@/styles/stepper_component.scss";

</style>
