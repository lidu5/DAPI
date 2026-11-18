<template>
    <div>
      <AdminLayout
        entityName="System Language"
        :dynamicFields="itemFields"
        resourceUri="system-language"
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
