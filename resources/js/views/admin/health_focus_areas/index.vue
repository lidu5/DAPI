<template>
    <div>
      <AdminLayout
        entityName="Health Focus Area"
        :dynamicFields="itemFields"
        resourceUri= "health-focus-area"
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
        ], 
      };
    },
  };
  </script>
  