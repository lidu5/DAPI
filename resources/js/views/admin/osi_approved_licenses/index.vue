<template>
    <div>
      <AdminLayout
        entityName="OSI Approved License"
        :dynamicFields="osiApprovedLicenseFields"
        resourceUri="osi-approved-licenses"
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
        osiApprovedLicenseFields: [
          { key: 'name', label: 'Name', type: 'text', sortable: true,required: true },
        ], 
      };
    },
  };
  </script>
  