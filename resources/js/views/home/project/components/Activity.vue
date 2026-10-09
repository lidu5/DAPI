<template>
  <p>Digital health interventions of the application</p>
  <el-form
    ref="ruleFormRef"
    :model="activity"
    :rules="rules"
    :label-position="'top'"
    class="demo-ruleForm"
    :size="formSize"
  >
    <el-form-item label="Activity Name" prop="name">
      <el-input v-model="activity.name" :maxlength="255" show-word-limit />
    </el-form-item>

    <el-form-item label="Digital Health Interventions">
      <el-row v-if="project.interventions_type" v-for="interv_type in project.interventions_type">
        <el-col :span="4">
          <h4>{{ interv_type }}</h4>
        </el-col>
        <el-col :span="20">
          <el-checkbox-group v-model="activity.dhi">
            <el-checkbox
              v-for="intervention in project.interventions.filter((intervention) => intervention.type === interv_type)"
              :label="intervention.id"
              name="intervention"
            >
              {{ intervention.name }}
              <el-tooltip class="box-item" effect="dark" :content="intervention.category" placement="bottom-start">
                <el-icon><InfoFilled /></el-icon>
              </el-tooltip>
            </el-checkbox>
          </el-checkbox-group>
        </el-col>
      </el-row>
    </el-form-item>

    <el-form-item label="Description" prop="description" required>
      <el-input v-model="activity.description" :rows="6" type="textarea" :maxlength="255" show-word-limit />
    </el-form-item>

    <el-form-item>
      <el-button type="primary" :loading="loading" @click="registerActivity()">
        Register Activity
      </el-button>
    </el-form-item>
  </el-form>

  <activity-list :activities="project.activities" :project_id="project.id" :user_id="project.user_id" />
</template>

<script>
import { ref } from 'vue';
import Resource from '@/api/resource';
import DHPI from '@/api/project';
import ActivityList from './ActivityList';

const getFormData = new Resource('registration/form-data');
const dhpi = new DHPI();

export default {
  data() {
    return {
      formSize: ref('default'),
      rules: {
        name: [{ required: true, message: 'Please input activity name', trigger: 'blur' }],
        description: [{ required: true, message: 'Please input activity description', trigger: 'blur' }],
      },
      activity: {},
      loading: false,
    };
  },

  components: {
    ActivityList,
  },

  props: {
    project: {
      type: Object,
    },
  },

  methods: {
    async registerActivity() {
      this.$refs.ruleFormRef.validate((valid, fields) => {
        if (valid) {
          if (this.project.activities && this.project.activities.some(activity => activity.name === this.activity.name)) {
            this.$message({
              message: `Activity with ${this.activity.name} already created.`,
              type: 'error',
              duration: 5000,
            });
            return false;
          }

          this.loading = true;
          this.project.activity = this.activity;
          dhpi.store(this.project)
            .then((response) => {
              this.project.activities = response.data.activities;
              this.project.activity = {};
              this.activity = {};
            })
            .catch((err) => {
              console.log('error', err);
            })
            .finally(() => {
              this.loading = false;
            });
        } else {
          console.log('error submit!', fields);
        }
      });
    },

    async validate() {
      return new Promise((resolve) => {
        resolve(this.project);
      });
    },

    async getFormDatas() {
      const data = await getFormData.list({ type: 'interventions' });
      this.project.interventions = data.interventions;
      this.project.interventions_type = [...new Set(data.interventions.map((item) => item.type))];
    },
  },

  created() {
    this.getFormDatas();
  },
};
</script>

<style scoped>
.el-select {
  width: 100%;
}

.el-row {
  width: 100%;
  background-color: #cececea4;
}

.el-col h4 {
  text-align: left;
}

.el-col .el-checkbox-group .el-checkbox {
  float: left;
}
</style>
