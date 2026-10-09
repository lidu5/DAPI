<template>
    <div>
      <AdminLayout
        entityName="Facility Type"
        :dynamicFields="itemFields"
        resourceUri= "facility-type"
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
  