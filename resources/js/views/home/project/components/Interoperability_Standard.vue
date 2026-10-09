<template>
  <el-form
    ref="ruleFormRef"
    :model="project"
    :rules="rules"
    :label-position="'top'"
    :size="formSize"
  >
    <el-form-item label="Is the DAS FHIR compliant?" prop="fhir_compliant">
      <el-select v-model="project.fhir_compliant" required placeholder="please select">
        <el-option label="Yes" :value="1" />
        <el-option label="No" :value="0" />
      </el-select>
    </el-form-item>
  <el-form-item v-if="project.standards_lists" label="Which of these does your system support?" prop="standard">
      <el-row v-if="project.standards_category" v-for="category in project.standards_category">
        <el-col :span="4">
          <h4>{{ category }}</h4>
        </el-col>
        <el-col :span="20">
          <el-checkbox-group v-model="project.standard">
            <el-checkbox
              v-for="standard in project.standards_lists.filter((standard) => standard.category === category)"
              :label="standard.id"
              name="standard"
              >
                {{ standard.name }}
                <el-tooltip    
                  class="box-item"
                  effect="dark"
                  :content=standard.description
                  placement="bottom-start"
                >
                <el-icon><InfoFilled /></el-icon>
                </el-tooltip>
              </el-checkbox>            
          </el-checkbox-group>          
        </el-col>        
      </el-row>
    </el-form-item>
    <el-form-item label="Does API's have been developed for the DAS?">
        <el-select v-model="project.has_api_support" required placeholder="please select">
          <el-option label="Yes" :value="1" />
          <el-option label="No" :value="0" />
        </el-select>
    </el-form-item>
    <el-form-item  v-if="project.has_api_support" label="If API’s have been developed, are the API’s published?">
      <el-select v-model="project.is_api_published" required placeholder="please select">
        <el-option label="Yes" :value="1" />
        <el-option label="No" :value="0" />
      </el-select>
    </el-form-item>
    <el-form-item  v-if="project.is_api_published" label="If an API is developed, is it an Open API?">
      <el-select v-model="project.is_openapi" required placeholder="please select">
        <el-option label="Yes" :value="1" />
        <el-option label="No" :value="0" />
      </el-select>
    </el-form-item>
    <el-form-item v-if="project.is_api_published" label="Link to the API documentation" prop="api_documentation_link">
      <el-input v-model="project.api_documentation_link" type="url">
        <template #prepend>Http://</template>
      </el-input>
    </el-form-item>
    <el-form-item label="Is the data from this application sent to MOA,MOA Agencies?">
      <el-select v-model="project.data_is_sent_to_moh" placeholder="please select">
        <el-option label="Yes" :value="1" />
        <el-option label="No" :value="0" />
      </el-select>
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
      allApplicationTypes: [], 
      rules: {
        standard: [
          { required: true, message: 'Please input standard', trigger: 'blur' },
        ],
        fhir_compliant: [
          { required: true, message: 'Please answer FHIR compliant', trigger: 'blur' },
        ],
      }
    }
  },
  props: {
    project: {
      type: Object,
    },
  },
  methods: {
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
      try {
        const data = await getFormData.list({ type: 'standard' });
        this.project.standards_lists = data.standard;
        this.project.standards_category = [...new Set(data.standard.map((item) => item.category))];
      } catch (error) {
        console.error('Error fetching form data:', error);
      }
    },
  },
  async created() {
    await this.getFormDatas();
  }
}
</script>

<style scoped>
.el-select{
  width: 100%;
}

.el-row{
  width: 100%;
  background-color: #cececea4;  
}
.el-col h4 {
  text-align: left;
}

.el-col .el-checkbox-group .el-checkbox{
  float: left;
}
</style>
