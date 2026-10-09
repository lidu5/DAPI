<template>
  <el-form
    ref="ruleFormRef"
    :model="project"
    :rules="rules"
    :label-position="'top'"
    class="demo-ruleForm"
    :size="formSize"
  >
    <el-form-item label="Where in the value chain does it operate?" prop="focus_area">
      <el-select v-model="project.focus_area" filterable multiple placeholder="please select">
        <el-option v-for="focus_area in project.focus_areas_lists" :key="focus_area.id" :label="focus_area.name" :value="focus_area.id" />
      </el-select>
    </el-form-item>
    <el-form-item label="What are the Health System Challenges addressed by the DAS?" prop="challenge">
      <el-select v-model="project.challenge" filterable multiple placeholder="please select">
        <el-option v-for="challenge in project.challenges_lists" :key="challenge.id" :label="challenge.name" :value="challenge.id" />
      </el-select>
    </el-form-item>
    <el-form-item label="Is there a MoA contribution to this DAS implementation?">
      <el-select v-model="project.moh_contribution" placeholder="please select">
        <el-option v-for="moh_contribution in contributions" :key="moh_contribution" :label="moh_contribution" :value="moh_contribution" />
      </el-select>
    </el-form-item> 
    <el-form-item label="Who are the Implementing Partners?">
      <el-select v-model="project.implementing_partners" multiple filterable placeholder="please select">
        <el-option v-for="work in filteredImplementingPartners" :key="work.id" :label="work.name" :value="work.id" />
      </el-select>
    </el-form-item>
    <el-form-item label="Funding sources of the DAS implentation?" prop="funding_sources">
      <el-select v-model="project.funding_sources" multiple placeholder="please select">
        <el-option v-for="funding in fundings" :key="funding" :label="funding" :value="funding" />
      </el-select>
    </el-form-item>
    <el-form-item v-if="(project.funding_sources && project.funding_sources.includes('Other')) || project.other_funding_sources" label="If other funding sources, specify" prop="other_funding_sources">
      <el-input v-model="project.other_funding_sources"/>
    </el-form-item>
    <el-form-item label="Business Model of the DAS?" prop="business_model">
      <el-select required v-model="project.business_model"  multiple placeholder="please select" >
        <el-option v-for="business in business_models" :key="business" :label="business" :value="business" />
      </el-select>
    </el-form-item>
    <el-form-item v-if="(project.business_model && project.business_model.includes('Other')) || project.other_business_model" label="If other business model, specify" prop="other_business_model">
      <el-input v-model="project.other_business_model"/>
    </el-form-item>


    <el-form-item label="Where is (will) your DAS implemented in?" prop="das_implemeted">
      <el-select required v-model="project.dhs_implemeted" placeholder="please select">
        <el-option label="Public" value="Public" />
        <el-option label="Private" value="Private" />
      </el-select>
    </el-form-item> 
    <el-form-item label="What is the current status of the DAS?">
      <el-select v-model="project.current_status" placeholder="please select">
        <el-option v-for="status in statuses" :key="status" :label="status" :value="status" />
      </el-select>
    </el-form-item>
    <el-form-item label="What is the current version of the application?" prop="current_version">
      <el-input v-model="project.current_version" required :maxlength="255" show-word-limit />
    </el-form-item>
    <el-form-item label="Where is the server located?" prop="deployment_location">
      <el-select v-model="project.deployment_location" required multiple placeholder="please select">
        <el-option v-for="location in project.locations" :key="location.id" :label="location.name" :value="location.id" />
      </el-select>
    </el-form-item>
    <el-form-item label="What is the geographic scope of the DAS?">
      <el-select v-model="project.geographic_scope" multiple placeholder="please select">
        <el-option v-for="region in project.regions" :key="region.id" :label="region.name" :value="region.id" />
      </el-select>
    </el-form-item>
    <el-form-item v-if="project.geographic_scope && project.geographic_scope.includes(1)" label="If the scope is National, please indicate the directorates, agencies, or institutes using the DAS.">
      <el-input v-model="project.national_scopes" :maxlength="255" show-word-limit />
    </el-form-item>
    <!-- <el-form-item label="In which facility type does the DAS is implemented?">
      <el-select v-model="project.facility_type" multiple placeholder="please select">
        <el-option v-for="facility_type in project.facility_types_list" :key="facility_type.id" :label="facility_type.name" :value="facility_type.id" />
      </el-select>
    </el-form-item> -->
    <el-form-item label="Who are the targeted users of the DAS?">
      <el-select v-model="project.target_user" multiple placeholder="please select">
        <el-option v-for="profession in project.professions" :key="profession.id" :label="profession.name" :value="profession.id" />
      </el-select>
    </el-form-item>
    <el-form-item label="Category of Evidence" prop="category_of_evidence">
      <el-select required v-model="project.category_of_evidence" placeholder="please select" >
        <el-option v-for="evidence in evidences" :key="evidence" :label="evidence" :value="evidence" />
      </el-select>
    </el-form-item> 
    <el-form-item label="Publication?" prop="publications">
      <el-input v-model="project.publications" :rows="3" type="textarea"/>
    </el-form-item>
    <el-form-item label="Key Challenges and Recommendations?" prop="key_challenges_recommendations">
      <el-input v-model="project.key_challenges_recommendations" :rows="3" type="textarea"/>
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
      contributions: [
        'No they have not',
        'Yes, They are contributing in-kind, people or time',
        'Yes, there is financial contribution through budget',
        'Yes, fully funding the DAS'
      ],
      statuses: [
        'Under development',
        'Poileting and Evidence Generating',
        'Scale up',
        'Hand over and Complete',
        'Deployed and was functional but not anymore now'
      ],
      fundings: [
      'Government funds', 
      'Private funds', 
      'Research grants',
      'Donors', 
      'Other'
      ],
      evidences: [
       'No evidence',
      'Qualitative evidence', 
      'Quantitative evidence', 
      'Both'
      ],
      business_models: [
      'No business model', 
      'Usage fee / pay per use', 
      'Subscription', 
      'Freemium, Advertising',
      'Data monetization', 
      'Other'
      ],

      rules: {
        focus_area: [
          { required: true, message: 'Please input health focus area', trigger: 'blur' },
        ],
        challenge: [
          { required: true, message: 'Please input component', trigger: 'blur' },
        ],
        dhs_implemeted: [
          { required: true, message: 'Please selected where DAS is/will implemeted', trigger: 'blur' },
        ],
        current_version: [
          { required: true, message: 'Please input the current version of the DAS', trigger: 'blur' },
        ],
        category_of_evidence: [
          { required: true, message: 'Please input the category of evidence of the DAS', trigger: 'blur' },
        ],
        funding_sources: [
          { required: true, message: 'Please input the funding sources of the DAS', trigger: 'blur' },
        ],
        deployment_location: [
          { required: true, message: 'Please input the deployment locations of the DAS', trigger: 'blur' },
        ]
      }
    }
  },
  props: {
    project: {
      type: Object,
    },
  },
  computed: {
  filteredImplementingPartners() {
    return this.project.works?.filter(work => 
      work.type === "IMPLEMENTING PARTNER"
    ) || [];
  }
},
  methods: {
    async validate(){
      return new Promise((resolve, reject) => {
        const result =  this.$refs.ruleFormRef.validate( (valid, fields) => {
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
      const data = await getFormData.list({type: 'focus_areas,challenges,works,locations,regions,facility_types,professions'})
      this.project.focus_areas_lists = data.focus_areas
      this.project.challenges_lists = data.challenges      
      this.project.works = data.works
      this.project.locations = data.locations
      this.project.regions = data.regions
      this.project.facility_types_list = data.facility_types
      this.project.professions = data.professions
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
