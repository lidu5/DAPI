<template>
    <div>
      <AdminLayout
        entityName="Region"
        :dynamicFields="regionFields"
        resourceUri="regions"
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
        regionFields: [
          { key: 'name', label: 'Name', type: 'text', sortable: true,required: true },
        ], 
      };
    },
  };
  </script>
  