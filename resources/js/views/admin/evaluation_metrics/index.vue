<template>
  <div>
    <AdminLayout
      entityName="Evaluation Metrics"
      :dynamicFields="itemFields"
      resourceUri="evaluation-metrics"
    />
  </div>
</template>

<script>
import AdminLayout from '../components/Layout.vue';  
import Resource from '@/api/resource';
const categories = new Resource('evaluation-metrics-category');

export default {
  components: {
    AdminLayout,
  },
  data() {
    return {
      itemFields: [
        { key: 'elements', label: 'Element', type: 'text', sortable: true, required: true },
        { key: 'weight', label: 'Weight', type: 'number', required: true },
        {
          key: 'evaluation_metrics_category_id', 
          label: 'Category',
          type: 'select',
          options: [], 
          required: true,
          showInList: false
        },
        {
          key: 'category_name', 
          label: 'Category Name',
          type: 'text',
          sortable: true,
          showInList: true, 
        },
      ],
      
      categoriesList: [], 
      loading: true, 
    };
  },
  async created() {
    await this.fetchCategories(); 
  },
  methods: {
    async fetchCategories() {
      try {
        const { data } = await categories.list(); 
        this.categoriesList = data; 
        this.populateCategoryOptions(); 
        this.loading = false; 
      } catch (error) {
        console.error("Error fetching categories:", error);
        this.loading = false; 
      }
    },
    populateCategoryOptions() {
      const categoryOptions = this.categoriesList.map(category => ({
        label: category.name, 
        value: category.id, 
      }));

      const categoryField = this.itemFields.find(field => field.key === 'evaluation_metrics_category_id');
      if (categoryField) {
        categoryField.options = categoryOptions;
      }
      console.log(categoryOptions)
    },
  },
};
</script>
