import { login, logout, getInfo } from '@/api/auth';
import { isLogged, setLogged, removeToken } from '@/utils/auth';
import router, { resetRouter } from '@/router';
import store from '@/store';

const state = {
  id: null,
  user: null,
  token: isLogged(),
  name: '',
  avatar: '',
  phone_number: '',
  email: '',
  work: '',
  profession: '',
  address: '',
  requested_role: '',
  roles: [],
  permissions: [],
};

const mutations = {
  SET_ID: (state, id) => {
    state.id = id;
  },
  SET_TOKEN: (state, token) => {
    state.token = token;
  },
  SET_PHONE_NUMBER: (state, phone_number) => {
    state.phone_number = phone_number;
  },
  SET_NAME: (state, name) => {
    state.name = name;
  },
  SET_AVATAR: (state, avatar) => {
    state.avatar = avatar;
  },
  SET_EMAIL: (state, email) => {
    state.email = email;
  },
  SET_WORK: (state, work) => {
    state.work = work;
  },
  SET_PROFESSION: (state, profession) => {
    state.profession = profession;
  },
  SET_ADDRESS: (state, address) => {
    state.address = address;
  },
  SET_REQUESTED_ROLE: (state, requested_role) => {
    state.requested_role = requested_role;
  },
  SET_ROLES: (state, roles) => {
    state.roles = roles;
  },
  SET_PERMISSIONS: (state, permissions) => {
    state.permissions = permissions;
  },
};

const actions = {
  // user login
  login({ commit }, userInfo) {
    const { email, password } = userInfo;
    return new Promise((resolve, reject) => {
      login({ email: email.trim(), password: password })
        .then(response => {
          setLogged('1');
          resolve();
        })
        .catch(error => {
          console.log(error);
          reject(error);
        });
    });
  },

  // get user info
  getInfo({ commit, state }) {
    return new Promise((resolve, reject) => {
      getInfo()
        .then(response => {
          const { data } = response;

          if (!data) {
            reject('Verification failed, please Login again.');
          }

          const { roles, name, email, avatar, phone_number, permissions, id, work, profession, address, requested_role } = data;
          // roles must be a non-empty array
          if (!roles || roles.length <= 0) {
            reject('getInfo: roles must be a non-null array!');
          }

          commit('SET_ROLES', roles);
          commit('SET_PERMISSIONS', permissions);
          commit('SET_NAME', name);
          commit('SET_EMAIL', email);
          commit('SET_AVATAR', avatar);
          commit('SET_PHONE_NUMBER', phone_number);
          commit('SET_ID', id);
          commit('SET_WORK', work);
          commit('SET_PROFESSION', profession);
          commit('SET_ADDRESS', address);
          commit('SET_REQUESTED_ROLE', requested_role);
          resolve(data);
        })
        .catch(error => {
          reject(error);
        });
    });
  },

  // user logout
  logout({ commit }) {
    return new Promise((resolve, reject) => {     
      logout()
        .then(() => {
          commit('SET_TOKEN', '');
          commit('SET_ROLES', []);
          commit('SET_PERMISSIONS', []);
          commit('SET_REQUESTED_ROLE', '');
          commit('SET_ADDRESS', '');
          commit('SET_PROFESSION', '');
          commit('SET_WORK', '');
          commit('SET_EMAIL', '');
          commit('SET_AVATAR', '');
          commit('SET_NAME', '');
          commit('SET_PHONE_NUMBER', '');
          commit('SET_ID', '');
          removeToken();
          resetRouter();
          resolve();
        })
        .catch(error => {
          reject(error);
        });
    });
  },

  // remove token
  resetToken({ commit }) {
    return new Promise(resolve => {
      commit('SET_TOKEN', '');
      commit('SET_ROLES', []);
      commit('SET_PERMISSIONS', []);
      commit('SET_REQUESTED_ROLE', '');
      commit('SET_ADDRESS', '');
      commit('SET_PROFESSION', '');
      commit('SET_WORK', '');
      commit('SET_EMAIL', '');
      commit('SET_AVATAR', '');
      commit('SET_NAME', '');
      commit('SET_PHONE_NUMBER', '');
      commit('SET_ID', '');
      removeToken();
      resolve();
    });
  },

  // Dynamically modify permissions
  changeRoles({ commit, dispatch }, role) {
    return new Promise(async resolve => {
      // const token = role + '-token';

      // commit('SET_TOKEN', token);
      // setLogged(token);

      // const { roles } = await dispatch('getInfo');

      const roles = [role.name];
      const permissions = role.permissions.map(permission => permission.name);
      commit('SET_ROLES', roles);
      commit('SET_PERMISSIONS', permissions);
      resetRouter();

      // generate accessible routes map based on roles
      const accessRoutes = await store.dispatch('permission/generateRoutes', { roles, permissions });

      // dynamically add accessible routes
      router.addRoutes(accessRoutes);

      resolve();
    });
  },
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
};
