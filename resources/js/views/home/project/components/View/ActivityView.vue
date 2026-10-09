<template>
  <div class="app-container">
    <p>Digital health interventions of the application</p>
    <el-row v-if="editor" v-permission="['edit project']">
      <el-button
        class="filter-item"
        type="primary"
        @click="dialogVisible = true"
      >
        <el-icon class="el-icon--left"><Plus /></el-icon> {{ $t("table.add") }}
      </el-button>
    </el-row>
    <activity-list :activities="activitiesList" :project_id="id" :user_id="user_id" :edit="edit"/>
  </div>
  <el-dialog v-if="editor" title="Activity" v-model="dialogVisible" width="70%">
    <el-form
      ref="ruleFormRef"
      :model="activity"
      :label-position="'top'"
      class="demo-ruleForm"
    >
      <el-form-item label="Activity Name">
        <el-input v-model="activity.name" :maxlength="255" show-word-limit />
      </el-form-item>
      <el-form-item label="Digital Health Interventions">
      <el-row v-if="interventions_type" v-for="interv_type in interventions_type">
        <el-col :span="4">
          <h4>{{ interv_type }}</h4>
        </el-col>
        <el-col :span="20">
          <el-checkbox-group v-model="activity.dhi">
            <el-checkbox
              v-for="intervention in interventions.filter((intervention) => intervention.type === interv_type)"
              :label="intervention.id"
              name="intervention"
              >
                {{ intervention.name }}
                <el-tooltip    
                  class="box-item"
                  effect="dark"
                  :content=intervention.category
                  placement="bottom-start"
                >
                <el-icon><InfoFilled /></el-icon>
                </el-tooltip>
              </el-checkbox>            
          </el-checkbox-group>          
        </el-col>        
      </el-row>
    </el-form-item>
      <el-form-item label="Description">
        <el-input v-model="activity.description" :rows="6" type="textarea"  :maxlength="255" show-word-limit />
      </el-form-item>
    </el-form>
    <template #footer>
      <el-button @click="dialogVisible = false">
        {{ $t("table.cancel") }}
      </el-button>
      <el-button type="primary" @click="add()"> Register Activity </el-button>
    </template>
  </el-dialog>
</template>

<script>
import ActivityList from "../ActivityList";
import { mapGetters } from 'vuex';

import DHPI from "@/api/project";
const dhpi = new DHPI();

import Resource from "@/api/resource";
const getFormData = new Resource("registration/form-data");

export default {
  name: "Activity View",
  props: {
    activities: {
      type: Array,
      default: [],
    },
    id: {
      type: Number,
    },
    user_id: {
      type: Number,
    },
    edit: {
      type: Boolean,
      default: true
    }
  },
  components: {
    ActivityList,
  },
  data() {
    return {
      dialogVisible: false,
      activity: {},
      interventions: [],
      interventions_type: [],
      activitiesList: this.activities,
    };
  },
  computed: {
    ...mapGetters([
      'userId', 'roles'
    ]),
    editor(){
      if(!this.edit)
        return false
      
      if(this.user_id === this.userId){
        return true
      }else if(this.roles.includes('admin')){
        return true
      }

      return false
    }
  },
  created() {
    this.getFormDatas();
  },
  methods: {
    async add() {
      if (
        this.activitiesList &&
        this.activitiesList.some(
          (activity) => activity.name === this.activity.name.trim()
        )
      ) {
        this.$message({
          message: `Activity with ${this.activity.name} already created.`,
          type: "error",
          duration: 5 * 1000,
        });
        return false;
      }

      const project = {
        id: this.id,
        activity: this.activity,
      };
      dhpi
        .store(project)
        .then((response) => {
          this.activitiesList = response.data.activities;
          this.activity = {};
          this.dialogVisible = false;
        })
        .catch((err) => {
          console.log("error", err);
        });
    },
    async getFormDatas() {
      const data = await getFormData.list({ type: "interventions" });
      this.interventions = data.interventions;
      this.interventions_type =  [...new Set(data.interventions.map((item) => item.type))];
    },
  },
};
</script>
