<template>
  <div class="app-container">
    <el-descriptions
      class="margin-top"
      title="Implementation of the Digital Health Solution (DHS)"
      size="large"
      :column="1"
      border
    >
      <el-descriptions-item label="Health focus area(s) addressed by the DHS">
        {{ project.focus_areas.map((focus_area) => focus_area.name).join(", ") }}
      </el-descriptions-item>
      <el-descriptions-item label="Health system challenges addressed by the DHS">
        {{ project.challenges.map((challenge) => challenge.name).join(", ") }}
      </el-descriptions-item>
      <el-descriptions-item label="MoH contribution to this DHS implementation">
        {{ project.moh_contribution }}
      </el-descriptions-item>
      <el-descriptions-item label="Implementing Partners">
        {{ project.implementing_partners.map((implementing_partner) => implementing_partner.name).join(", ") }}
      </el-descriptions-item>
      <el-descriptions-item label="Funding Source DHS implementation">
         {{ Array.isArray(project.funding_sources) ? project.funding_sources.join(', ') : project.funding_sources }}
       </el-descriptions-item>

       <el-descriptions-item label="Business model DHS implementation">
         {{ Array.isArray(project.business_model) ? project.business_model.join(', ') : project.business_model }}
       </el-descriptions-item>
      <el-descriptions-item label="DHS implemented in">
        {{ project.dhs_implemeted }}
      </el-descriptions-item>
      <el-descriptions-item label="Current status of the software">
        {{ project.current_status }}
      </el-descriptions-item>
      <el-descriptions-item label="Current version of the application">
        {{ project.current_version }}
      </el-descriptions-item>
      <el-descriptions-item label="DHS server located">
        {{
          project.deployment_locations
            .map((deployment_location) => deployment_location.name)
            .join(", ")
        }}
      </el-descriptions-item>
      <el-descriptions-item label="Geographic scope of the DHS">
        {{
          project.geographic_scopes
            .map((geographic_scope) => geographic_scope.name)
            .join(", ")
        }}
      </el-descriptions-item>
      <el-descriptions-item label="If the scope is National, please indicate the directorates, agencies, or institutes using the DHS.">
        {{ project.national_scopes }}
      </el-descriptions-item>
      <el-descriptions-item label="Facility type where the DHS is implemented">
        {{ 
          project.facility_types
            .map((facility_type) => facility_type.name)
            .join(", ")            
        }}
      </el-descriptions-item>
      <el-descriptions-item label="Targeted users of the DHS">
        {{
          project.targeted_users
            .map((targeted_user) => targeted_user.name)
            .join(", ")
        }}
      </el-descriptions-item>
      <el-descriptions-item label="Category of Evidence">
        {{ project.category_of_evidence }}
      </el-descriptions-item>
      <el-descriptions-item label="Publications">
        {{ project.publications }}
      </el-descriptions-item>
      <el-descriptions-item label="Key Challenges and Recommendations">
        {{ project.key_challenges_recommendations }}
      </el-descriptions-item>
      

      <el-descriptions-item 
        v-if="editor" 
        v-permission="['edit project']"
        label-class-name="my-label"
      >
        <el-button type="primary" plain @click="openUpdateDialog()"
            >Edit Implementation Information</el-button>
      </el-descriptions-item>
    </el-descriptions>
  </div>
  <el-dialog v-if="editor" title="Implementation" v-model="dialogVisible" width="70%">
    <Implementation :project="project" ref="Implementation" />
    <template #footer>
      <el-button @click="dialogVisible = false">
        {{ $t("table.cancel") }}
      </el-button>
      <el-button type="primary" @click="update()"> Update </el-button>
    </template>
  </el-dialog>
</template>

<script>
import Implementation from "../Implementation.vue";
import { mapGetters } from 'vuex';

export default {
  name: "Implementation View",
  props: {
    project: {
      type: Object,
    },
    edit: {
      type: Boolean,
      default: true
    }
  },
  data() {
    return {
      dialogVisible: false,
    };
  },
  computed: {
    ...mapGetters([
      'userId', 'roles'
    ]),
    editor(){
      if(!this.edit)
        return false

      if(this.project.status != "new" && this.project.status != "registration rejected" && this.project.status != "cert competence rejected")
        return false
      
      if(this.project.user_id === this.userId){
        return true
      }else if(this.roles.includes('admin')){
        return true
      }

      return false
    }
  },
  components: {
    Implementation,
  },
  methods: {
    async update() {
      const validate = await this.$refs["Implementation"]
        .validate()
        .catch((err) => {
          return err;
        });
        console.log('Validate result:', validate); 
      if (validate) {
        this.updateProject(validate);
        this.dialogVisible = false;
      }
    },
    openUpdateDialog() {
      this.project.focus_area = this.project.focus_areas.map(
        (focus_area) => focus_area.id
      );
      this.project.challenge = this.project.challenges.map(
        (challenge) => challenge.id
      );
      this.project.implementing_partner = this.project.implementing_partners.map(implementing_partner => implementing_partner.id);

      this.project.moh_contribution = this.project.moh_contribution;
      this.project.category_of_evidence = this.project.category_of_evidence;
      this.project.key_challenges_recommendations = this.project.key_challenges_recommendations;
      this.project.publications = this.project.publications;
      if (typeof this.project.funding_sources === 'string') {
      this.project.funding_sources = this.project.funding_sources.split(',').map(item => item.trim());
       } else if (!Array.isArray(this.project.funding_sources)) {
       this.project.funding_sources = [];
      }

      if (typeof this.project.business_model === 'string') {
      this.project.business_model = this.project.business_model.split(',').map(item => item.trim());
       } else if (!Array.isArray(this.project.business_model)) {
       this.project.business_model = [];
      }
      this.project.deployment_location = this.project.deployment_locations.map(
        (deployment) => deployment.id
      );

      this.project.geographic_scope = this.project.geographic_scopes.map(
        (geographic_scope) => geographic_scope.id
      );

      this.project.facility_type = this.project.facility_types.map(
        (facility_type) => facility_type.id
      );

      this.project.target_user = this.project.targeted_users.map(
        (targeted_user) => targeted_user.id
      );

      this.dialogVisible = true;
    },
    updateProject(response) {
      if (response.focus_areas) {
        this.project.focus_areas = response.focus_areas;
      }
      if (response.challenges) {
        this.project.challenges = response.challenges;
      }      
      if (response.moh_contribution) {
        this.project.moh_contribution = response.moh_contribution;
      }
      if(response.implementing_partners){
          this.project.implementing_partners = response.implementing_partners
        }
      if (response.funding_sources) {
        this.project.funding_sources = response.funding_sources;
      }
      if (response.business_model) {
        this.project.business_model = response.business_model;
      }
      if (response.category_of_evidence) {
        this.project.category_of_evidence = response.category_of_evidence;
      }
      if (response.publications) {
        this.project.publications = response.publications;
      }
      if (response.key_challenges_recommendations) {
        this.project.key_challenges_recommendations = response.key_challenges_recommendations;
      }
      if (response.current_status) {
        this.project.current_status = response.current_status;
      }
      if (response.current_version) {
        this.project.current_version = response.current_version;
      }
      if (response.deployment_locations) {
        this.project.deployment_locations = response.deployment_locations;
      }
      if (response.geographic_scopes) {
        this.project.geographic_scopes = response.geographic_scopes;
      }
      if (response.facility_types) {
        this.project.facility_types = response.facility_types;
      }

      if (response.targeted_users) {
        this.project.targeted_users = response.targeted_users;
      }
    },
  },
};
</script>

<style scoped lang="scss">
:deep(.my-label) {
  background: var(--el-color-primary-light-9) !important;
}
</style>