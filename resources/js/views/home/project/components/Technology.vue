<template>
  <el-form
    ref="ruleFormRef"
    :model="project"
    :rules="rules"
    :label-position="'top'"
    class="demo-ruleForm"
    :size="formSize"
  >
    <el-form-item label="Golive date of the project" prop="golive_date">
      <el-date-picker 
        v-model="project.golive_date"
        format="YYYY-MM-DD"
        value-format="YYYY-MM-DD"
      />
    </el-form-item>
    <el-form-item label="Under what license is the DAS governed?" prop="under_license">
      <el-select v-model="project.under_license" placeholder="please select">
        <el-option v-for="license in project.licenses_lists" :key="license.id" :label="license.name" :value="license.id" />
      </el-select>
    </el-form-item>
    <el-form-item label="Please specify the OSI Approved License(s) used for your solution" prop="osi_license">
      <el-select v-model="project.osi_license" filterable multiple placeholder="please select">
        <el-option v-for="license in project.osi_licenses_lists" :key="license.id" :label="license.name" :value="license.id" />
      </el-select>
    </el-form-item>
    <el-form-item label="Who owns the DAS source code?"  prop="ownership">
      <el-select v-model="project.ownership" placeholder="please select">
        <el-option v-for="ownership in project.ownerships_list" :key="ownership.id" :label="ownership.name" :value="ownership.id" />
      </el-select>
    </el-form-item>
    <el-form-item v-if="(project.ownerships_list && project.ownership === project.ownerships_list.findIndex(owner => owner.name === 'Government') + 1) || project.owner" label="If the answer above is government, which government office owns the source code?">
      <el-input v-model="project.owner" />
    </el-form-item>
    <el-form-item label="Link to a documentation of the DAS" prop="documentation_link">
      <el-input v-model="project.documentation_link" type="url">
        <template #prepend>Http://</template>
      </el-input>
    </el-form-item>
    <el-form-item label="Link to the software wiki page" prop="wiki_page">
      <el-input v-model="project.wiki_page" type="url">
        <template #prepend>Http://</template>
      </el-input>
    </el-form-item>
    <el-form-item label="Link to the version control (git)" prop="git_link">
      <el-input v-model="project.git_link" type="url">
        <template #prepend>Http://</template>
      </el-input>
    </el-form-item>
    <el-form-item label="What is the type of the application (platform)?" prop="application">
      <el-select v-model="project.application" multiple placeholder="please select">
        <el-option v-for="application in project.applications_lists" :key="application.id" :label="application.name" :value="application.id" />
      </el-select>
    </el-form-item>
    <el-form-item v-if="project.application && project.application.includes(otherApplicationId)" label="If other application types, specify" prop="other_typeof_applications">
      <el-input v-model="project.other_typeof_applications"/>
    </el-form-item>
    <el-form-item label="Indicate the operating system(s) that the DAS supports" prop="os">
      <el-select v-model="project.os" multiple placeholder="please select">
        <el-option v-for="os in project.oses_lists" :key="os.id" :label="os.name" :value="os.id" />
      </el-select>
    </el-form-item>
    <el-form-item v-if="(project.os && project.os.includes(otherOsId)) || project.other_operating_systems" label="If other operating systems, specify" prop="other_operating_systems">
      <el-input v-model="project.other_operating_systems"/>
    </el-form-item>
    <el-form-item v-if="project.languages_lists" label="What are the programming languages used for the DAS?" prop="language">
      <el-select v-model="project.language" filterable multiple placeholder="please select">
        <el-option v-for="language in project.languages_lists.filter((lang) => lang.type == 'Language')" :key="language.id" :label="language.name" :value="language.id" />
      </el-select>
    </el-form-item>
    <el-form-item v-if="project.languages_lists" label="What are the frameworks used to develop the system?" prop="framework">
      <el-select v-model="project.framework" multiple placeholder="please select">
        <el-option v-for="language in project.languages_lists.filter((lang) => lang.type == 'Framework')" :key="language.id" :label="language.name" :value="language.id" />
      </el-select>
    </el-form-item>
    <el-form-item v-if="(project.framework && project.framework.includes(otherLanguageId)) || project.other_frameworks" label="If other frameworks, specify" prop="other_frameworks">
      <el-input v-model="project.other_frameworks"/>
    </el-form-item>
    <el-form-item label="What are the database management (DBMS) that the application uses?" prop="db">
      <el-select v-model="project.db" multiple placeholder="please select">
        <el-option v-for="db in project.dbms_lists" :key="db.id" :label="db.name" :value="db.id" />
      </el-select>
    </el-form-item>
    <el-form-item v-if="(project.db && project.db.includes(otherDbId)) || project.other_databases" label="If other databases, specify" prop="other_databases">
      <el-input v-model="project.other_databases"/>
    </el-form-item>
    <el-form-item label="What other third-party tools the DAS depends on?" prop="third_party_tools">
      <el-input v-model="project.third_party_tools" :rows="6" type="textarea" />
    </el-form-item>
    <el-form-item label="Was it built from scratch or on something existing?">
      <el-select v-model="project.technology_origin" placeholder="please select">
        <el-option label="Built bespoke" value="Built bespoke" />
        <el-option label="Commercial off-the-shelf product" value="Commercial off-the-shelf product" />
        <el-option label="Open-source product, configured" value="Open-source product, configured" />
        <el-option label="Built on a DPI building block (e.g. OpenG2P, ODK)" value="Built on a DPI building block (e.g. OpenG2P, ODK)" />
      </el-select>
    </el-form-item>
    <el-form-item label="Does the system work offline?">
      <el-select v-model="project.works_offline" placeholder="please select">
        <el-option label="Yes, fully" value="Yes, fully" />
        <el-option label="Partially" value="Partially" />
        <el-option label="No" value="No" />
      </el-select>
    </el-form-item>
    <el-form-item label="Is there a backup of the system data?">
      <el-select v-model="project.data_backup" placeholder="please select">
        <el-option label="Yes: automated" value="Yes: automated" />
        <el-option label="Yes: manual" value="Yes: manual" />
        <el-option label="No" value="No" />
      </el-select>
    </el-form-item>
    <el-form-item v-if="project.data_backup === 'Yes: automated' || project.data_backup === 'Yes: manual'" label="How often is it backed up?">
      <el-select v-model="project.backup_frequency" placeholder="please select">
        <el-option label="Continuously" value="Continuously" />
        <el-option label="Daily" value="Daily" />
        <el-option label="Weekly" value="Weekly" />
        <el-option label="Monthly" value="Monthly" />
        <el-option label="Ad hoc" value="Ad hoc" />
      </el-select>
    </el-form-item>
    <el-form-item label="Which languages is the system available in?">
      <el-select v-model="project.system_language" multiple filterable collapse-tags placeholder="please select">
        <el-option v-for="language in project.system_languages_lists" :key="language.id" :label="language.name" :value="language.id" />
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
      rules: {
        under_license: [
          { required: true, message: 'Please input DAS license', trigger: 'blur' },
        ],
        osi_license: [
          { required: true, message: 'Please input DAS OSI approved license', trigger: 'blur' },
        ],
        ownership: [
          { required: true, message: 'Please specify DAS ownership', trigger: 'blur' },
        ],
        application: [
          { required: true, message: 'Please specify DAS application type', trigger: 'blur' },
        ],
        os : [
          { required: true, message: 'Please specify DAS operating system', trigger: 'blur' },
        ],
        language: [
          { required: true, message: 'Please specify programing language the DAS uses', trigger: 'blur' },
        ],
        framework: [
          { required: true, message: 'Please specify framework the DAS uses', trigger: 'blur' },
        ],

        db: [
          { required: true, message: 'Please specify database the DAS uses', trigger: 'blur' },
        ],
        
        otherApplicationId: null,
        otherOsId: null,
        otherLanguageId: null,
        otherDbId: null,
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
            if(this.project.ownership !== this.project.ownerships_list.findIndex(owner => owner.name === 'Government') + 1){
              this.project.owner = null
            }
            const addProtocol = (url) => {
  if (!url) return null;
  if (!/^https?:\/\//i.test(url)) {
    return 'https://' + url;
  }
  return url;
};

this.project.documentation_link = addProtocol(this.project.documentation_link);
this.project.wiki_page = addProtocol(this.project.wiki_page);
this.project.git_link = addProtocol(this.project.git_link);

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
      const data = await getFormData.list({type: 'licenses,applications,oses,languages,dbms,ownerships,osi_licenses,system_languages'})
      this.project.licenses_lists = data.licenses
      this.project.applications_lists = data.applications
      this.project.oses_lists = data.oses
      this.project.dbms_lists = data.dbms
      this.project.languages_lists = data.languages
      this.project.ownerships_list = data.ownerships
      this.project.osi_licenses_lists = data.osi_licenses
      this.project.system_languages_lists = data.system_languages
  

      this.otherApplicationId = this.project.applications_lists.find(app => app.name === 'Other')?.id;
      this.otherOsId = this.project.oses_lists.find(os => os.name === 'Other')?.id;
      this.otherLanguageId = this.project.languages_lists.find(lang => lang.name === 'Other')?.id;
      this.otherDbId = this.project.dbms_lists.find(db => db.name === 'Other')?.id;

      //Add other
      // this.project.applications_lists.push(this.other)
      // this.project.oses_lists.push(this.other)
      // this.project.dbms_lists.push(this.other)
      // this.project.languages_lists.push({
      //   id: 0,
      //   name: 'Other',
      //   type: 'Framework'
      // })
    },
  },
  created() {
    this.getFormDatas()
  }
}
</script>

<style scoped>
.el-select{
    width: 100%;
  }
</style>
