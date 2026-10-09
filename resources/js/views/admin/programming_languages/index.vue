<template>
    <div>
      <AdminLayout
        entityName="Programming Language"
        :dynamicFields="programmingLanguageFields"
        resourceUri="programming-languages"
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
        programmingLanguageFields: [
          { key: 'name', label: 'Name', type: 'text', sortable: true,required: true },
          { key: 'type', label: 'Type', type: 'textarea',required:false },
        ], 
      };
    },
  };
  </script>
  