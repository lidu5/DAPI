/** When your routing table is too long, you can split it into small modules**/
const LayoutAdmin = () => import('@/layouts/LayoutAdmin');

const userRoute = {
  path: '/users',
  component: LayoutAdmin,
  redirect: '/users/list',
  meta: { permissions: ['manage user'] },
  name: 'Users',
  children: [
    {
      path: 'list',
      component: () => import('@/views/home/users/List'),
      name: 'List User',
      meta: { title: 'Users', icon: 'user', noCache: true },
    },
    {
      path: 'view/:id(\\d+)',
      component: () => import('@/views/home/users/UserProfile'),
      name: 'View Usdr',
      hidden: true,
      meta: { title: 'User Info', noCache: true },
    },
  ],
};

export default userRoute;
