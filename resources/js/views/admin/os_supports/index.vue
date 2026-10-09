<template>
    <div>
      <AdminLayout
        entityName="OS Support"
        :dynamicFields="osSupportFields"
        resourceUri="os-supports"
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
        osSupportFields: [
          { key: 'name', label: 'Name', type: 'text', sortable: true ,required: true},
          { key: 'description', label: 'Description', type: 'textarea' ,required: false},
        ], 
      };
    },
  };
  </script>
  