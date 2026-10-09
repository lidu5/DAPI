/** When your routing table is too long, you can split it into small modules**/
const LayoutAdmin = () => import('@/layouts/LayoutAdmin');

const projectRoute = {
    path: '/projects',
    component: LayoutAdmin,
    redirect: '/projects/list',
    meta: { permissions: ['view projects'] },
    name: 'Project',
    children: [
      {
        path: 'list',
        component: () => import('@/views/home/project/List'),
        name: 'List Projects',
        meta: { title: 'Projects', icon: 'list', permissions: ['view projects'], noCache: true },
      },
      {
        path: 'new',
        component: () => import('@/views/home/project/New'),
        name: 'New Project',
        hidden: true,
        meta: { title: 'New Project', permissions: ['add project'], noCache: false },
      },
      {
        path: 'view/:id(\\d+)',
        component: () => import('@/views/home/project/View'),
        name: 'Project View',
        hidden: true,
        meta: { title: 'Project Information', permissions: ['view project'], noCache: true },
      },
    ],
};

export default projectRoute;
