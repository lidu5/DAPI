import { createRouter, createWebHistory } from 'vue-router'
const LayoutDefault = () => import('@/layouts/LayoutDefault');
const LayoutAdmin = () => import('@/layouts/LayoutAdmin');

import projectRoute from './modules/project';
import userRoute from './modules/user';
import adminRoutes from './modules/admin';

export const constantRoutes = [
  {
    path: '/redirect',
    component: LayoutAdmin,
    hidden: true,
    children: [
      {
        path: '/redirect/:path*',
        component: () => import('@/views/redirect/index'),
      },
    ],
  },
  {
    path: '/',
    name: 'Default',
    component: LayoutDefault,
    hidden: true,
    children: [
      {
        path: '',
        name: 'Landing',
        component: () => import('@/views/default/home')
      },
     
     
      {
        path: 'about',
        name: 'About',
        component: () => import('@/views/default/About')
      },

      {
        path: 'dhp',
        name: 'DHP',
        component: () => import('@/views/default/dhp')
      },
      {
        path: 'resources',
        name: 'Resources',
        component: () => import('@/views/default/Resources')
      },
      {
        path: 'contact',
        name: 'Contact Us',
        component: () => import('@/views/default/Contact')
      },
      {
        path: 'login',
        name: 'Login',
        component: () => import('@/views/auth/login')

      },
      {
        path: 'register',
        name: 'Register',
        component: () => import('@/views/auth/register')
      }, 
      {
        path: 'dashboard',
        component: () => import('@/views/default/home/dashboard'),
        name: 'Projects Dashboard',
        hidden: true,
        meta: { title: 'Dashboard', noCache: true },
      },
      {
        path: 'auth-redirect',
        component: () => import('@/views/auth/login/AuthRedirect'),
      },
      {
        path: 'project/:uuid',
        component: () => import('@/views/default/project/'),
        name: 'Project Default View',
        hidden: true,
        meta: { title: 'Project Information', noCache: true },
      },
      {
        path: 'project/:uuid/certificate',
        component: () => import('@/views/default/project/Certificate'),
        name: 'Project Certificate',
        hidden: true,
        meta: { title: 'Project Certificate', noCache: true },
      },
      {
        path: 'projects/explore',
        component: () => import('@/views/default/dhp/Projects'),
        name: 'Explore Projects',
        hidden: true,
        meta: { title: 'Explore Project', noCache: true },
      },


    ]
  },
  {
    path: '/:pathMatch(.*)*',
    hidden: true,
    component: () => import('@/views/error-page/404')

  }
]

export const asyncRoutes = [
  {
    path: '/home',
    name: 'Home',
    component: LayoutAdmin,
    redirect: '/home',
    children: [
      {
        path: '',
        name: 'Home Dashboard',
        component: () => import('@/views/home'),
        meta: { title: 'Home', icon: 'dashboard', noCache: true },
      }
    ]
  },
  {
    path: '/profile',
    component: LayoutAdmin,
    redirect: '/profile/edit',
    name: 'Profile',
    meta: { permissions: ['manage self profile'] },
    children: [
      {
        path: 'edit',
        component: () => import('@/views/home/users/SelfProfile'),
        name: 'Self',
        meta: { title: 'User Profile', icon: 'user', noCache: true },
      },
    ],
  },
  {
    path: '/role',
    component: LayoutAdmin,
    redirect: '/role/requests',
    name: 'Requested Roles',
    meta: { permissions: ['approve requested role'] },
    children: [
      {
        path: 'requests',
        component: () => import('@/views/home/RequestedRoles'),
        name: 'Requests',
        meta: { title: 'Requested Roles', icon: 'check', noCache: true },
      },
    ],
  },
  {
    path: '/requested-role',
    component: LayoutDefault,
    redirect: '/requested-role/',
    name: 'Requested Role Notification',
    hidden: true,
    meta: { roles: ['visitor'] },
    children: [
      {
        path: '',
        component: () => import('@/views/default/RequestedRole'),
        name: 'Requests Notification',
      },
    ],
  },
  projectRoute,  
  {
    path: '/registration',
    component: LayoutAdmin,
    redirect: '/registration/projects',
    name: 'Registration',
    meta: { permissions: ['cert registration'] },
    children: [
      {
        path: 'projects',
        component: () => import('@/views/home/CertRegistration'),
        name: 'RegistrationProjects',
        meta: { title: 'Registration', icon: 'check', noCache: true },
      },
      {
        path: 'view/:id(\\d+)',
        component: () => import('@/views/home/project/View'),
        name: 'Project REG View',
        hidden: true,
        meta: { title: 'Project REG', permissions: ['view project'], noCache: true },
      },
    ],
  },
  {
    path: '/cert_competence',
    component: LayoutAdmin,
    redirect: '/cert_competence/projects',
    name: 'Cert Competence',
    meta: { permissions: ['cert competence'] },
    children: [
      {
        path: 'projects',
        component: () => import('@/views/home/CertCompetence'),
        name: 'Cert-Competence',
        meta: { title: 'Cert Competence', icon: 'check', noCache: true },
      },
      {
        path: 'view/:id(\\d+)',
        component: () => import('@/views/home/project/View'),
        name: 'Project COMP CERT View',
        hidden: true,
        meta: { title: 'Project COMP CERT', permissions: ['view project'], noCache: true },
      },
    ],
  },
  {
    path: '/resource',
    component: LayoutAdmin,
    redirect: '/resource/',
    name: 'Upload Resource',
    meta: { roles: ['admin'] },
    children: [
      {
        path: '',
        component: () => import('@/views/home/resources'),
        name: 'List Resource',
        meta: { title: 'Upload Resource', icon: 'document', noCache: true },
      },
    ],
  },
  userRoute,
  adminRoutes
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes: constantRoutes
})

// Detail see: https://github.com/vuejs/vue-router/issues/1234#issuecomment-357941465
export function resetRouter() {
  // const newRouter = createRouter();
  // router.matcher = newRouter.matcher; // reset router
  asyncRoutes.forEach((asyncRoute) => router.removeRoute(asyncRoute.name))
}


export default router