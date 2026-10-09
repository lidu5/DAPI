<template>
  <p>Other uncategorized questions which are very important to explain a given digital health project are sectioned in this subsection.</p>
  <el-form
    ref="ruleFormRef"
    :model="project"
    :rules="rules"
    :label-position="'top'"
    class="demo-ruleForm"
    :size="formSize"
  >
    <el-form-item label="Can you upload your project LOGO">
      <el-col :span="12">
        <el-upload
        class="upload-demo"
        drag
        action="#"
        accept="image/*"
        :show-file-list="false"
        :on-change="handleAvatarSuccess"
        :auto-upload="false"
        >
          <el-icon class="el-icon--upload"><upload-filled /></el-icon>
          <div class="el-upload__text">
            Drop file here or <em>click to upload</em>
          </div>
          <template #tip>
          <div class="el-upload__tip">
              files with a size less than 10mb
          </div>
          </template>
        </el-upload>
      </el-col>
      <el-col :span="12">
        <img v-if="project.logo" :src="project.logo" width="200" height="200"/>
      </el-col>

    </el-form-item>
    <el-form-item label="Bandwidth">
      <el-input v-model="project.bandwidth"  :maxlength="255" show-word-limit />
    </el-form-item>
    <el-form-item label="Who provides maintenance and support for the DAS?">
      <el-input v-model="project.supports"  :maxlength="255" show-word-limit />
    </el-form-item>
    <el-form-item label="Has there been an impact evaluation?">
      <el-select v-model="project.has_impact_evaluation" placeholder="please select">
        <el-option label="Yes" :value="1" />
        <el-option label="No" :value="0" />
      </el-select>
    </el-form-item> 
    <el-form-item v-if="project.has_impact_evaluation" label='If "Yes", Upload impact evaluation assessment documented'>
      <el-col :span="12">
        <el-upload
        class="upload-demo"
        drag
        action="#"
        :show-file-list="false"
        :on-change="handleImpactEvaluation"
        :auto-upload="false"
        >
          <el-icon class="el-icon--upload"><upload-filled /></el-icon>
          <div class="el-upload__text">
            Drop file here or <em>click to upload</em>
          </div>
          <template #tip>
          <div class="el-upload__tip">
              files with a size less than 10mb
          </div>
          </template>
        </el-upload>
      </el-col>
      <el-col :span="12">
        <a v-if="project.impact_evaluation" :href="project.impact_evaluation" target="_blank">
          <el-button class="filter-item" type="primary">
            <el-icon class="el-icon--left"><Download /></el-icon> {{ 'Download' }}
          </el-button>
        </a>
      </el-col>
    </el-form-item>
  </el-form>
</template>

<script>
import { ref } from 'vue'

import Resource from '@/api/resource';
const getFormData = new Resource('registration/form-data');

import DHPI from '@/api/project';
const dhpi = new DHPI();

export default {
  data(){
    return {
      formSize: ref('default'),
      rules: {},
    }
  },
  props: {
    project: {
      type: Object,
    },
  },
  methods: {
    handleAvatarSuccess(file) {      
      const data = new FormData();
      data.append('file',file.raw);
      
      dhpi
        .logo(this.project.id, data)
        .then((response) => {
          this.project.logo = response.data.logo
          this.$message({
            message: 'Project logo uploaded!',
            type: 'success',
          });
        })
        .catch((err) => {
          console.log("error", err);
        })
        .finally(() => {
          this.loading = false
        });
    },
    handleImpactEvaluation(file){
      const data = new FormData();
      data.append('file',file.raw);
      
      dhpi
        .impact_evaluation(this.project.id, data)
        .then((response) => {
          this.project.impact_evaluation = response.data.impact_evaluation
          this.$message({
            message: 'Project impact evaluation uploaded!',
            type: 'success',
          });
        })
        .catch((err) => {
          console.log("error", err);
        })
        .finally(() => {
          this.loading = false
        });
    },
    async validate(){
      return new Promise((resolve, reject) => {
        this.$refs.ruleFormRef.validate( (valid, fields) => {
          if (valid) {
            dhpi.store(this.project)
              .then(response => {
                resolve(response.data);
              })
              .catch(err => {
                console.log('error', err)
                reject(false);
              })
              .finally(() => {
                
              })
          } else {
            console.log('error submit!', fields)
            reject(false);
          }        
        })
      });
    },
    async getFormDatas(){
      const data = await getFormData.list({type: 'support,locations'});
      this.project.works = data.works;
      this.project.professions = data.professions;
      this.project.locations = data.locations;
    },
  },
  created() {
    this.getFormDatas()
  }
}
</script>

<style scoped>
 .upload-demo{
     width: 100%
 }

.el-select{
  width: 100%;
}

</style>