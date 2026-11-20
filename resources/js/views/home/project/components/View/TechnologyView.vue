<template>
  <div class="app-container">
    <el-descriptions
      class="margin-top"
      title="Technology used in the development, deployment of the digital agriculture solution (DAS)"
      size="large"
      :column="1"
      border
    >
      <el-descriptions-item label="Golive date of the DAS">
        {{ project.golive_date }}
      </el-descriptions-item>
      <el-descriptions-item label="License the DAS is governed">
        {{ project.license != null ? project.license.name : "" }}
      </el-descriptions-item>
      <el-descriptions-item label="OSI Approved License(s) used">
        {{ 
          project.osi_licenses
            .map((osi_license) => osi_license.name)
            .join(", ")
        }}
      </el-descriptions-item>
      <el-descriptions-item label="DAS source code owner">
        {{
          project.ownership_type
            .map((ownership_typ) => ownership_typ.name)
            .join(", ")
        }}
      </el-descriptions-item>
      <el-descriptions-item label="If the answer above is government, which government office owns the
          source code?">
          {{ project.owner }}
      </el-descriptions-item>
      <el-descriptions-item label="Link to the DAS documentation">
        <el-link type="primary" :href="project.documentation_link">{{ project.documentation_link }}</el-link>
      </el-descriptions-item>
      <el-descriptions-item label="When was the documentation last updated">
        {{ project.documentation_last_updated || '' }}
      </el-descriptions-item>
      <el-descriptions-item label="Link to the software wiki page">
        <el-link type="primary" :href="project.wiki_page">{{ project.wiki_page }}</el-link>
      </el-descriptions-item>
      <el-descriptions-item label="Link to the version control (git)">
        <el-link type="primary" :href="project.git_link">{{ project.git_link }}</el-link>
      </el-descriptions-item>
      <el-descriptions-item label="Types of application (platform)">
        {{
          project.applications
            .filter(application => application.name !== 'Other')
            .map(application => application.name)
            .join(", ") 
        }}

        <div v-if="project.other_typeof_applications">
          {{
            project.other_typeof_applications
          }}
        </div>
      </el-descriptions-item>
      <el-descriptions-item label="Operating system(s) the DAS supports">
        {{
            project.operating_systems
              .filter(operating_system => operating_system.name !== 'Other')
              .map((operating_system) => operating_system.name)
              .join(", ")
          }}
        <div v-if="project.other_operating_systems">
          {{
            project.other_operating_systems
          }}
        </div>
      </el-descriptions-item>
      <el-descriptions-item label=" Programming languages used for the DAS">
        {{ project.languages.map((language) => language.name).join(", ") }}
      </el-descriptions-item>
      <el-descriptions-item label="Frameworks used for the DAS">
        {{ project.frameworks
          .filter(framework => framework.name !== 'Other')
          .map((framework) => framework.name)
          .join(", ") 
        }}
        <div v-if="project.other_frameworks" class="grid-content answers">
          {{
            project.other_frameworks
          }}
        </div>
      </el-descriptions-item>
      <el-descriptions-item label="Database (DBMS) the DAS uses">
        {{ project.databases
            .filter(database => database.name !== 'Other')
            .map((database) => database.name)
            .join(", ") 
        }}
        <div v-if="project.other_databases">
          {{
            project.other_databases
          }}
        </div>
      </el-descriptions-item>
      <el-descriptions-item label="Other third-party tools the DAS depends on">
        {{ project.third_party_tools }}
      </el-descriptions-item>
      <el-descriptions-item label="Was it built from scratch or on something existing">
        {{ project.technology_origin || '' }}
      </el-descriptions-item>
      <el-descriptions-item label="Does the system work offline">
        {{ project.works_offline || '' }}
      </el-descriptions-item>
      <el-descriptions-item label="Is there a backup of the system data">
        {{ project.data_backup || '' }}
      </el-descriptions-item>
      <el-descriptions-item v-if="project.data_backup === 'Yes: automated' || project.data_backup === 'Yes: manual'" label="How often is it backed up">
        {{ project.backup_frequency || '' }}
      </el-descriptions-item>
      <el-descriptions-item v-if="project.data_backup === 'Yes: automated' || project.data_backup === 'Yes: manual'" label="Where are backups stored">
        {{ project.backup_location || '' }}
      </el-descriptions-item>
      <el-descriptions-item v-if="project.data_backup === 'Yes: automated' || project.data_backup === 'Yes: manual'" label="Has a restore from backup been tested">
        {{ project.restore_tested || '' }}
      </el-descriptions-item>
      <el-descriptions-item label="Has the system been certified by INSA">
        {{ project.insa_certified || '' }}
      </el-descriptions-item>
      <el-descriptions-item v-if="project.insa_certified === 'Yes'" label="Security clearance">
        <el-link v-if="project.security_clearance" type="primary" :href="project.security_clearance" target="_blank">View Uploaded</el-link>
      </el-descriptions-item>
      <el-descriptions-item label="Has the system been formally handed over to MOA ICT">
        {{ project.moa_ict_handover || '' }}
      </el-descriptions-item>
      <el-descriptions-item v-if="project.moa_ict_handover === 'Yes'" label="Handover evidence">
        <el-link v-if="project.handover_document" type="primary" :href="project.handover_document" target="_blank">View Uploaded</el-link>
      </el-descriptions-item>
      <el-descriptions-item label="Which languages is the system available in">
        {{ project.system_languages ? project.system_languages.map((language) => language.name).join(', ') : '' }}
      </el-descriptions-item>
      <el-descriptions-item 
        v-if="editor" 
        v-permission="['edit project']"
        label-class-name="my-label"
      >
        <el-button type="primary" plain @click="openUpdateDialog()"
            >Edit Technology Information</el-button>
      </el-descriptions-item>
    </el-descriptions>
  </div>
  <el-dialog v-if="editor" title="Technology" v-model="dialogVisible" width="70%">
    <Technology :project="project" ref="Technology" />
    <template #footer>
      <el-button @click="dialogVisible = false">
        {{ $t("table.cancel") }}
      </el-button>
      <el-button type="primary" @click="update()"> Update </el-button>
    </template>
  </el-dialog>
</template>

<script>
import Technology from "../Technology.vue";
import { mapGetters } from 'vuex';

export default {
  name: "Technology View",
  props: {
    project: Object,
    edit: {
      type: Boolean,
      default: true
    }
  },
  components: {
    Technology,
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
  methods: {
    async update() {
      const validate = await this.$refs["Technology"]
        .validate()
        .catch((err) => {
          return err;
        });

      if (validate) {
        this.updateProject(validate);
        this.dialogVisible = false;
      }
    },
    openUpdateDialog() {
      this.project.under_license = this.project.license?.id;
      
      this.project.osi_license = this.project.osi_licenses.map(
        (osi_license) => osi_license.id
      );
      this.project.ownership = this.project.ownership_type[0]?.id

      this.project.application = this.project.applications.map(
        (application) => application.id
      );
      this.project.os = this.project.operating_systems.map(
        (operating_system) => operating_system.id
      );
      this.project.language = this.project.languages.map(
        (language) => language.id
      );
      this.project.framework = this.project.frameworks.map(
        (framework) => framework.id
      );
      this.project.db = this.project.databases.map((database) => database.id);
      this.project.system_language = this.project.system_languages ? this.project.system_languages.map((language) => language.id) : [];
      this.dialogVisible = true;
    },
    updateProject(response) {
      if (response.golive_date) {
        this.project.golive_date = response.golive_date;
      }
      if (response.license) {
        this.project.license = response.license;
      }
      if (response.osi_licenses) {
        this.project.osi_licenses = response.osi_licenses;
      }
      if (response.ownership_type) {
        this.project.ownership_type = response.ownership_type;
      }
      if (response.owner) {
        this.project.owner = response.owner;
      }
      if (response.documentation_link) {
        this.project.documentation_link = response.documentation_link;
      }
      this.project.documentation_last_updated = response.documentation_last_updated;
      if (response.wiki_page) {
        this.project.wiki_page = response.wiki_page;
      }
      if (response.git_link) {
        this.project.git_link = response.git_link;
      }
      if (response.applications) {
        this.project.applications = response.applications;
      }
      if (response.operating_systems) {
        this.project.operating_systems = response.operating_systems;
      }
      if (response.tech_stacks) {
        this.project.languages = response.tech_stacks.filter((lang) => lang.type == 'Language');
        this.project.frameworks = response.tech_stacks.filter((lang) => lang.type == 'Framework');
      }
      if (response.databases) {
        this.project.databases = response.databases;
      }
      if (response.other_typeof_applications) {
        this.project.other_typeof_applications = response.other_typeof_applications;
      }
      if (response.other_operating_systems) {
        this.project.other_operating_systems = response.other_operating_systems;
      }
      if (response.other_frameworks) {
        this.project.other_frameworks = response.other_frameworks;
      }
      if (response.other_databases) {
        this.project.other_databases = response.other_databases;
      }
      this.project.technology_origin = response.technology_origin;
      this.project.works_offline = response.works_offline;
      this.project.data_backup = response.data_backup;
      this.project.backup_frequency = response.backup_frequency;
      this.project.backup_location = response.backup_location;
      this.project.restore_tested = response.restore_tested;
      this.project.insa_certified = response.insa_certified;
      this.project.security_clearance = response.security_clearance;
      this.project.moa_ict_handover = response.moa_ict_handover;
      this.project.handover_document = response.handover_document;
      this.project.system_languages = response.system_languages;
    },
  },
};
</script>

<style scoped>
:deep(.my-label) {
  background: var(--el-color-primary-light-9) !important;
}
</style>
