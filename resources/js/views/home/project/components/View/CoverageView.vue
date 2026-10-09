<template>
  <div class="app-container">
    <p>
      The maturity level of the system in terms of coverage related to
      geographical, and system project.coverage.
    </p>
    <el-row v-if="editor" v-permission="['edit project']">
      <el-button class="filter-item" type="primary" @click="dialogVisible = true">
        <el-icon class="el-icon--left"><Plus /></el-icon> {{ $t("table.add") }}
      </el-button>
    </el-row>
    <coverage-list :coverages="coveragesList" :project_id="id" :user_id="user_id" :edit="edit"/>
  </div>
  <el-dialog v-if="editor" title="Coverage" v-model="dialogVisible" width="30%">
    <el-form
      ref="ruleFormRef"
      :model="coverage"
      :label-position="'top'"
      class="demo-ruleForm"
    >
      <el-form-item label="Coverage/Region">
        <el-select v-model="coverage.region" placeholder="please select">
          <el-option
            v-for="region in regions"
            :key="region.id"
            :label="region.name"
            :value="region.id"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="Number of users">
        <el-input v-model="coverage.num_hw_users" type="number" />
      </el-form-item>
      <!-- <el-form-item label="Number of facilities">
        <el-input v-model="coverage.num_hw_facilities" type="number" />
      </el-form-item> -->
      <el-form-item label="Estimated number of clients">
        <el-input v-model="coverage.num_clients" type="number" />
      </el-form-item>
    </el-form>
    <template #footer>
      <el-button @click="dialogVisible = false">
        {{ $t("table.cancel") }}
      </el-button>
      <el-button type="primary" @click="add()"> Register Coverage </el-button>
    </template>
  </el-dialog>
</template>

<script>
import CoverageList from "../CoverageList";
import { mapGetters } from 'vuex';

import DHPI from "@/api/project";
const dhpi = new DHPI();

import Resource from "@/api/resource";
const getFormData = new Resource("registration/form-data");

export default {
  name: "Coverage View",
  props: {
    coverages: {
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
  data() {
    return {
      dialogVisible: false,
      coverage: {},
      regions: {},
      coveragesList: this.coverages
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
  components: {
    CoverageList,
  },
  methods: {
    async add() {
      const project = {
        id: this.id,
        coverage: this.coverage,
      }
      dhpi
        .store(project)
        .then((response) => {
          this.coveragesList = response.data.coverages;
          this.coverage = {};
          this.dialogVisible = false;
        })
        .catch((err) => {
          console.log("error", err);
        });
    },
    async getFormDatas() {
      const data = await getFormData.list({ type: "regions" });
      this.regions = data.regions.filter((regi) => regi.name != 'National');
    }
  },
};
</script>
