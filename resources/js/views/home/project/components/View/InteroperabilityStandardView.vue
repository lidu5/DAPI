<template>
  <div class="app-container">
    <el-descriptions
      class="margin-top"
      title="Interoperability with other systems and the supported data and messaging standards of a given digital health application are explained in this subsection."
      size="large"
      :column="1"
      border
    >
      <el-descriptions-item label="The DHS is FHIR compliant">
        {{ project.fhir_compliant != null ? (project.fhir_compliant == 1 ? "Yes" : "No") : "" }}
      </el-descriptions-item>
      <el-descriptions-item label="Data standards the DHS uses">
        {{ project.standards.map(standard => standard.name).join(', ') }}
      </el-descriptions-item>
      <el-descriptions-item label="API's has been developed for the DHS">
        {{ project.has_api_support != null ? (project.has_api_support == 1 ? 'Yes' : 'No'): "" }}
      </el-descriptions-item>
      <el-descriptions-item label="The API’s published">
        {{ project.is_api_published != null ? (project.is_api_published == 1 ? 'Yes' : 'No'): "" }}
      </el-descriptions-item>
      <el-descriptions-item label="DHS API is Open API">
        {{ project.is_openapi != null ? (project.is_openapi == 1 ? 'Yes' : 'No'): "" }}
      </el-descriptions-item>
      <el-descriptions-item label="Data from DHS sent to MOH">
        {{ project.data_is_sent_to_moh != null ? (project.data_is_sent_to_moh == 1 ? 'Yes' : 'No') : "" }}
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
  <el-dialog v-if="editor" title="Interoperability Standard" v-model="dialogVisible" width="70%">
    <Interoperability_Standard :project="project" ref="Interoperability_Standard" />
    <template #footer>
      <el-button @click="dialogVisible = false">
        {{ $t("table.cancel") }}
      </el-button>
      <el-button type="primary" @click="update()"> Update </el-button>
    </template>
  </el-dialog>
</template>

<script>
import Interoperability_Standard from "../Interoperability_Standard.vue";
import { mapGetters } from 'vuex';

export default {
  name: "Interoperability Standard View",
  props: {
    project: {
      type: Object
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
    Interoperability_Standard,
  },
  methods: {
    async update() {
      const validate = await this.$refs["Interoperability_Standard"]
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
      console.log(this.project)
      this.project.standard = this.project.standards.map(
        (standard) => standard.id
      );
      this.project.has_api_support = this.project.has_api_support != null ? (this.project.has_api_support == true ? 1 : 0) : null
      this.project.is_api_published = this.project.is_api_published != null ? (this.project.is_api_published == true ? 1 : 0) : null
      this.project.data_is_sent_to_moh = this.project.data_is_sent_to_moh != null ? (this.project.data_is_sent_to_moh == true ? 1 : 0) : null
      this.project.is_openapi = this.project.is_openapi != null ? (this.project.is_openapi == true ? 1 : 0) : null
      this.project.fhir_compliant = this.project.fhir_compliant != null ? (this.project.fhir_compliant == true ? 1 : 0) : null

      this.dialogVisible = true;
    },
    updateProject(response) {
      if(response.standards){
          this.project.standards = response.standards
        }
        this.project.has_api_support = response.has_api_support
        this.project.is_api_published = response.is_api_published
        this.project.data_is_sent_to_moh = response.data_is_sent_to_moh        
    },
  },
};
</script>

<style scoped lang="scss">
:deep(.my-label) {
  background: var(--el-color-primary-light-9) !important;
}
</style>