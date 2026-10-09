<template>
    <div>
      <AdminLayout
        entityName="License"
        :dynamicFields="licenseFields"
        resourceUri="licenses"
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
        licenseFields: [
          { key: 'name', label: 'Name', type: 'text', sortable: true ,required: true},
        ],
      };
    },
  };
  </script>
  