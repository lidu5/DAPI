import '@/styles/index.scss';
// import 'core-js';
import { createApp } from 'vue'

import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'

import App from '@/views/App.vue'

import router from '@/router'
import store from '@/store';

import '@/permission'; // permission control
import i18n from './lang'; // Internationalization

const app = createApp(App)

app.use(router)
app.use(store)

app.use(ElementPlus)
app.use(i18n)

app.directive('permission', {
  mounted: (el, binding) => {
    const { value } = binding;
    const permissions = store.getters && store.getters.permissions;

    if (value && value instanceof Array && value.length > 0) {
      const requiredPermissions = value;
      const hasPermission = permissions.some(permission => {
        return requiredPermissions.includes(permission);
      });

      if (!hasPermission) {
        el.parentNode && el.parentNode.removeChild(el);
      }
    } else {
      throw new Error(`Permissions are required! Example: v-permission="['manage user','manage permission']"`);
    }
  }
})

app.directive('role', {
  mounted: (el, binding) => {
    const { value } = binding;
    const roles = store.getters && store.getters.roles;

    if (value && value instanceof Array && value.length > 0) {
      const requiredRoles = value;
      const hasRole = roles.some(role => {
        return requiredRoles.includes(role);
      });

      if (!hasRole) {
        el.parentNode && el.parentNode.removeChild(el);
      }
    } else {
      throw new Error(`Roles are required! Example: v-role="['admin','editor']"`);
    }
  }
})

import mitt from 'mitt';
const emitter = mitt();
app.config.globalProperties.emitter = emitter;

import * as ElementPlusIconsVue from '@element-plus/icons-vue'

for (const [key, component] of Object.entries(ElementPlusIconsVue)) {
  app.component(key, component)
}

app.mount("#app")