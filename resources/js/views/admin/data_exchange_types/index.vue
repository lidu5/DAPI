<template>
    <div>
      <AdminLayout
        entityName="Data Exchange Type"
        :dynamicFields="itemFields"
        resourceUri="data-exchange-type"
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
