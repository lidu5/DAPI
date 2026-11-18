<template>
  <div class="app-container">
    <el-descriptions
      class="margin-top"
      title="Interoperability with other systems and the supported data and messaging standards of a given digital agriculture application are explained in this subsection."
      size="large"
      :column="1"
      border
    >
      <el-descriptions-item label="Data standards the DAS uses">
        {{ project.standards.map(standard => standard.name).join(', ') }}
      </el-descriptions-item>
      <el-descriptions-item label="API's has been developed for the DAS">
        {{ project.has_api_support != null ? (project.has_api_support == 1 ? 'Yes' : 'No'): "" }}
      </el-descriptions-item>
      <el-descriptions-item label="The API’s published">
        {{ project.is_api_published != null ? (project.is_api_published == 1 ? 'Yes' : 'No'): "" }}
      </el-descriptions-item>
      <el-descriptions-item label="DAS API is Open API">
        {{ project.is_openapi != null ? (project.is_openapi == 1 ? 'Yes' : 'No'): "" }}
      </el-descriptions-item>
      <el-descriptions-item label="Data from DAS sent to MOA">
        {{ project.data_is_sent_to_moh != null ? (project.data_is_sent_to_moh == 1 ? 'Yes' : 'No') : "" }}
      </el-descriptions-item>
      <el-descriptions-item label="How often the data is updated">
        {{ project.data_update_frequency ? project.data_update_frequency.name : '' }}
      </el-descriptions-item>
      <el-descriptions-item label="Does the system hold personal data">
        {{ project.holds_personal_data != null ? (project.holds_personal_data == 1 ? 'Yes' : 'No') : '' }}
      </el-descriptions-item>
      <el-descriptions-item label="Identifier the system uses for the people or things it records">
        {{ project.identifier_type ? project.identifier_type.name : '' }}
      </el-descriptions-item>
      <el-descriptions-item label="Is that identifier linked to Fayda, the national digital ID">
        {{ project.identifier_linked_to_fayda || '' }}
      </el-descriptions-item>
      <el-descriptions-item label="Are there other systems the system receives data from">
        {{ project.receives_data_from_other_systems != null ? (project.receives_data_from_other_systems == 1 ? 'Yes' : 'No') : '' }}
      </el-descriptions-item>
      <el-descriptions-item v-if="project.receives_data_from_other_systems == 1" label="Which other systems the system receives data from">
        {{ project.receives_data_from || '' }}
      </el-descriptions-item>
      <el-descriptions-item label="Are there other systems that receive data from it">
        {{ project.sends_data_to_other_systems != null ? (project.sends_data_to_other_systems == 1 ? 'Yes' : 'No') : '' }}
      </el-descriptions-item>
      <el-descriptions-item v-if="project.sends_data_to_other_systems == 1" label="Which other systems receive data from it">
        {{ project.sends_data_to || '' }}
      </el-descriptions-item>
      <el-descriptions-item v-if="project.receives_data_from_other_systems == 1 || project.sends_data_to_other_systems == 1" label="How data is exchanged with those systems">
        {{ project.data_exchange_types ? project.data_exchange_types.map((exchange) => exchange.name).join(', ') : '' }}
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
      this.project.data_update_frequency = this.project.data_update_frequency ? this.project.data_update_frequency.id : null
      this.project.holds_personal_data = this.project.holds_personal_data != null ? (this.project.holds_personal_data == true ? 1 : 0) : null
      this.project.identifier_type = this.project.identifier_type ? this.project.identifier_type.id : null
      this.project.data_exchange_type = this.project.data_exchange_types ? this.project.data_exchange_types.map((exchange) => exchange.id) : []
      this.project.receives_data_from_other_systems = this.project.receives_data_from_other_systems != null ? (this.project.receives_data_from_other_systems == true ? 1 : 0) : null
      this.project.sends_data_to_other_systems = this.project.sends_data_to_other_systems != null ? (this.project.sends_data_to_other_systems == true ? 1 : 0) : null

      this.dialogVisible = true;
    },
    updateProject(response) {
      if(response.standards){
          this.project.standards = response.standards
        }
        this.project.has_api_support = response.has_api_support
        this.project.is_api_published = response.is_api_published
        this.project.data_is_sent_to_moh = response.data_is_sent_to_moh
        this.project.data_update_frequency = response.data_update_frequency
        this.project.holds_personal_data = response.holds_personal_data
        this.project.identifier_type = response.identifier_type
        this.project.identifier_linked_to_fayda = response.identifier_linked_to_fayda
        this.project.receives_data_from = response.receives_data_from
        this.project.sends_data_to = response.sends_data_to
        this.project.data_exchange_types = response.data_exchange_types
        this.project.receives_data_from_other_systems = response.receives_data_from_other_systems
        this.project.sends_data_to_other_systems = response.sends_data_to_other_systems        
    },
  },
};
</script>

<style scoped lang="scss">
:deep(.my-label) {
  background: var(--el-color-primary-light-9) !important;
}
</style>