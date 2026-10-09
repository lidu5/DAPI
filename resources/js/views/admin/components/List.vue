<template>
  <div>
    <el-table
      :data="tableData"
      :border = "true"
      style="width: 100%; margin:10px;"
      :default-sort="{ prop: sortField, order: sortOrder }"
      @sort-change="handleSort"
    >
      <el-table-column label="#" width="50">
        <template #default="scope">
          {{ (pagination.page - 1) * pagination.limit + scope.$index + 1 }}
        </template>
      </el-table-column>

      <el-table-column
        v-for="field in filteredFields"
        :key="field.key"
        :label="field.label"
        :prop="field.key"
        :sortable="field.sortable || false"
      >
        <template #default="scope">
          <div v-if="field.key === 'description' && scope.row[field.key]">
            <span :style="{ fontSize: scope.row[field.key].length > 50 ? '12px' : 'inherit' }">
              {{ scope.row[field.key] }}
            </span>
          </div>
          <div v-else>{{ scope.row[field.key] }}</div>
        </template>
      </el-table-column>

      <el-table-column label="Actions" width="150">
        <template #default="scope">
          <el-button @click="$emit('edit', scope.row)" size="small">Edit</el-button>
          <el-button @click="$emit('delete', scope.row)" type="danger" size="small">Delete</el-button>
        </template>
      </el-table-column>
    </el-table>


  </div>
</template>


<script>
export default {
  emits: ['edit', 'delete', 'page-change'], 
  props: {
    tableData: {
      type: Array,
      required: true,
    },
    pagination: {
      type: Object,
      required: true,
    },
    dynamicFields: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      sortField: null,
      sortOrder: null,
    };
  },
  computed: {
  filteredFields() {
    return this.dynamicFields.filter(
      (field) => field.showInList !== false
    );
  },
},
  methods: {
    handlePageChange(page) {
      this.$emit('page-change', page);
    },

    handleSort({ prop, order }) {
      this.sortField = prop;
      this.sortOrder = order;
    },


  },
};

</script>

<style scoped>
.mt-4 {
  margin-top: 16px;
}
</style>
