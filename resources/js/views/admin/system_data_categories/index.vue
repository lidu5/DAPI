<template>
    <div>
      <AdminLayout
        entityName="Data the System Holds"
        :dynamicFields="itemFields"
        resourceUri="system-data-category"
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
