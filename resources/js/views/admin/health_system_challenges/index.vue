<template>
    <div>
      <AdminLayout
        entityName="Health System Challenge"
        :dynamicFields="challengeFields"
        resourceUri="health-system-challenges"
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
        challengeFields: [
          { key: 'name', label: 'Name', type: 'text', sortable: true,required: true },
          { key: 'category', label: 'Category', type: 'textarea', sortable: true, required: true },
        ],
      };
    },
  };
  </script>
  