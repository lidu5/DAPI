<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input v-model="query.keyword" clearable :placeholder="'search query'" style="width: 200px;" class="filter-item" @keyup.enter="handleFilter" />
      <el-button class="filter-item" type="primary" @click="handleFilter">
        <el-icon class="el-icon--left">
          <Search />
        </el-icon>
        {{ $t('table.search') }}
      </el-button>
      
      <div class="flex">
        <router-link v-permission="['add project']" :to="'/projects/new'">
          <el-button class="filter-item" type="primary">
            <el-icon class="el-icon--left">
              <Plus />
            </el-icon>
            {{ $t('table.add') }}
          </el-button>
        </router-link>
        <el-button @click="advanced = !advanced">
          <el-icon class="el-icon--left">
            <Close v-if="advanced" />
            <Search v-else />
          </el-icon>
          Advanced Search
        </el-button>
      </div>
    </div>
    
    <div v-if="advanced">
      <el-row>
        <el-col :span="4" v-if="checkRole(['admin'])">
          <el-select v-model="query.status" clearable @change="handleFilter" placeholder="Filter by status">
            <el-option value="new" label="New" />
            <el-option value="registration approved" label="Registration Approved" />
            <el-option value="registration rejected" label="Registration Rejected" />
            <el-option value="cert competence" label="Cert Competence" />
            <el-option value="cert competence rejected" label="Cert Competence Rejected" />
            <el-option value="request registration" label="Request Registration" />
            <el-option value="request cert competence" label="Request Competence Cert" />
            <el-option value="archived" label="Archive" />
          </el-select>
        </el-col>
        <el-col :span="4" v-if="checkRole(['admin'])">
          <el-select v-model="query.organization" clearable @change="handleFilter"
            placeholder="Filter by lead organizations">
            <el-option v-for="organization in search_data.organizations" :key="organization.id"
              :label="organization.name" :value="organization.id" />
          </el-select>
        </el-col>
        <el-col :span="4">
          <el-select v-model="query.component" clearable @change="handleFilter" placeholder="Filter by components">
            <el-option v-for="component in search_data.components" :key="component.id" :label="component.name"
              :value="component.id" />
          </el-select>
        </el-col>
        <el-col :span="1" />
        <el-col :span="4">
          <el-select v-model="query.application_type" clearable @change="handleFilter"
              placeholder="Filter by application type">
              <el-option v-for="application_type in search_data.application_types" :key="application_type.id"
                  :label="application_type.name" :value="application_type.id" />
          </el-select>
        </el-col>
        <el-col :span="1" />
        <el-col :span="4">
          <el-select v-model="query.focus_area" clearable @change="handleFilter" placeholder="Filter by focus areas">
            <el-option v-for="focus_area in search_data.focus_areas" :key="focus_area.id" :label="focus_area.name"
              :value="focus_area.id" />
          </el-select>
        </el-col>
        <el-col :span="1" />
        <el-col :span="4">
          <el-select v-model="query.region" clearable @change="handleFilter" placeholder="Filter by coverages">
            <el-option v-for="region in search_data.regions" :key="region.id" :label="region.name" :value="region.id" />
          </el-select>
        </el-col>
        <el-col :span="1" />
        <el-col :span="4">
          <el-select v-model="query.challenge" clearable @change="handleFilter" placeholder="Filter by challenges">
            <el-option v-for="challenge in search_data.challenges" :key="challenge.id" :label="challenge.name"
              :value="challenge.id" />
          </el-select>
        </el-col>
      </el-row>
    </div>
    <el-table :loading="loading" :data="list" border fit highlight-current-row style="width: 100%; margin-top: 20px;">
      <el-table-column align="center" label="#" width="100">
        <template #default="scope">
          <span>{{ ((query.page - 1) * query.limit + scope.$index + 1) }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Name" prop="name" sortable>
        <template #default="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Start Date" prop="start_date" sortable>
        <template #default="scope">
          <span>{{ scope.row.start_date }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Contact Info">
        <template #default="scope">
          <el-popover effect="light" trigger="hover" placement="top" width="auto">
            <template #default>
              <div>name: {{ scope.row.contact_name }}</div>
              <div>email: {{ scope.row.contact_email }}</div>
            </template>
            <template #reference>
              <el-tag>{{ scope.row.contact_name }}</el-tag>
            </template>
          </el-popover>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Status" width="200" prop="status" sortable>
        <template #default="scope">
          <span>{{ scope.row.status.toUpperCase() }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Actions" width="300">
        <template #default="scope">
          <div style="display: flex; gap: 10px; justify-content: center;">
            <router-link :to="'/projects/view/' + scope.row.id">
              <el-button type="default">View</el-button>
            </router-link>
            
            <el-button v-if="checkRole(['admin', 'implementer']) && scope.row.status.toUpperCase() === 'NEW'" type="danger" @click="handleDelete(scope.row.id)">
              Delete
            </el-button>
            
            <div v-if="checkRole(['admin'])">
              <el-button v-if="scope.row.status !== 'archived'" type="warning" @click="handleArchive(scope.row.id)">
                Archive
              </el-button>
              <el-button v-if="scope.row.status === 'archived'" type="success" @click="handleUnarchive(scope.row.id)">
                Unarchive
              </el-button>
            </div>
          </div>
        </template>
      </el-table-column>
    </el-table>
    
    <pagination v-show="total > 0" :total="total" :page="query.page" :limit="query.limit" @pagination="handlePageChange" />
  </div>
</template>

<script>
import Pagination from '@/components/Pagination';
import DHPI from '@/api/project';
import checkPermission from '@/utils/permission';
import checkRole from '@/utils/role';
import Resource from '@/api/resource';

const dhpi = new DHPI();
const projectSearchData = new Resource('projects/search-data');

export default {
  name: 'ProjectList',
  components: { Pagination },
  data() { 
    return {
      list: null,
      total: 0,
      loading: true,
      advanced: false,
      query: {
        page: 1,
        limit: 15,
        keyword: '',
        organization: [],
        focus_area: [],
        region: [],
        component: [],
        challenge: [],
        application_type: [],
        status: ''
      },
      search_data: {},
      filters: [
        { key: 'organization', dataKey: 'organizations', placeholder: 'Filter by lead organizations' },
        { key: 'component', dataKey: 'components', placeholder: 'Filter by components' },
        { key: 'focus_area', dataKey: 'focus_areas', placeholder: 'Filter by focus areas' },
        { key: 'region', dataKey: 'regions', placeholder: 'Filter by coverages' },
        { key: 'challenge', dataKey: 'challenges', placeholder: 'Filter by challenges' }
      ]
    };
  },
  created() {
    this.getList();
    this.getSearchData();
  },
  methods: {
    checkPermission,
    checkRole,
    async handleArchive(projectId) {
  try {
    const confirmation = await this.$confirm(
      "Are you sure you want to archive this project?",
      "Warning",
      {
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        type: "warning",
      }
    ).catch(() => {
      this.$message({
        type: "info",
        message: "Archiving canceled",
      });
      throw new Error("Archiving canceled by user");
    });
    if (confirmation) {
      await dhpi.archive(projectId);
      this.$message({
        type: "success",
        message: "Project archived successfully!",
      });
      this.getList();
    }
  } catch (error) {
    if (error.message !== "Archiving canceled by user") {
      console.error(error);
      this.$message({
        type: "error",
        message: "Failed to archive the project",
      });
    }
  }
},
async handleUnarchive(projectId) {
  try {
    const confirmation = await this.$confirm(
      "Are you sure you want to unarchive this project?",
      "Warning",
      {
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        type: "warning",
      }
    ).catch(() => {
      this.$message({
        type: "info",
        message: "Unarchiving canceled",
      });
      throw new Error("Unarchiving canceled by user");
    });

    if (confirmation) {
      await dhpi.unarchive(projectId); 
      this.$message({
        type: "success",
        message: "Project unarchived successfully!",
      });
      this.getList(); 
    }
  } catch (error) {
    if (error.message !== "Unarchiving canceled by user") {
      console.error(error);
      this.$message({
        type: "error",
        message: "Failed to unarchive the project",
      });
    }
  }
},
    handlePageChange(params) {
      this.query.page = params.page;
      this.query.limit = params.limit;
      this.getList();
    },
    async getList() {
      this.loading = true;
      const { data, meta } = await dhpi.list(this.query);
      this.list = data;
      this.total = meta.total;
      this.loading = false;
    },
    async getSearchData() {
      const data = await projectSearchData.list({});
      this.search_data.organizations = data.organizations;
      this.search_data.focus_areas = data.focus_areas;
      this.search_data.regions = data.regions;
      this.search_data.components = data.components;
      this.search_data.challenges = data.challenges;
      this.search_data.application_types = data.application_types
    },

    async handleDelete(projectId) {
  try {
    const confirmation = await this.$confirm(
      "Are you sure you want to delete this project?",
      "Warning",
      {
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        type: "warning",
      }
    ).catch(() => {
      this.$message({
        type: "info",
        message: "Deletion canceled",
      });
      throw new Error("Deletion canceled by user");
    });


    if (confirmation) {
      await dhpi.delete(projectId);
      this.$message({
        type: "success",
        message: "Project deleted successfully!",
      });
      this.getList();
    }
  } catch (error) {
    if (error.message !== "Deletion canceled by user") {
      console.error(error);
      this.$message({
        type: "error",
        message: "Failed to delete the project",
      });
    }
  }
},

    handleFilter() {
      this.query.page = 1;
      this.getList();
    }
  }
};
</script>

<style scoped>
.el-button {
  margin-left: 10px;
}
</style>
