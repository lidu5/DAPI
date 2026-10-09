<template>
    <div>
      <AdminLayout
        entityName="Digital Health Intervention "
        :dynamicFields="itemFields"
        resourceUri= "digital-health-intervention"
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
          { key: 'name', label: 'Name', type: 'text', required: true, sortable: true },
          { key: 'type', label: 'Type', type: 'text', required: true, sortable: true },
          { key: 'category', label: 'Category', type: 'text', required: true, sortable: true },

        ],  
      };
    },
  };
  </script>
  