<template>
    <div>
      <AdminLayout
        entityName="Ownership Type"
        :dynamicFields="ownershipTypeFields"
        resourceUri="ownership-types"
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
        ownershipTypeFields: [
          { key: 'name', label: 'Name', type: 'text', sortable: true ,required: true},
          { key: 'description', label: 'Description', type: 'textarea' ,required: false },
        ], 
      };
    },
  };
  </script>
  