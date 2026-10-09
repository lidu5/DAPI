<template>
  <el-table :data="coverages" fit highlight-current-row style="width: 100%">
    <el-table-column label="#" width="80">
      <template #default="scope">
        <span>{{ scope.$index + 1 }}</span>
      </template>
    </el-table-column>

    <el-table-column align="center" label="Coverage/Region">
      <template #default="scope">
        <span>{{ scope.row.name }}</span>
      </template>
    </el-table-column>

    <el-table-column align="center" label="Number of users">
      <template #default="scope">
        <span>{{ scope.row.num_hw_users }}</span>
      </template>
    </el-table-column>

    <!-- <el-table-column align="center" label="Number of facilities">
      <template #default="scope">
        <span>{{ scope.row.num_hw_facilities }}</span>
      </template>
    </el-table-column> -->

    <el-table-column align="center" label="Estimated number of clients">
      <template #default="scope">
        <span>{{ scope.row.num_clients }}</span>
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

  <el-dialog
    v-if="editor"
    title="Delete Coverage"
    v-model="dialogDeleteFormVisible"
    width="30%"
  >
    <span>Are you sure you want to delete {{ currentCoverage.name }}? It will no longer be available?</span>
    <template #footer>
      <el-button @click="dialogDeleteFormVisible = false">
        {{ $t("table.cancel") }}
      </el-button>
      <el-button type="danger" @click="deleteFunction()">
        Delete Coverage
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
    coverages: {
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
    edit: {
      type: Boolean,
      default: true
    }
  },
  data() {
    return {
      dialogDeleteFormVisible: false,
      currentCoverage: {},
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
    handleDelete(attachement, index) {
      if (this.coverages.length <= 1) {
        this.$message({
          message: "There must be at least one Coverage",
          type: "error",
          duration: 5 * 1000,
        });
      } else {
        this.currentCoverage = attachement;
        this.currentCoverage.index = index;
        this.currentCoverage.type ='COVERAGE'
        this.dialogDeleteFormVisible = true;
      }
    },
    deleteFunction() {
        this.coverageCreating = true;
        dhpi
          .deleteType(this.project_id, this.currentCoverage)
          .then(response => {
            this.$message({
              message: 'Coverage ' + this.currentCoverage.name + ' has been removed.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.coverages.splice(this.currentCoverage.index, 1);
            this.currentCoverage = {};
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
