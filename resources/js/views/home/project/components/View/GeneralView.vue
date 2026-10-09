<template>
  <div class="app-container">
    <el-descriptions
      class="margin-top"
      title="General information about the Digital Health Solution (DHS)"
      size="large"
      :column="1"
      border
    >
      <el-descriptions-item label="DHS name">
        {{ project.name }}
      </el-descriptions-item>
      <el-descriptions-item label="Lead organization">
        {{ project.organization.name }}
      </el-descriptions-item>
      <el-descriptions-item label="Investment Partners">
        {{ project.partners.map((partner) => partner.name).join(", ") }}
      </el-descriptions-item>
      <el-descriptions-item label="eHealth Architecture component the DHS aligns to">
        {{ project.components.map(component => component.name).join(', ') }}
      </el-descriptions-item>
      <el-descriptions-item label="Service and Application Type the DHS aligns to">
        {{ project.application_types.map(application_type => application_type.name).join(', ') }}
      </el-descriptions-item>
      <el-descriptions-item label="DHS start date">
        {{ project.start_date }}
      </el-descriptions-item>
      <el-descriptions-item label="DHS end date">
        {{ project.end_date }}
      </el-descriptions-item>
      <el-descriptions-item label="Contact name">
        {{ project.contact_name }}
      </el-descriptions-item>
      <el-descriptions-item label="Contact email">
        {{ project.contact_email }}
      </el-descriptions-item>
      <el-descriptions-item label="Contact phone">
        {{ project.contact_phone }}
      </el-descriptions-item>
      <el-descriptions-item label="Objective">
        {{ project.objective }}
      </el-descriptions-item>
      <el-descriptions-item v-if="frontend" label="Budget">
        {{ project.budget }}
      </el-descriptions-item>
      <el-descriptions-item v-if="frontend" label="Legal Document">
        <template v-if="project.legal_document">
          <el-button
            v-if="isPreviewable(project.legal_document)"
            class="filter-item"
            type="primary"
            link
            @click="openLegalDocument(project.legal_document)"
          >
            <el-icon class="el-icon--left"><Download /></el-icon> View Legal Document
          </el-button>
          <a
            v-else
            :href="project.legal_document"
            download
          >
            <el-button class="filter-item" type="primary" link>
              <el-icon class="el-icon--left"><Download /></el-icon> Download Legal Document
            </el-button>
          </a>
        </template>
      </el-descriptions-item>
      <el-descriptions-item label="Project Website Link">
         <el-link type="primary" :href="project.project_website_link" target="_blank">{{ project.project_website_link }}</el-link>
      </el-descriptions-item>
      <el-descriptions-item label="Keywords">
        <span v-if="project.keywords">
          <span
            v-for="(keyword, index) in formatKeywords(project.keywords)"
            :key="index"
            class="keyword-tag"
          >
            {{ keyword }}
          </span>
        </span>
      </el-descriptions-item>

      <el-descriptions-item label="Summary">
        {{ project.summary }}
      </el-descriptions-item>
      <el-descriptions-item 
        v-if="editor" 
        v-permission="['edit project']"
        label-class-name="my-label"
      >
        <el-button type="primary" plain @click="openUpdateDialog()">
          Edit General Information
        </el-button>
      </el-descriptions-item>
    </el-descriptions>
  </div>
  <el-dialog v-if="editor" title="General" v-model="dialogVisible" width="70%">
    <General :project="project" ref="General" />
    <template #footer>
      <el-button @click="dialogVisible = false">
        {{ $t("table.cancel") }}
      </el-button>
      <el-button type="primary" @click="update()"> Update </el-button>
    </template>
  </el-dialog>
  <el-dialog
  title="Legal Document"
  v-model="legalDialogVisible"
  width="80%"
>
  <iframe
    v-if="legalDocumentUrl"
    :src="legalDocumentUrl"
    width="100%"
    height="600px"
    style="border: none;"
  ></iframe>
  <template #footer>
    <el-button @click="legalDialogVisible = false">Close</el-button>
  </template>
</el-dialog>
</template>

<script>
import General from "../General.vue";
import { mapGetters } from 'vuex';

export default {
  name: "General View",
  data() {
    return {
      dialogVisible: false,
      legalDialogVisible: false,
       legalDocumentUrl: "",

    };
  },
  computed: {
    ...mapGetters([
      'userId', 'roles'
    ]),
    editor() {
      if (!this.edit) return false;

      if (this.project.status !== "new" && 
          this.project.status !== "registration rejected" && 
          this.project.status !== "cert competence rejected" && 
          this.project.user_id === this.userId
      ) return false;
      
      if (this.project.user_id === this.userId) {
        return true;
      } else if (this.roles.includes('admin')) {
        return true;
      }

      return false;
    }
  },
  props: {
    project: {
      type: Object,
    },
    edit: {
      type: Boolean,
      default: true
    },
    frontend:{
      type: Boolean,
      default: true

    }
  },
  components: { General },
  methods: {
  isPreviewable(fileUrl) {
  const previewableExtensions = ['pdf', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'webp', 'txt'];
  const extension = fileUrl.split('.').pop().toLowerCase();
  return previewableExtensions.includes(extension);
},
     openLegalDocument(url) {
    this.legalDocumentUrl = url;
    this.legalDialogVisible = true;
  },
    async update() {
      const validate = await this.$refs["General"].validate().catch((err) => {
        return err;
      });
      if (validate) {
        this.updateProject(validate)
        this.dialogVisible = false
      }
      
    },
    
    openUpdateDialog() {
      this.project.lead_organization = this.project.organization.id;
      this.project.component = this.project.components[0]?.id;      
      this.project.application_type = this.project.application_types[0]?.id;     
      this.project.partner = this.project.partners.map(partner => partner.id);
      this.project.legal_document = this.project.legal_document;

      this.dialogVisible = true
    },
    updateProject(response){
        if(response.id){
          this.project.id = response.id
        }
        if(response.uuid){
          this.project.uuid = response.uuid
        }
        if(response.name){
          this.project.name = response.name
        }
        if(response.start_date){
          this.project.start_date = response.start_date
        }
        if(response.end_date){
          this.project.end_date = response.end_date
        }
        if(response.contact_name){
          this.project.contact_name = response.contact_name
        }
        if(response.contact_email){
          this.project.contact_email = response.contact_email
        }
        if(response.contact_phone){
          this.project.contact_phone = response.contact_phone
        }
        if(response.objective){
          this.project.objective = response.objective
        }
        if(response.project_website_link){
          this.project.project_website_link = response.project_website_link
        }
        if(response.keywords){
          this.project.keywords = response.keywords
        }
        if(response.summary){
          this.project.summary = response.summary
        }
        if(response.organization){
          this.project.organization = response.organization
        }
        if(response.partners){
          this.project.partners = response.partners
        }
        if(response.application_types){
          this.project.application_types = response.application_types
        }
        if(response.components){
          this.project.components = response.components;
        }
        if(response.legal_document){
          this.project.legal_document = response.legal_document
        }
      },

      formatKeywords(keywords) {
        return keywords
          .split(',')
          .map(k => k.trim().replace(/\s+/g, '_'))
          .filter(k => k.length > 0)
          .map(k => `#${k}`);
      }

  }
};
</script>

<style scoped lang="scss">
:deep(.my-label) {
  background: var(--el-color-primary-light-9) !important;
}

.keyword-tag {
  margin-right: 8px;
  color: #1172b5;
  font-weight: bold;
}

</style>