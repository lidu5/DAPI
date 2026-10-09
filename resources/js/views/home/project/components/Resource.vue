<template>
  <p>
    Resources related to a given digital health project, which could be documentations, source codes and manuals are attached in this subsection
  </p>
  <el-form
    ref="ruleFormRef"
    :model="resource"
    :rules="rules"
    :label-position="'top'"
    class="demo-ruleForm"
    :size="formSize"
  >
    <el-form-item label="Resources">
      <el-select v-model="resource.title" required placeholder="please select">
        <el-option v-for="resource in resource_options" :key="resource" :label="resource" :value="resource" />
      </el-select>
    </el-form-item>
    <el-form-item label="Description">
      <el-input v-model="resource.description" :rows="6" type="textarea" :maxlength="255" show-word-limit/>
    </el-form-item>
    <el-form-item prop="file">
      <input id="file" type="file" required @change="selectFile">
    </el-form-item>
    <el-form-item>
      <el-button type="primary" :loading="loading" @click="uploadResource()">
        Upload Resource
      </el-button>
    </el-form-item>
    <el-alert type="info" show-icon :closable="false">
      <p>You must attach a "Proof of Safety" document before moving to the next page</p>
    </el-alert>
  </el-form>
  <resource-list :resources="project.resources" :project_id="project.id" :user_id="project.user_id"/>
</template>

<script>
import { ref } from 'vue'

import DHPI from "@/api/project";
const dhpi = new DHPI();

import ResourceList from './ResourceList.vue';

export default {
  data(){
    return {
      formSize: ref('default'),
      rules: {},
      resource: {},
      loading: false,
      resources: [
        'Proof of Safety',
        'User Manual',
        'SRS',
        'Architecture',
        'Developer Manual',
        'Privacy Policy Document',
        'Other'
      ],
    }
  },
  computed: {
    resource_options(){
      return this.resources.filter((res) => {
        if (this.project.resources){
          return !this.project.resources.some((proj) => proj.title === res)
        }
        return true
      })
    }
  },
  components: {
    ResourceList
  },
  props: {
    project: {
      type: Object,
    },
  },
  methods: {
    selectFile(event) {
      this.resource.file = event.target.files[0]
    },
    async uploadResource() {
      this.$refs.ruleFormRef.validate((valid, fields) => {
        if (valid) {
          //Check resource title in the project
          if(this.project.resources && this.project.resources.some(resource => resource.title === this.resource.title)){
            this.$message({
              message: `Resource with ${this.resource.title} already created`,
              type: 'error',
              duration: 5 * 1000,
            });
            return false;
          }

          this.loading = true

          const data = new FormData();
          data.append('file', this.resource.file);
          data.append('title', this.resource.title);
          data.append('description', this.resource.description);
          
          dhpi
            .resource(this.project.id, data)
            .then((response) => {
              this.project.resources = response.data.resources
              this.resource = {}
              document.getElementById('file').value = ''
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
        if (this.project.resources == undefined || !this.project.resources.some((proj) => proj.title === 'Proof of Safety')){
          this.$message({
            message: "You must upload proof of safety document",
            type: "error",
            duration: 5 * 1000,
          });
          reject(false);
          return
        }
        resolve(this.project);
      });
    },
  },
}
</script>

<style scoped>
 .upload-demo{
     width: 100%
 }
</style>