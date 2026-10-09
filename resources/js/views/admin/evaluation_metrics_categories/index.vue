<template>
    <div>
      <AdminLayout
        entityName="Evaluation Metrics Category"
        :dynamicFields="itemFields"
        resourceUri= "evaluation-metrics-category"
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
          { key: 'weight', label: 'Weight', type: 'number', required: true },
        ], 
      };
    },
  };
  </script>
  