import LayoutAdmin from '@/layouts/LayoutAdmin';

const adminRoutes = {
  path: "/admin",
  component: LayoutAdmin,
  redirect: '/admin/organizations-partners/organization_units',
  meta: { roles: ['admin'], title: 'Admin', icon: 'setting', noCache: true },
  name: 'Admin',
  children: [
    // **Organizations & Partners**
    {
      path: 'organizations-partners',
      name: 'Organizations & Partners',
      redirect: '/admin/organizations-partners/organization_units',
      meta: { title: 'Organizations', icon: 'user', noCache: true },
      children: [
        {
          path: 'organization_units',
          name: 'Organization Units',
          component: () => import('@/views/admin/organization_units'),
          meta: { title: 'Organization Units', icon: 'house', noCache: true },
        },
        // {
        //   path: 'partners',
        //   name: 'Partners',
        //   component: () => import('@/views/admin/partners'),
        //   meta: { title: 'Partners', icon: 'discount', noCache: true },
        // },
        {
          path: 'ownership_types',
          name: 'Ownership Types',
          component: () => import('@/views/admin/ownership_types'),
          meta: { title: 'Ownership Types', icon: 'pointer', noCache: true },
        },
        {
          path: 'regions',
          name: 'Regions',
          component: () => import('@/views/admin/regions'),
          meta: { title: 'Regions', icon: 'umbrella', noCache: true },
        },
      ]
    },

    // **Health Systems**
    {
      path: 'health-systems',
      name: 'Health Systems',
      meta: { title: 'Health Systems', icon: 'star', noCache: true },
      redirect: '/admin/health-systems/digital_health_interventions',
      children: [
        {
          path: 'digital_health_interventions',
          name: 'Digital Health Interventions',
          component: () => import('@/views/admin/digital_health_interventions'),
          meta: { title: 'Digital Health Interventions', icon: 'dhi', noCache: true },
        },
        {
          path: 'health_focus_areas',
          name: 'Health Focus Areas',
          component: () => import('@/views/admin/health_focus_areas'),
          meta: { title: 'Health Focus Areas', icon: 'list', noCache: true },
        },
        {
          path: 'health_professionals',
          name: 'Health Professionals',
          component: () => import('@/views/admin/health_professional_groups'),
          meta: { title: 'Health Professionals', icon: 'coordinate', noCache: true },
        },
        {
          path: 'health_system_challenges',
          name: 'Health System Challenges',
          component: () => import('@/views/admin/health_system_challenges'),
          meta: { title: 'Health System Challenges', icon: 'dataline', noCache: true },
        },
        {
          path: 'facility_types',
          name: 'Facility Types',
          component: () => import('@/views/admin/facility_types'),
          meta: { title: 'Facility Types', icon: 'facility', noCache: true },
        },
        {
          path: 'eha_components',
          name: 'EHA Components',
          component: () => import('@/views/admin/eha_components'),
          meta: { title: 'EHA Components', icon: 'components', noCache: true },
        },
        {
          path: 'application_types',
          name: 'Application Types',
          component: () => import('@/views/admin/application_types'),
          meta: { title: 'Application Types', icon: 'components', noCache: true },
        },
      ]
    },

    // **Technology & Standards**
    {
      path: 'technology-standards',
      name: 'Technology & Standards',
      meta: { title: 'Technology & Standards', icon: 'technology', noCache: true },
      redirect: '/admin/technology-standards/application_platforms',
      children: [
        {
          path: 'application_platforms',
          name: 'Application Platforms',
          component: () => import('@/views/admin/application_platforms'),
          meta: { title: 'Application Platforms', icon: 'platform', noCache: true },
        },
        {
          path: 'dbms_supports',
          name: 'DBMS Support',
          component: () => import('@/views/admin/dbms_supports'),
          meta: { title: 'DBMS Support', icon: 'collection', noCache: true },
        },
        {
          path: 'os_support',
          name: 'OS Support',
          component: () => import('@/views/admin/os_supports'),
          meta: { title: 'OS Support', icon: 'infofilled', noCache: true },
        },
        {
          path: 'programming_languages',
          name: 'Programming Languages',
          component: () => import('@/views/admin/programming_languages'),
          meta: { title: 'Programming Languages', icon: 'monitor', noCache: true },
        },
        {
          path: 'data_standards',
          name: 'Data Standards',
          component: () => import('@/views/admin/data_standards'),
          meta: { title: 'Data Standards', icon: 'document', noCache: true },
        },
        {
          path: 'licenses',
          name: 'Licenses',
          component: () => import('@/views/admin/licenses'),
          meta: { title: 'Licenses', icon: 'checked', noCache: true },
        },
        {
          path: 'osi_approved_licenses',
          name: 'OSI Approved Licenses',
          component: () => import('@/views/admin/osi_approved_licenses'),
          meta: { title: 'OSI Approved Licenses', icon: 'trophy', noCache: true },
        }
      ]
    },

    // **Evaluation & Deployment**
    {
      path: 'evaluation-deployment',
      name: 'Evaluation & Deployment',
      meta: { title: 'Evaluation & Deployment', icon: 'evaluation', noCache: true },
      redirect: '/admin/evaluation-deployment/evaluation_metrics_categories',
      children: [
        {
          path: 'evaluation_metrics_categories',
          name: 'Evaluation Metrics Category',
          component: () => import('@/views/admin/evaluation_metrics_categories'),
          meta: { title: 'Evaluation Metrics Category', icon: 'category', noCache: true },
        },
        {
          path: 'evaluation_metrics',
          name: 'Evaluation Metrics',
          component: () => import('@/views/admin/evaluation_metrics'),
          meta: { title: 'Evaluation Metrics', icon: 'metrics', noCache: true },
        },
        {
          path: 'deployment_locations',
          name: 'Deployment Locations',
          component: () => import('@/views/admin/deployment_locations'),
          meta: { title: 'Deployment Locations', icon: 'cloud', noCache: true },
        }
      ]
    },
    {
      path: 'activity-logs',
      name: 'Activity Logs',
      meta: { title: 'Activity Logs', icon: 'pointer', noCache: true },
      redirect: '/admin/health-systems/digital_health_interventions',
      children: [
               {
          path: 'activity-logs',
          name: 'Activity Logs List',
          component: () => import('@/views/admin/activity_logs'),
          meta: { title: 'Activity Logs', icon: 'list', noCache: true },
        },
      ]
    }
  ]
}

export default adminRoutes;
