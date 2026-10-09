<template>
  <section class="activity-log">
    <div class="container">
      <div class="section-title">
        <h2>Activity Logs</h2>
        <p>All system activity logs recorded by the DHPI application.</p>
      </div>

      <!-- Search and Filter -->
      <div class="search-bar">
        <el-input
          v-model="query.keyword"
          clearable
          placeholder="Search by user"
          class="search-query"
          @input="handleFilter"
        />
        <el-select
          v-model="query.type"
          placeholder="Filter by Action"
          clearable
          class="action-filter"
          @change="handleFilter"
        >
          <el-option label="Create" value="create" />
          <el-option label="Update" value="update" />
          <el-option label="Delete" value="delete" />
          <el-option label="Login" value="login" />
          <el-option label="Logout" value="logout" />
          <el-option label="DHS created" value="dhs created" />
          <el-option label="DHS updated" value="dhs updated" />
          <el-option label="Resource Upload" value="resource upload" />
          <el-option label="REG Request" value="reg request" />
          <el-option label="WITHDRAW REG Request" value="withdraw reg request" />
          <el-option label="CERT COMP Request" value="cert comp request" />
          <el-option label="Type Remove" value="type remove" />
        </el-select>
      </div>

      <!-- Activity Table -->
      <el-table
        v-if="list.length > 0"
        :data="list"
        style="width: 100%; margin-top: 20px;"
        border
      >
        <el-table-column prop="user" label="User" min-width="180" />
        <el-table-column prop="type" label="Action" min-width="120" />
        <el-table-column prop="remarks" label="Description" min-width="300" />
        <el-table-column prop="created_at" label="Date" min-width="180">
          <template #default="{ row }">
            {{ formatDate(row.created_at) }}
          </template>
        </el-table-column>
      </el-table>

      <!-- Empty Message -->
      <el-empty
        v-else
        description="No activity logs found"
        style="margin-top: 40px;"
      />

      <!-- Pagination -->
          <pagination
        v-show="total > 0"
        :total="total"
        :page="query.page"
        :limit="query.limit"
        @pagination="handlePageChange"
      />
    </div>
  </section>
</template>

<script>
import Pagination from '@/components/Pagination';
import Resource from '@/api/resource';

const activityLogResource = new Resource('activity-logs');
export default {
  name: 'ActivityLogList',
  components: { Pagination },
  data() {
    return {
      list: [],
      total: 0,
      query: {
        page: 1,
        limit: 15,
        keyword: '',
        type: '',
      },
    };
  },
  watch: {
    'query.keyword'(val) {
      this.query.page = 1;
      this.getList();
    },
  },
  
  created() {
    this.getList();
  },
  methods: {
    async getList() {
      try {
        const { data, meta } = await activityLogResource.list(this.query);
        this.list = data;
        this.total = meta.total;
      } catch (error) {
        console.error('Failed to fetch activity logs:', error);
      }
    },
    handleFilter() {
      this.query.page = 1;
      this.getList();
    },
   handlePageChange(params) {
      this.query.page = params.page;
      this.query.limit = params.limit;
      this.getList();
    },
    formatDate(dateStr) {
      const options = {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
      };
      return new Date(dateStr).toLocaleDateString(undefined, options);
    },
  },
};
</script>

<style scoped>
.activity-log .container {
  padding: 30px;
  max-width: 95%;
  margin: auto;
}
.section-title {
  text-align: center;
  margin-bottom: 30px;
}
.section-title h2 {
  font-size: 2rem;
  font-weight: bold;
}
.section-title p {
  margin: 0;
  color: #666;
}
.search-bar {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 10px;
  margin-bottom: 20px;
}
.search-query {
  flex: 1 1 300px;
  min-width: 250px;
  height: 40px;
  border-radius: 8px;
}
.action-filter {
  width: 200px;
  height: 40px;
  border-radius: 8px;
}
</style>
