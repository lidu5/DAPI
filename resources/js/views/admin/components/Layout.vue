<template>
  <div  :loading="loading"
      element-loading-text="Loading..." 
      element-loading-spinner="el-icon-loading" 
      id="main-container" >
    <h2>{{ entityName }} Dashboard</h2>

    <el-row class="mb-4">
      <el-col :span="6">
        <el-input v-model="searchQuery" :placeholder="'Search ' + entityName + '...'" @input="onSearchChange"  
        />
      </el-col>
      <el-col :span="6" :offset="12" class="text-right">
        <el-button type="primary" @click="showCreateForm">
          Add New {{ entityName }}
        </el-button>
      </el-col>
    </el-row>

    <UpdateForm
      v-if="showUpdateFormFlag"
      :modelValue="showUpdateFormFlag"
      :entityName="entityName"
      :formFields="dynamicFields"
      :initialData="entityToEdit"
      :entityToEdit="entityToEdit" 
      @submit="handleFormSubmit"
      @close="closeUpdateModal"
    />

    <DeleteModal
      v-if="showDeleteModalFlag"
      v-model="showDeleteModalFlag"
      :entityName="entityName"
      @confirm-delete="confirmDelete"
      @close="closeUpdateModal"

    />

      <List
      :tableData="entities"
      :pagination="query"
      :dynamicFields="dynamicFields"
      @edit="showEditForm"
      @delete="showDeleteModal"
      @page-change="handlePageChange"
    />

    <Pagination
      v-show="total > 0"
      :total="total"
      :page="query.page"
      :limit="query.limit"
      @pagination="handlePageChange"
    />
  </div>
</template>

<script>
import List from './List.vue'; 
import UpdateForm from './UpdateForm.vue'; 
import DeleteModal from './DeleteConfirmation.vue'; 
import Pagination from '@/components/Pagination'; 
import 'element-plus/es/components/loading/style/css';

import Resource from '@/api/resource';

const ITEM_PER_PAGE = 15; 
export default {
  components: {
    List,
    UpdateForm,
    DeleteModal,
    Pagination
  },
  props: {
    entityName: { type: String, required: true },
    dynamicFields: { type: Array, required: true },
    resourceUri: { type: String, required: true },
  },
  data() {
    return {
      entities: [], 
      total: 0,
      query: {
        page: 1,
        limit: ITEM_PER_PAGE, 
      },
      searchQuery: '',
      sortDirection: 'asc', 
      showUpdateFormFlag: false, 
      showDeleteModalFlag: false, 
      entityToEdit: null, 
      entityToDelete: null, 
      loading: false,
    };
  },
  methods: {
    initResource() {
      this.resource = new Resource(this.resourceUri);
    },
    onSearchChange() {
      this.query.page = 1; 
      this.fetchEntities();
    },

    handlePageChange(params) {
      this.query.page = params.page;
      this.query.limit = params.limit;
      this.fetchEntities();
    },

    handleFilter() {
      this.query.page = 1; 
      this.fetchEntities();
    },

    async fetchEntities() {
      try {
        this.loading = true;
        const query = {
          page: this.query.page,
          limit: this.query.limit,
          search: this.searchQuery,
          sort_direction: this.sortDirection, 
        };
        const { meta, data } = await this.resource.list(query);
        this.entities = data;
        this.total = meta.total;
        this.loading = false;
      } catch (error) {
        console.error('Error fetching entities:', error);
      }
    },

    showCreateForm() {
      this.showUpdateFormFlag = false; 
      this.$nextTick(() => {
        this.entityToEdit = null; 
        this.showUpdateFormFlag = true; 
      });
    },

    showEditForm(entity) {
      this.showUpdateFormFlag = false; 
      this.$nextTick(() => {
        this.entityToEdit = { ...entity }; 
        this.showUpdateFormFlag = true; 
  });
},
  closeDeleteModal() {
    this.showDeleteModalFlag = false; 
  },

  closeUpdateModal() {
    this.showUpdateFormFlag = false; 
  },
    showDeleteModal(entity) {
      this.entityToDelete = entity;
      this.showDeleteModalFlag = true;
    },

    async handleFormSubmit(formData) {
      try {
        if (this.entityToEdit) {
          await this.resource.update(this.entityToEdit.id, formData);
        } else {
          await this.resource.store(formData);
        }
        this.showUpdateFormFlag = false; 
        this.fetchEntities(); 
      } catch (error) {
        console.error('Error submitting form:', error);
      }
    },

    async confirmDelete() {
      try {
        await this.resource.destroy(this.entityToDelete.id);
        this.showDeleteModalFlag = false; 
        this.fetchEntities(); 
      } catch (error) {
        console.error('Error deleting entity:', error);
      }
    },
  },

  mounted() {
    this.initResource();
    this.fetchEntities(); 
  },
};
</script>

<style scoped>
.el-button {
  margin-left: 10px;
}

#main-container {
  margin: 20px; 
}
</style>