<template>
    <div>
      <AdminLayout
        entityName="Health Professional Group"
        :dynamicFields="groupFields"
        resourceUri="health-professional-groups"
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
        groupFields: [
          { key: 'name', label: 'Name', type: 'text',required: true, sortable: true },
          { key: 'description', label: 'Description', type: 'textarea' ,required: false},
        ], 
      };
    },
  };
  </script>
  