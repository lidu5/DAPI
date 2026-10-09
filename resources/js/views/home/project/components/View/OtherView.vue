<template>
  <div class="app-container">
    <el-descriptions
      class="margin-top"
      title="Interoperability with other systems and the supported data and messaging standards of a given digital health application are explained in this subsection."
      size="large"
      :column="1"
      border
    >
      <el-descriptions-item label="Project Logo">
        <img
            v-if="project.logo"
            :src="project.logo"
            width="200"
            height="200"
          />
      </el-descriptions-item>
      <el-descriptions-item label="Bandwidth">
        {{ project.bandwidth }}
      </el-descriptions-item>
      <el-descriptions-item label="Maintenance and Support provider for the DHS">
        {{ project.supports }}
      </el-descriptions-item>
      <el-descriptions-item label="Impact evaluated">
        {{ project.has_impact_evaluation != null ? (project.has_impact_evaluation == 1 ? "Yes" : "No"): "" }}
      </el-descriptions-item>
      <el-descriptions-item label="Impact evaluation assessment document">
        <a v-if="project.impact_evaluation" :href="project.impact_evaluation" target="_blank">
            <el-button class="filter-item" type="primary" link>
              <el-icon class="el-icon--left"><Download /></el-icon> {{ 'Download' }}
            </el-button>
          </a>
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
    <Other :project="project" ref="Other" />
    <template #footer>
      <el-button @click="dialogVisible = false">
        {{ $t("table.cancel") }}
      </el-button>
      <el-button type="primary" @click="update()"> Update </el-button>
    </template>
  </el-dialog>
</template>

<script>
import Other from "../Other.vue";
import { mapGetters } from 'vuex';

export default {
  name: "Other View",
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
    Other,
  },
  methods: {
    async update() {
      const validate = await this.$refs["Other"].validate().catch((err) => {
        return err;
      });

      if (validate) {
        this.updateProject(validate);
        this.dialogVisible = false;
      }
    },
    openUpdateDialog() {

      this.project.has_impact_evaluation = this.project.has_impact_evaluation != null ? (this.project.has_impact_evaluation == true ? 1 : 0) : null

      this.dialogVisible = true;
    },
    updateProject(response) {
      if (response.logo) {
        this.project.logo = response.logo;
      }
      if (response.bandwidth) {
        this.project.bandwidth = response.bandwidth;
      }
      if (response.supports) {
        this.project.supports = response.supports;
      }      
      if (response.has_impact_evaluation) {
        this.project.has_impact_evaluation = response.has_impact_evaluation;
      }
      if (response.impact_evaluation) {
        this.project.impact_evaluation = response.impact_evaluation;
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