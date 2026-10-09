<template>
  <p>
    The maturity level of the system in terms of coverage related to
    geographical, and system project.coverage.
  </p>
  <el-form
    ref="ruleFormRef"
    :model="coverage"
    :rules="rules"
    :label-position="'top'"
    class="demo-ruleForm"
    :size="formSize"
  >
    <el-form-item label="Coverage/Region">
      <el-select v-model="coverage.region" placeholder="please select">
        <el-option
          v-for="region in project.regions"
          :key="region.id"
          :label="region.name"
          :value="region.id"
        />
      </el-select>
    </el-form-item>
    <el-form-item label="Number of  users">
      <el-input v-model="coverage.num_hw_users" type="number" />
    </el-form-item>
    <!-- <el-form-item label="Number of facilities">
      <el-input v-model="coverage.num_hw_facilities" type="number" />
    </el-form-item> -->
    <el-form-item label="Estimated number of clients">
      <el-input v-model="coverage.num_clients" type="number" />
    </el-form-item>
    <el-form-item>
      <el-button type="primary" :loading="loading" @click="registerCoverage()">
        Register Coverage
      </el-button>
    </el-form-item>    
  </el-form>
  <coverage-list :coverages="project.coverages" :project_id="project.id" :user_id="project.user_id"/>
</template>

<script>
import { ref } from "vue";

import CoverageList from "./CoverageList";

import Resource from "@/api/resource";
const getFormData = new Resource("registration/form-data");

import DHPI from "@/api/project";
const dhpi = new DHPI();

export default {
  components: {
    CoverageList,
  },
  data() {
    return {
      formSize: ref("default"),
      rules: {},
      loading: false,
      coverage: {}
    };
  },
  props: {
    project: {
      type: Object,
    },
  },
  methods: {
    async registerCoverage() {
      this.$refs.ruleFormRef.validate((valid, fields) => {
        if (valid) {
          this.loading = true
          this.project.coverage = this.coverage
          dhpi
            .store(this.project)
            .then((response) => {
              this.project.coverages = response.data.coverages
              this.project.coverage = {}
              this.coverage = {}
            })
            .catch((err) => {
              console.log("error", err);
            })
            .finally(() => {
              this.loading = false
            });
        } else {
          console.log("error submit!", fields);
        }
      });
    },
    async validate() {
      return new Promise((resolve, reject) => {
        resolve(this.project);
      });
    },
    async getFormDatas() {
      const data = await getFormData.list({ type: "regions" });
      this.project.regions = data.regions.filter((regi) => regi.name != 'National');
    }
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
</style>
