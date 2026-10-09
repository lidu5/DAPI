<template>
  <div class="app-container">
    <p>Resources related to a given digital health project, which could be documentations, source codes and manuals are attached in this subsection</p>
    <el-row v-if="editor" v-permission="['edit project']">
      <el-button class="filter-item" type="primary" @click="dialogVisible = true">
        <el-icon class="el-icon--left"><Plus /></el-icon> {{ $t("table.add") }}
      </el-button>
    </el-row>
    <resource-list :resources="resourcesList" :project_id="id" :user_id="user_id" :edit="edit" :status="status" />
  </div>
  <el-dialog v-if="editor" title="Resource" v-model="dialogVisible" width="50%">
    <el-form
    ref="ruleFormRef"
    :model="resource"
    :label-position="'top'"
    class="demo-ruleForm"
  >
    <el-form-item label="Title">
      <el-select v-model="resource.title" required placeholder="please select">
        <el-option v-for="resource in resource_options" :key="resource" :label="resource" :value="resource" />
      </el-select>
    </el-form-item>
    <el-form-item label="Description" >
      <el-input v-model="resource.description" :rows="6" type="textarea"  :maxlength="255" show-word-limit />
    </el-form-item>
    <el-form-item prop="file" :rules="[{ required: true, message: 'Please upload a file', trigger: 'change' }]">
      <input id="file" type="file" required @change="selectFile">
    </el-form-item>
  </el-form>
    <template #footer>
      <el-button @click="dialogVisible = false">
        {{ $t("table.cancel") }}
      </el-button>
      <el-button type="primary" @click="uploadResource()"> Upload Resource </el-button>
    </template>
  </el-dialog>
</template>

<script>
import ResourceList from '../ResourceList.vue';
import { mapGetters } from 'vuex';

import DHPI from "@/api/project"
const dhpi = new DHPI()

export default {
  name: "Resource View",
  props: {
    resources: {
      type: Array,
      default: []
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
    },
    status: {
      type: String,
    }
  },
  components: {
    ResourceList
  },
  data() {
    return {
      dialogVisible: false,
      resource: {},
      resourcesList: this.resources,
      resourceOptions: [
        'Proof of Safety',
        'User Manual',
        'SRS',
        'Architecture',
        'Developer Manual',
        'Privacy Policy Document',
        'Other'
      ],
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
    },
    resource_options(){
      return this.resourceOptions.filter((res) => {
        if (this.resourcesList){
          return !this.resourcesList.some((proj) => proj.title === res)
        }
        return true
      })
    }
  },
  methods: {
    selectFile(event) {
      this.resource.file = event.target.files[0]
    },
    async uploadResource() {
      this.$refs.ruleFormRef.validate((valid, fields) => {
        if (valid) {
          if(this.resourcesList && this.resourcesList.some(resource => resource.title === this.resource.title.trim())){
            this.$message({
              message: `Resource with ${this.resource.title} already created.`,
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
            .resource(this.id, data)
            .then((response) => {
              this.resourcesList = response.data.resources
              this.resource = {}
              document.getElementById('file').value = ''
              this.dialogVisible = false
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
    }
  },
};
</script>
