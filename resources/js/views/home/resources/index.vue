<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input v-model="query.keyword" clearable :placeholder="'search query'" style="width: 200px;" class="filter-item" @keyup.enter="handleFilter" />
      <el-button class="filter-item" type="primary" @click="handleFilter">
        <el-icon class="el-icon--left"><Search /></el-icon>{{ $t('table.search') }}
      </el-button>

      <div class="flex">
        <el-button class="filter-item" type="primary" @click="dialogVisible = true">
          <el-icon class="el-icon--left"><Plus /></el-icon> {{ $t('table.add') }}
        </el-button>
      </div>
    </div>
    <el-table :loading="loading" :data="list" border fit highlight-current-row style="width: 100%">
      <el-table-column align="center" label="#" width="100">
        <template #default="scope">
          <span>{{ ((query.page - 1) * query.limit + scope.$index + 1) }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Name">
        <template #default="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Description">
        <template #default="scope">
          <span>{{ scope.row.description }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Document">
        <template #default="scope">
          <a :href="scope.row.file" target="_blank">
            <el-button class="filter-item" type="primary">
              <el-icon class="el-icon--left"><Download /></el-icon> {{ 'Download' }}
            </el-button>
          </a>        
        </template>
      </el-table-column>
      
    </el-table>

    <pagination v-show="total>0" :total="total" :page="query.page" :limit="query.limit" @pagination="handlePageChange" />
  </div>

  <el-dialog title="Upload Resource" v-model="dialogVisible" width="50%">
    <el-form
    ref="ruleFormRef"
    :model="resource"
    :label-position="'top'"
    class="demo-ruleForm"
  >
    <el-form-item label="Name">
      <el-input v-model="resource.name"/>
    </el-form-item>
    <el-form-item label="Description">
      <el-input v-model="resource.description" :rows="6" type="textarea"/>
    </el-form-item>
    <el-form-item prop="file">
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
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination

import Resource from '@/api/resource';
const resources = new Resource('resource');

export default {
  name: 'Resource List',
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
        from_date: '',
        to_date: '',
      },
      resource: {},
      dialogVisible: false,
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
      const {data, meta} = await resources.list(this.query)
      this.list = data      
      this.total = meta.total
      this.loading = false
    },
    handleFilter() {
      this.query.page = 1;
      this.getList();
    },
    selectFile(event) {
      this.resource.file = event.target.files[0]
    },
    async uploadResource() {
      this.$refs.ruleFormRef.validate((valid, fields) => {
        if (valid) {
          //Check resource title in the project
          if(this.list && this.list.some(resource => resource.name === this.resource.name.trim())){
            this.$message({
              message: `Resource with ${this.resource.name} already created.`,
              type: 'error',
              duration: 5 * 1000,
            });
            return false;
          }

          this.loading = true

          const data = new FormData();
          data.append('file', this.resource.file);
          data.append('name', this.resource.name);
          data.append('description', this.resource.description);
          
          resources
            .store(data)
            .then((response) => {
              this.list.push(response.data)
              this.resource = {}
              document.getElementById('file').value = ''
              this.dialogVisible = false
            })
            .catch((err) => {
            //   console.log("error", err);
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

<style scoped>
.el-button{
  margin-left: 10px;
}
</style>
