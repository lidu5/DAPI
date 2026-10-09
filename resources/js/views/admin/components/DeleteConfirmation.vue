<template>
  <el-dialog 
    v-model="localVisible" 
    title="Confirm Deletion"
    width="30%"
    :before-close="handleClose"
  >
    <span>Are you sure you want to delete <strong>{{ entityName }}</strong>?</span>
    <template #footer>
      <div class="dialog-footer">
        <el-button @click="handleClose">Cancel</el-button>
        <el-button type="danger" @click="confirmDelete">Delete</el-button>
      </div>
    </template>
  </el-dialog>
</template>

<script>
export default {
  props: {
    modelValue: {
      type: Boolean,
      required: true,
    },
    entityName: {
      type: String,
      required: true,
    },
  },
  computed: {
    localVisible: {
      get() {
        return this.modelValue;
      },
      set(value) {
        this.$emit("update:modelValue", value);
      },
    },
  },
  methods: {
    confirmDelete() {
      this.$emit("confirm-delete"); 

      this.$nextTick(() => {
        ElMessage({
          message: `${this.entityName} has been successfully deleted.`,
          type: "success",
        });
      });

      this.localVisible = false; 
    },
    handleClose() {
      this.localVisible = false;
    },
  },
};
</script>

<style scoped>
.dialog-footer {
  display: flex;
  justify-content: flex-end;
}
</style>
