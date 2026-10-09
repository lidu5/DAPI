<template>
    <div>
      <AdminLayout
        entityName="Deployment Location"
        :dynamicFields="itemFields"
        resourceUri= "deployment-locations"
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
          { key: 'description', label: 'Description', type: 'textarea', required: false },
        ], 
      };
    },
  };
  </script>
  