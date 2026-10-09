<template>
    <div>
      <AdminLayout
        entityName="Data Standards"
        :dynamicFields="itemFields"
        resourceUri= "data-standards"
      />
    </div>
  </template>
  
  <script>
  import AdminLayout from '../components/Layout.vue';  
  
  export default {
    components: {
      AdminLayout,
    },
    data() {
      return {
        itemFields: [
          { key: 'name', label: 'Name', type: 'text', sortable: true, required: true },
          { key: 'description', label: 'Description', type: 'textarea', required: false },
          { key: 'category', label: 'Category', type: 'text',  sortable: true, required: true },
  
        ], 
      };
    },
  };
  </script>
  