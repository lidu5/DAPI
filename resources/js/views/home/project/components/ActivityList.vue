<template>
  <el-table :data="activities" fit highlight-current-row style="width: 100%">
    <el-table-column label="#" width="80">
      <template #default="scope">
        <span>{{ scope.$index + 1 }}</span>
      </template>
    </el-table-column>

    <el-table-column align="center" label="Name">
      <template #default="scope">
        <span>{{ scope.row.name }}</span>
      </template>
    </el-table-column>

    <el-table-column align="center" label="Digital Health Intervention">
      <template #default="scope">
        <el-popover effect="light" trigger="hover" placement="top" width="auto">
          <template #default>
            <div v-for="dhi in scope.row.interventions" :key="dhi.id">{{ dhi.name }}</div>
          </template>
          <template #reference>
            <el-tag>{{ scope.row.interventions.length + ' interventions' }}</el-tag>
          </template>
        </el-popover>
      </template>
    </el-table-column>

    <el-table-column align="center" label="Description" prop="description">
      <template #default="scope">
        <span>{{ scope.row.description }}</span>
      </template>
    </el-table-column>

    <el-table-column v-if="editor" align="center" label="Actions" width="250">
      <template #default="scope">
        <el-button type="danger" size="small" @click="handleDelete(scope.row, scope.$index)">
          <el-icon><Delete/></el-icon>
        </el-button>
      </template>
    </el-table-column>
  </el-table>

  <el-dialog v-if="editor" title="Delete Activity" v-model="dialogDeleteFormVisible" width="30%">
    <span>Are you sure you want to delete {{ currentActivity.name }}? It will no longer be available.</span>
    <template #footer>
      <el-button @click="dialogDeleteFormVisible = false">{{ $t("table.cancel") }}</el-button>
      <el-button type="danger" @click="deleteFunction">Delete Activity</el-button>
    </template>
  </el-dialog>
</template>

<script>
import DHPI from '@/api/project';
import { mapGetters } from 'vuex';

const dhpi = new DHPI();

export default {
  props: {
    activities: {
      type: Array,
      default: () => [],
    },
    project_id: {
      type: Number,
    },
    user_id: {
      type: Number,
    },
    edit: {
      type: Boolean,
      default: true,
    },
  },
  data() {
    return {
      dialogDeleteFormVisible: false,
      currentActivity: {},
      coverageCreating: false,
    };
  },
  computed: {
    ...mapGetters(['userId', 'roles']),
    editor() {
      return this.edit && (this.user_id === this.userId || this.roles.includes('admin'));
    },
  },
  methods: {
    handleDelete(activity, index) {
      if (this.activities.length <= 1) {
        this.$message({
          message: "There must be at least one Activity",
          type: "error",
          duration: 5000,
        });
        return;
      }
      this.currentActivity = { ...activity, index, type: 'ACTIVITY' };
      this.dialogDeleteFormVisible = true;
    },
    deleteFunction() {
      this.coverageCreating = true;
      dhpi.deleteType(this.project_id, this.currentActivity)
        .then(() => {
          this.$message({
            message: `Activity ${this.currentActivity.name} has been removed.`,
            type: 'success',
            duration: 5000,
          });
          this.activities.splice(this.currentActivity.index, 1);
          this.currentActivity = {};
          this.dialogDeleteFormVisible = false;
        })
        .catch(error => {
          this.$message({ message: error, type: 'error', duration: 5000 });
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
