<template>
    <div>
      <AdminLayout
        entityName="E-heath Architecture Components "
        :dynamicFields="itemFields"
        resourceUri= "eha-component"
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
  