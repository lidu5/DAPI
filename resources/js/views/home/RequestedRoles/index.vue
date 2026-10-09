<template>
    <div class="app-container">
        <el-table :loading="loading" :data="requested_roles" style="width: 100%">
            <el-table-column label="Requested Date">
            <template #default="scope">
                <div style="display: flex; align-items: center">
                <el-icon><Timer /></el-icon>
                <span style="margin-left: 10px">{{ new Date(scope.row.updated_at) }}</span>
                </div>
            </template>
            </el-table-column>
            <el-table-column label="Name" prop="name" sortable>
            <template #default="scope">
                <el-popover effect="light" trigger="hover" placement="top" width="auto">
                <template #default>
                    <div>name: {{ scope.row.name }}</div>
                    <div>address: {{ scope.row.address }}</div>
                    <div>Phone: {{ scope.row.phone_number }}</div>
                </template>
                <template #reference>
                    <el-tag>{{ scope.row.name }}</el-tag>
                </template>
                </el-popover>
            </template>
            </el-table-column>
            <el-table-column label="Email" align="left">
              <template #default="scope">
                <span>{{ scope.row.email }}</span>
              </template>
            </el-table-column>
            <el-table-column label="Work" align="left">
              <template #default="scope">
                <span>{{ scope.row.work }}</span>
              </template>
            </el-table-column>
            <el-table-column label="Requested Role" align="center">
              <template #default="scope">
                <span>{{ scope.row.requested_role }}</span>
              </template>
            </el-table-column>
            <el-table-column label="Operations">
            <template #default="scope">
              <el-button :loading="loading" type="success" @click="approveRequest(scope.row)">
                <el-icon><Check/></el-icon>
              </el-button>
              <el-button :loading="loading" type="danger" circle @click="user = scope.row, dialogVisible = true">
                <el-icon><Delete/></el-icon>
              </el-button>              
            </template>
            </el-table-column>
        </el-table>
        <el-dialog
          v-model="dialogVisible"
          width="30%"
        >
          <span>Decline role request for {{ user.name }}</span>
          <template #footer>
            <span class="dialog-footer">
              <el-button :loading="loading" @click="dialogVisible = false">Cancel</el-button>
              <el-button :loading="loading" type="danger" @click="removeRequest(user)"
                >Yes</el-button
              >
            </span>
          </template>
        </el-dialog>
    </div>    
</template>

<script>
  import Resource from '@/api/resource';
  const roleRequest = new Resource('user/role-request');

  export default{
      name: 'Requested Role',
      data(){
          return {
              requested_roles: [],
              loading: true,
              dialogVisible: false,
              user: {}
          }
      },
      created(){
          this.requestedRoles()
      },
      methods: {
        async requestedRoles(){
          const { data } = await roleRequest.list()
          this.requested_roles = data
          this.loading = false
        },
        approveRequest(user){
            this.loading = true;
            roleRequest
              .store(user)
              .then(response => {
              this.$message({
                message: `Role ${user.requested_role} is approved for ${user.name}.`,
                type: 'success',
                duration: 5 * 1000,
              });
              this.requested_roles.splice(this.requested_roles.indexOf(user), 1)
            })
            .catch(error => {
              console.log(error)
            })
            .finally(() => {
              this.loading = false
            });
        },
        removeRequest(user){
          this.loading = true
          roleRequest
            .destroy(user.id)
            .then(response => {
            this.$message({
              message: `Role ${user.requested_role} request has been declined for ${user.name}.`,
              type: 'success',
              duration: 5 * 1000,
            });
            this.requested_roles.splice(this.requested_roles.indexOf(user), 1)
          })
          .catch(error => {
            console.log(error)
          })
          .finally(() => {
            this.user = {}
            this.dialogVisible = false
            this.loading = false
          });
        }
      }
  }
</script>
