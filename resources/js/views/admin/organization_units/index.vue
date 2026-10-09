<template>
  <div>
    <AdminLayout
      entityName="Organization Unit"
      :dynamicFields="organizationUnitFields"
      resourceUri="organization-units"
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
      organizationUnitFields: [
        { key: 'name', label: 'Name', type: 'text', sortable: true, required: true },
        { key: 'description', label: 'Description', type: 'textarea', required: false },
        {
          key: 'type', 
          label: 'Type', 
          type: 'select', 
          options: [
            { value: 'IMPLEMENTING PARTNER', text: 'Implementing Partner' },
            { value: 'DONOR/INVESTMENT PARTNERS', text: 'Donor' },
            { value: 'AGENCIES', text: 'Agencies' },
            { value: 'GOVERNMENT', text: 'Government' },
            { value: 'PRIVATE SECTOR', text: 'Private Sector' }
          ], 
          required: true 
        },
      ],
    };
  },
};
</script>
