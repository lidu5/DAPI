<template>
  <el-form
    ref="ruleFormRef"
    :model="project"
    :rules="rules"
    :label-position="'top'"
    :size="formSize"
  >
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
    <el-form-item label="Does the system hold personal data?">
      <el-select v-model="project.holds_personal_data" placeholder="please select">
        <el-option label="Yes" :value="1" />
        <el-option label="No" :value="0" />
      </el-select>
    </el-form-item>
    <el-form-item label="How often is the data updated?">
      <el-select v-model="project.data_update_frequency" filterable placeholder="please select">
        <el-option v-for="frequency in project.data_update_frequencies_lists" :key="frequency.id" :label="frequency.name" :value="frequency.id" />
      </el-select>
    </el-form-item>
    <el-form-item label="What identifier does the system use for the people or things it records?">
      <el-select v-model="project.identifier_type" filterable placeholder="please select">
        <el-option v-for="identifier in project.identifier_types_lists" :key="identifier.id" :label="identifier.name" :value="identifier.id" />
      </el-select>
    </el-form-item>
    <el-form-item label="Is that identifier linked to Fayda, the national digital ID?">
      <el-select v-model="project.identifier_linked_to_fayda" placeholder="please select">
        <el-option label="Yes" value="Yes" />
        <el-option label="No" value="No" />
        <el-option label="Planned" value="Planned" />
        <el-option label="Not applicable" value="Not applicable" />
      </el-select>
    </el-form-item>
    <el-form-item label="Are there other systems that your system receives data from?">
      <el-select v-model="project.receives_data_from_other_systems" placeholder="please select">
        <el-option label="Yes" :value="1" />
        <el-option label="No" :value="0" />
      </el-select>
    </el-form-item>
    <el-form-item v-if="project.receives_data_from_other_systems == 1" label="Which other systems does your system receive data from?">
      <el-input v-model="project.receives_data_from" type="textarea" :rows="2" />
    </el-form-item>
    <el-form-item label="Are there other systems that receive data from yours?">
      <el-select v-model="project.sends_data_to_other_systems" placeholder="please select">
        <el-option label="Yes" :value="1" />
        <el-option label="No" :value="0" />
      </el-select>
    </el-form-item>
    <el-form-item v-if="project.sends_data_to_other_systems == 1" label="Which other systems receive data from yours?">
      <el-input v-model="project.sends_data_to" type="textarea" :rows="2" />
    </el-form-item>
    <el-form-item v-if="project.receives_data_from_other_systems == 1 || project.sends_data_to_other_systems == 1" label="How is data exchanged with those systems?">
      <el-select v-model="project.data_exchange_type" multiple filterable collapse-tags placeholder="please select">
        <el-option v-for="exchange in project.data_exchange_types_lists" :key="exchange.id" :label="exchange.name" :value="exchange.id" />
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
        const data = await getFormData.list({ type: 'standard,data_update_frequencies,identifier_types,data_exchange_types' });
        this.project.standards_lists = data.standard;
        this.project.standards_category = [...new Set(data.standard.map((item) => item.category))];
        this.project.data_update_frequencies_lists = data.data_update_frequencies;
        this.project.identifier_types_lists = data.identifier_types;
        this.project.data_exchange_types_lists = data.data_exchange_types;
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
