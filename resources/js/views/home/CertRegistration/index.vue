<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input v-model="query.keyword" clearable :placeholder="'search query'" style="width: 200px;" class="filter-item" @keyup.enter="handleFilter" />
      <el-button class="filter-item" type="primary" @click="handleFilter">
        <el-icon class="el-icon--left"><Search /></el-icon>{{ $t('table.search') }}
      </el-button>
    </div>
    <el-table :loading="loading" :data="list" border fit highlight-current-row style="width: 100%">
      <el-table-column align="center" label="#" width="50">
        <template #default="scope">
          <span>{{ ((query.page - 1) * query.limit + scope.$index + 1) }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Name" width="120" prop="name" sortable>
        <template #default="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Start Date" prop="start_date" sortable>
        <template #default="scope">
          <span>{{ new Date(scope.row.start_date) }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Contact Info">
        <template #default="scope">
          <el-popover effect="light" trigger="hover" placement="top" width="auto">
            <template #default>
                <div>{{ scope.row.contact_name }}</div>
                <div>{{ scope.row.contact_email }}</div>
                <div>{{ scope.row.contact_phone }}</div>
            </template>
            <template #reference>
                <el-tag>{{ scope.row.contact_name }}</el-tag>
            </template>
          </el-popover>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Status" width="200">
        <template #default="scope">
          <span>{{ scope.row.status.toUpperCase() }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Actions" width="250">
        <template #default="scope">
          <router-link :to="'/registration/view/'+scope.row.id">
            <el-button type="default"
            >
            {{ scope.row.status == 'request registration' || scope.row.status == 'request cert registration' ? 'Proceed to Registration Approval' : 'View DHS' }}
          </el-button>
          </router-link>
        </template>
      </el-table-column>
    </el-table>

    <pagination v-show="total>0" :total="total" :page="query.page" :limit="query.limit" @pagination="handlePageChange" />
  </div>
</template>

<script>
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
import DHPI from '@/api/project';

const dhpi = new DHPI();

export default {
  name: 'Registration',
  components: { Pagination },
  data() {
    return {
      list: null,
      total: 0,
      loading: true,
      downloading: false,
      advanced: false,
      query: {
        page: 1,
        limit: 15,
        keyword: '',
        name: '',
        statuses: ['request registration', 'registration approved', 'request cert competence', 'request cert registration']
      },
    };
  },
  created() {
    this.getList();
  },
  methods: {
    handlePageChange(params){
      this.query.page = params.page
      this.query.limit = params.limit

      this.getList()
    },
    async getList() {
      this.loading = true
      this.list = []
      const {data, meta} = await dhpi.list(this.query)
      this.list = data      
      this.total = meta.total
      this.loading = false
    },
    handleFilter() {
      this.query.page = 1;
      this.getList();
    },
  },
};
</script>

<style scoped>
.el-button{
  margin-left: 10px;
}
</style>
