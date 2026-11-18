<template>
    <div>
      <AdminLayout
        entityName="Data Update Frequency"
        :dynamicFields="itemFields"
        resourceUri="data-update-frequency"
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
