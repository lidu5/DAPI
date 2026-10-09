<template>
  <div>
    <AdminLayout
      entityName="Application Types"
      :dynamicFields="itemFields"
      resourceUri="application-types"
    />
  </div>
</template>

<script>
import AdminLayout from '../components/Layout.vue'; 
import Resource from '@/api/resource';
const categories = new Resource('eha-component'); 

export default {
  components: {
    AdminLayout,
  },
  data() {
    return {
      itemFields: [
        { key: 'name', label: 'Name', type: 'text', sortable: true, required: true },
        {
          key: 'eha_component_id', 
          label: 'EHA Component',
          type: 'select',
          options: [], 
          required: true,
          showInList: false
        },
        {
          key: 'eha_component_name', 
          label: 'EHA Component',
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

      const categoryField = this.itemFields.find(field => field.key === 'eha_component_id');
      if (categoryField) {
        categoryField.options = categoryOptions;
      }
      console.log(categoryOptions)
    },
  },
};
</script>
