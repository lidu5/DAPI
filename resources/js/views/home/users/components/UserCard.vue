<template>
  <el-card v-if="user.name">
    <div class="user-profile">
      <div class="user-avatar box-center">
        <pan-thumb :image="user.avatar" :height="'100px'" :width="'100px'" :hoverable="false" />
      </div>
      <div class="box-center">
        <div class="user-name text-center">
          {{ user.name }}
        </div>
        <div class="user-role text-center text-muted">
          {{ getRole() }}
        </div>
      </div>
      <div class="box-info">
        <table>
          <tr v-if="user.roles.includes('representative')">
            <th>Phone</th>
            <td>{{ user.phone_number }}</td>
          </tr>
          <tr>
            <th>Email</th>
            <td>{{ user.email }}</td>
          </tr>
          <tr v-if="user.roles.includes('representative')">
            <th>Represents</th>
            <td>{{ user.facility_structure }}</td>
          </tr>
          <tr v-if="user.roles.includes('representative')">
            <th>Status</th>
            <td>{{ user.retire === 0 ? 'Active' : 'Inactive' }}</td>
          </tr>
        </table>
      </div>
      <div v-if="!user.roles.includes('admin') && checkRole(['admin'])" class="user-retire">
        <el-button
          v-role="['admin']"
          :type="user.retire === 1 ? 'success' : 'danger'"
          size="small"
          icon="el-icon-view"
          @click="handleRetire()"
        >
          {{ user.retire === 1 ? 'Activate' : 'Deactive' }}
        </el-button>
      </div>
      <el-dialog v-if="!user.roles.includes('admin')" :title="'Retirement Managment'" v-model="dialogRetireFormVisible">
        <div class="form-container">
          <span>{{
            user.retire === 1 ? 'Activate '+user.name+'?'
            : 'Are you sure you want to retire '+user.name+'? User will not be cannot login anymore?'
          }}</span>
        </div>
        <template #footer>
          <span class="dialog-footer">
            <el-button @click="dialogRetireFormVisible = false">
              {{ $t('table.cancel') }}
            </el-button>
            <el-button
              :type="user.retire === 1 ? 'success' : 'danger'"
              @click="retireUserFunc()"
            >
              {{ user.retire === 1 ? 'Activate' : 'Deactive' }}
            </el-button>
          </span>
        </template>
      </el-dialog>
    </div>
  </el-card>
</template>

<script>
import PanThumb from '@/components/PanThumb';
import checkRole from '@/utils/role';

import Resource from '@/api/resource';
const userResource = new Resource('users');

export default {
  components: { PanThumb },
  props: {
    user: {
      type: Object,
      default: () => {
        return {
          name: '',
          email: '',
          avatar: '',
          structure: '',
          roles: [],
          permissions: [],
        };
      },
    },
  },
  data() {
    return {
      dialogRetireFormVisible: false,
      userCreating: false,
    };
  },
  methods: {
    checkRole,
    getRole() {
      // const roles = this.user.roles.map(value => this.$options.filters.uppercaseFirst(value));
      const roles = this.user.roles
      return roles.join(' | ');
    },
    handleRetire() {
      this.dialogRetireFormVisible = true;
    },
    retireUserFunc() {
      this.userCreating = true;
      userResource
        .destroy(this.user.id)
        .then(response => {
          this.$message({
            message: 'User ' + this.user.name + ' has been updated successfully.',
            type: 'success',
            duration: 5 * 1000,
          });
          this.user.retire = this.user.retire === 1 ? 0 : 1;
          this.dialogRetireFormVisible = false;
        })
        .catch(error => {
          this.$message({
            message: error,
            type: 'danger',
            duration: 5 * 1000,
          });
        })
        .finally(() => {
          this.userCreating = false;
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.user-profile {
  .user-name {
    font-weight: bold;
  }
  .box-center {
    padding-top: 10px;
  }
  .user-role {
    padding-top: 10px;
    font-weight: 400;
    font-size: 14px;
  }
  .box-info {
    padding-top: 30px;
    table {
      border-top: 1px solid #dfe6ec;
      th {
        text-align: left;
      }
    }
  }
  .user-retire .el-button {
    width:50%;
    margin-left:25%;
    margin-right:25%;
    margin-top: 10px;
  }
}
</style>
