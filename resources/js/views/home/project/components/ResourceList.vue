<template>
  <el-table :data="resources" fit highlight-current-row style="width: 100%">
    <el-table-column label="#" width="80">
      <template #default="scope">
        <span>{{ scope.$index + 1 }}</span>
      </template>
    </el-table-column>

    <el-table-column align="center" label="Title">
      <template #default="scope">
        <span>{{ scope.row.title }}</span>
      </template>
    </el-table-column>

    <el-table-column align="center" label="Description">
      <template #default="scope">
        <span>{{ scope.row.description }}</span>
      </template>
    </el-table-column>

    <el-table-column align="center" label="Document">
      <template #default="scope">
        <el-button @click="openPreview(scope.row.file_name)" type="primary">
          <el-icon class="el-icon--left"><View /></el-icon> Preview
        </el-button>
      </template>
    </el-table-column>

    <el-table-column v-if="editor" align="center" label="Actions" width="250">
      <template #default="scope">
        <el-button
          type="danger"
          size="small"
          @click="handleDelete(scope.row, scope.$index)"
        >
          <el-icon><Delete/></el-icon>
        </el-button>
      </template>
    </el-table-column>
  </el-table>

  <el-dialog title="Document Preview" v-model="previewVisible" width="80%">
    <iframe :src="previewUrl" width="100%" height="600px"></iframe>
  </el-dialog>

  <el-dialog
    v-if="editor"
    title="Delete Resource"
    v-model="dialogDeleteFormVisible"
    width="30%"
  >
    <div class="form-container">
      <span>Are you sure you want to delete {{ currentResource.title }}? It will no longer be available.</span>
    </div>
    <template #footer>
      <el-button @click="dialogDeleteFormVisible = false">
        {{ $t("table.cancel") }}
      </el-button>
      <el-button type="danger" @click="deleteFunction()">
        Delete Resource
      </el-button>
    </template>
  </el-dialog>
</template>

<script>
import DHPI from '@/api/project';
const dhpi = new DHPI();

import { mapGetters } from 'vuex';

export default {
  props: {
    resources: {
      type: Array,
      default: () => {
        return [];
      },
    },
    project_id: {
      type: Number
    },
    user_id: {
      type: Number,
    },
    delete: {
      type: Boolean,
    },
    edit: {
      type: Boolean,
      default: true
    }, 
    d: {
      type: Boolean,
    }, 
    status: {
      type:String
    }

  },
  data() {
    return {
      dialogDeleteFormVisible: false,
      previewVisible: false,
      previewUrl: '',
      currentResource: {},
      coverageCreating: false,
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
  methods: {
    openPreview(url) {
      this.previewUrl = url;
      this.previewVisible = true;
    },
    handleDelete(attachement, index) {
      if (this.resources.length <= 1) {
        this.$message({
          message: "There must be at least one Resource",
          type: "error",
          duration: 5 * 1000,
        });
      } else {
        this.currentResource = attachement;
        this.currentResource.index = index;
        this.currentResource.type = 'RESOURCE';
        if (this.currentResource.title === 'Proof of Safety' && !(this.status =='new' || this.status == "cert competence rejected" || this.status == "registration rejected")) {
          this.$message({
          message: "You can't delete the proof of safety.",
          type: "error",
          duration: 5 * 1000,
        });
        }
        else {
          this.dialogDeleteFormVisible = true;
        }

      }
    },
    deleteFunction() {
        this.coverageCreating = true;
        dhpi
          .deleteType(this.project_id, this.currentResource)
          .then(response => {
            this.$message({
              message: 'Resource ' + this.currentResource.title + ' has been removed.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.resources.splice(this.currentResource.index, 1);
            this.currentResource = {};
            this.dialogDeleteFormVisible = false;
          })
          .catch(error => {
            this.$message({
              message: error,
              type: 'error',
              duration: 5 * 1000,
            });
          })
          .finally(() => {
            this.coverageCreating = false;
          });
    },
  },
};
</script>

<style>
.el-row {
  margin-bottom: 20px;
}
.el-col {
  border-radius: 4px;
}
.bg-purple-dark {
  background: #99a9bf;
}
.bg-purple {
  background: #d3dce6;
}
.bg-purple-light {
  background: #e5e9f2;
}
.grid-content {
  border-radius: 4px;
  min-height: 36px;
}
.row-bg {
  padding: 10px 0;
  background-color: #f9fafc;
}
</style>
