<template>
  <el-card v-if="user.name">
    <el-tabs v-model="activeActivity" @tab-click="handleClick">
      <el-tab-pane label="Activity" name="first">
        <div class="user-activity">
          <div class="post">
            <div class="user-block">
              <span class="description">{{ user.name }}
                <span>
                  Your have {{ user.roles.join('|') }} role(s) starting from {{ user.created_at }}
                </span>
              </span>
            </div>
            <p v-if="user.roles.includes('reg_approver')">
              Registration Approver responsibility
            </p>
            <p v-if="user.roles.includes('qa_approver')">
              QA Approver responsibility
            </p>
            <p v-if="user.roles.includes('admin')">
              As administrator you have full previlage for managing DHPI system.
              Below are all the permission on the system regarding cases.
            </p>
            <div class="box-social">
              <h3>Permissions</h3>
              <li v-for="item in user.permissions">
                {{ item.toUpperCase() }}
              </li>
            </div>
          </div>
        </div>
      </el-tab-pane>
      <el-tab-pane label="Profile Info" name="second">
        <el-form-item label="Name">
          <el-input v-model="user.name" />
        </el-form-item>
        <el-form-item label="Email">
          <el-input v-model="user.email" />
        </el-form-item>
        <el-form-item label="Phone Number">
          <el-input v-model="user.phone_number" />
        </el-form-item>
        <el-form-item v-if="checkRole(['admin'])" label="Role">
          <el-select v-model="user.role" placeholder="please select your role">
              <el-option v-for="role in new_roles" :key="role.id" :label="role.name.toUpperCase()" :value="role.name" />
            </el-select>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="handleEdit">
            Update
          </el-button>
        </el-form-item>
      </el-tab-pane>
      <el-tab-pane label="Account" name="third">
        <el-form ref="userForm" :model="account" label-position="left" label-width="150px" style="max-width: 500px;">
          <el-form-item v-if="!checkRole(['admin']) || this.$store.getters.userId == user.id" :label="$t('user.oldPassword')" prop="password">
            <el-input v-model="account.password" show-password />
          </el-form-item>
          <el-form-item :label="$t('user.newPassword')" prop="password">
            <el-input v-model="account.newPassword" show-password />
          </el-form-item>
          <el-form-item :label="$t('user.confirmPassword')" prop="confirmPassword">
            <el-input v-model="account.confirmPassword" show-password />
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="changePassword()">
              {{ $t('user.change_password') }}
            </el-button>
          </el-form-item>
        </el-form>
      </el-tab-pane>
    </el-tabs>
  </el-card>
</template>

<script>
import UserResource from '@/api/user';
import checkRole from '@/utils/role';

const userResource = new UserResource();


import Resource from '@/api/resource';
const getFormData = new Resource('registration/form-data');

export default {
  props: {
    user: {
      type: Object,
      default: () => {
        return {
          name: '',
          email: '',
          avatar: '',
          roles: [],
        };
      },
    },
  },
  data() {
    return {
      account: {},
      activeActivity: 'first',
      updating: false,
      new_roles: []
    };
  },
  methods: {
    checkRole,
    handleClick(tab, event) {
      console.log('Switching tab ', tab, event);
    },
    async getFormDatas(){
      const data = await getFormData.list({type: 'roles'});
      this.new_roles = data.roles;
      const role = this.new_roles.find((role) => this.user.roles.includes(role.name))
      this.user.role = role?.name
    },
    handleEdit() {
      this.updating = true;
      userResource
        .update(this.user.id, this.user)
        .then(response => {
          this.updating = false;
          this.user.name = response.data.name
          this.user.email = response.data.email
          this.user.phone_number = response.data.phone_number
          this.user.roles = response.data.roles
          this.user.permissions = response.data.permissions
          this.$message({
            message: 'User information has been updated successfully',
            type: 'success',
            duration: 5 * 1000,
          });
        })
        .catch(error => {
          console.log(error);
          this.updating = false;
        });
    },
    changePassword() {
      this.updating = true;
      userResource
        .changePassword(this.user.id, this.account)
        .then(response => {
          this.updating = false;
          this.account = {};
          this.$message({
            message: 'User information has been updated successfully',
            type: 'success',
            duration: 5 * 1000,
          });
        })
        .catch(error => {
          console.log(error);
          this.updating = false;
        });
    },
  },
  created() {
    this.getFormDatas()
  }
};
</script>

<style lang="scss" scoped>
.user-activity {
  .user-block {
    img {
      width: 40px;
      height: 40px;
      float: left;
    }
    :after {
      clear: both;
    }
    span {
      font-weight: 500;
      font-size: 12px;
    }
  }
  .post {
    font-size: 14px;
    border-bottom: 1px solid #d2d6de;
    margin-bottom: 15px;
    padding-bottom: 15px;
    color: #666;
  }
  .box-social {
    padding-top: 30px;
    .el-table {
      border-top: 1px solid #dfe6ec;
    }
  }
}
</style>
