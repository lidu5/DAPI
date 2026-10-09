<template>
  <el-form
    ref="ruleFormRef"
    :model="project"
    :rules="rules"
    :label-position="'top'"
    class="demo-ruleForm"
    :size="formSize"
  >
    <el-form-item label="What is the DAS name?" prop="name">
      <el-input v-model="project.name" />
    </el-form-item>
    <el-form-item label="What is the name of the lead organization?" prop="lead_organization">
      <el-select v-model="project.lead_organization" filterable placeholder="please select">
        <el-option v-for="work in project.works" :key="work.id" :label="work.name" :value="work.id" />
      </el-select>
    </el-form-item>
    <el-form-item label="Who are the investment Partners(Donors)?">
      <el-select v-model="project.partner" multiple filterable placeholder="please select">
        <el-option v-for="work in filteredInvestmentPartners" :key="work.id" :label="work.name" :value="work.id" />
      </el-select>
    </el-form-item>
   
    <el-form-item label="Which best describes the scope of the system?" prop="component">
      <el-select v-model="project.component" placeholder="please select">
        <el-option v-for="component in project.components_lists" :key="component.id" :label="component.name" :value="component.id" />
      </el-select>
    </el-form-item>
     <el-form-item v-if="project.component" label="Which of these best describes what your system is?" prop="application_type">
      <el-select v-model="project.application_type" placeholder="please select">
        <el-option v-for="application_type in project.application_type_lists" :key="application_type.id" :label="application_type.name" :value="application_type.id" />
      </el-select>
    </el-form-item>
  
    <el-form-item label="DHS start date" prop="start_date">
      <el-date-picker 
        v-model="project.start_date"
        format="YYYY-MM-DD"
        value-format="YYYY-MM-DD"
        />
    </el-form-item>
    <el-form-item label="DHS end date" prop="end_date">
      <el-date-picker 
        v-model="project.end_date"
        format="YYYY-MM-DD"
        value-format="YYYY-MM-DD" />
    </el-form-item>
    <el-form-item label="Contact name" prop="contact_name">
      <el-input v-model="project.contact_name" />
    </el-form-item>
    <el-form-item label="Contact email" prop="contact_email">
      <el-input v-model="project.contact_email" type="email"/>
    </el-form-item>
    <el-form-item label="Contact phone" prop="contact_phone">
      <el-input v-model="project.contact_phone"/>
    </el-form-item>
    <el-form-item label="What is the objective of the DHS?" prop="objective">
      <el-input v-model="project.objective" :rows="3" type="textarea"/>
    </el-form-item>
    <el-form-item label="Allocated budget amount for the DHS (ETB)" prop="budget">
      <el-input v-model="project.budget" type="number"/>
    </el-form-item>

      <el-form-item label="Attach your legal document (CSA registration, Business license, Self-Declaration, or etc.)" prop="legal_document">
        <el-space fill>
        <el-form-item>
          <a v-if="project.legal_document && !project.legal_document_file":href="project.legal_document" target="_blank" style="color: blue; text-decoration: underline; cursor: pointer;"> View Uploaded</a>
          <input id="file" type="file" @change="selectFile">
        </el-form-item>
        <el-alert 
          type="info" 
          show-icon 
          :closable="false"
          style="margin-top: 5px; padding: 4px 4px; font-size: 13px;"
        >
          <p>"Attached document should be a maximum of 10 MB.</p>
        </el-alert>
      </el-space>
      </el-form-item>
      <el-form-item label="Project Website Link" prop="project_website_link">
        <el-input v-model="project.project_website_link" type="url"clearable/>
      </el-form-item>
      <el-form-item label="Keywords" prop="keywords">
        <el-input
          v-model="newKeyword"
          placeholder="Type keyword and press Enter"
          @keyup.enter="addKeyword"
          @keydown.enter.prevent
          class="keyword-input"
        />
      </el-form-item>
        <div v-if="keywordList.length > 0" class="keyword-input-wrapper">
          <div class="keyword-tag" v-for="(tag, index) in keywordList" :key="index">
            {{ tag }}
            <span class="remove-tag" @click="removeKeyword(index)">×</span>
          </div>
        </div>
    <el-form-item label="Please provide a narrative summary of the DHS." prop="summary">
      <el-input v-model="project.summary" :rows="6" type="textarea"/>
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
      newKeyword: '',
      keywordList: [],
      rules: {
        name: [
          { required: true, message: 'Please input DHS name', trigger: 'blur' },
        ],
        project_website_link: [
        {
      type: 'url',
      message: 'Please enter a valid URL',
      trigger: 'blur'
         }
  ],
        lead_organization: [
          { required: true, message: 'Please input lead organization', trigger: 'blur' },
        ],
        start_date: [
          { required: true, message: 'Please input DHS start date', trigger: 'blur' },
        ],
        contact_name: [
          { required: true, message: 'Please input contact name', trigger: 'blur' },
        ],
        contact_email: [
          { required: true, message: 'Please input contact email', trigger: 'blur' },
          { type: 'email', message: 'Please input correct email address', trigger: ['blur', 'change'] },
        ],
        contact_phone: [
          { required: true, message: 'Please input contact name', trigger: 'blur' },
        ],
        objective: [
          { required: true, message: 'Please input objective of the DHS', trigger: 'blur' },
        ],
        legal_document: [
    { required: true, message: 'Please upload legal document', trigger: 'blur' },
    { validator: (rule, value, callback) => {
        if (!this.project.legal_document_file && !this.project.legal_document) {
          callback(new Error('Please upload a legal document'));
        } else {
          callback();
        }
      }, trigger: 'blur'
    },
  ],
        budget: [
          { required: true, message: 'Please input budget of the DHS', trigger: 'blur' },
        ],
        // Temporarily disabled validation rules
        component: [
        { required: true, message: 'Please input component', trigger: 'blur' },
           ],
           application_type: [
           { required: true, message: 'Please input service and application type', trigger: 'blur' },
           ],
        keywords: [
          { required: true, message: 'Please input keywords', trigger: 'blur' },
        ],
      }
    }
  },
  props: {
    project: {
      type: Object,
    },
  },
  computed: {
  filteredInvestmentPartners() {
    return this.project.works?.filter(work => 
      work.type === "DONOR/INVESTMENT PARTNERS" || work.type === "IMPLEMENTING PARTNER"
    ) || [];
  }
},

  methods: {
    selectFile(event) {
  const file = event.target.files[0];
  
  if (file) {
    if (file.size / (1024 * 1024) > 10) {
      event.preventDefault();
      this.$message({
        message: 'File size should be less than 10 MB',
        type: "error",
        duration: 5 * 1000,
      });
      event.target.value = null; 
      return;
    }
    this.project.legal_document_file = file;
    this.project.legal_document = file.name; 
  }
},
 addKeyword() {
    const trimmed = this.newKeyword.trim().replace(/\s+/g, '_');
    if (trimmed && !this.keywordList.includes(trimmed)) {
      this.keywordList.push(trimmed);
      this.updateProjectKeywords();
    }
    this.newKeyword = '';
  },
  removeKeyword(index) {
    this.keywordList.splice(index, 1);
    this.updateProjectKeywords();
  },
  updateProjectKeywords() {
    this.project.keywords = this.keywordList.join(',');
  },


    async validate(){
      return new Promise((resolve, reject) => {
        this.$refs.ruleFormRef.validate( (valid, fields) => {
          if (this.project.legal_document_file == undefined && this.project.legal_document === undefined){
            this.$message({
              message: "Please upload legal document for the DHS",
              type: 'error',
              duration: 5 * 1000,
            });
            reject(false);
            return
          }
          
          if (valid) {
            const data = new FormData();
            data.append("id", this.project.id);
            data.append('name', this.project.name);
            data.append('lead_organization', this.project.lead_organization);
            data.append('data_partner', this.project.partner);
            data.append('component', this.project.component);
            data.append('application_type', this.project.application_type);
            data.append('start_date', this.project.start_date);
            data.append('end_date', this.project.end_date);
            data.append('contact_name', this.project.contact_name);
            data.append('contact_email', this.project.contact_email);
            data.append('contact_phone', this.project.contact_phone);
            data.append('objective', this.project.objective);
            data.append('budget', this.project.budget);
            if (this.project.legal_document_file) {
              data.append('data_legal_document_file', this.project.legal_document_file);
            }  
             if (this.project.project_website_link) {
              data.append('project_website_link', this.project.project_website_link);
            }  
            if (this.project.summary) {
              data.append('summary', this.project.summary);
            }  
            if (this.project.keywords) {
              data.append('keywords', this.project.keywords);
            }            
           
            dhpi.store(data)
              .then(response => {
                resolve(response.data);
              })
              .catch(err => {
                console.log(err)
                reject(false);
              })
          } else {

            reject(false);
          }        
        })
      });
    },
    async getFormDatas(){
      try {
        const data = await getFormData.list({ type: 'works,standard,component,application_type' });
        console.log(data)
        this.project.standards_lists = data.standard;
        this.project.components_lists = data.component;
        this.project.works = data.works
        this.project.standards_category = [...new Set(data.standard.map((item) => item.category))];
        this.allApplicationTypes = data.application_type; 

        if (this.project.component) {
        this.project.application_type_lists = this.allApplicationTypes.filter(
        (app) => app.eha_component_id === this.project.component
      );
    }
         } catch (error) {
        console.error('Error fetching form data:', error);
      }
      
    },
    getFileName(filePath) {
    return filePath.split('/').pop(); 
  },
  },
  watch: {
    'project.component': function (newVal) {
    this.project.application_type = null; 
    this.project.application_type_lists = this.allApplicationTypes.filter(
      (app) => app.eha_component_id === newVal
    );
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

  .keyword-input-wrapper {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  align-items: center;
  min-height: 42px;
}

.keyword-tag {
  background-color: #f4f4f5;
  color: #909399;
  padding: 2px;
  border-radius: 5px;
  display: flex;
  align-items: center;
  font-size: 13px;
  padding: 4px 6px;
}

.remove-tag {
  margin-left: 6px;
  cursor: pointer;
  font-weight: bold;
}

</style>
