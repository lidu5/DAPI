<template>
  <el-dialog
    :title="entityToEdit ? 'Edit ' + entityName : 'Create ' + entityName"
    v-model="localVisible"
    @close="handleClose"
    width="50%"
  >
    <el-form :model="formData" ref="formRef" :rules="formRules">
      <el-form-item
        v-for="field in filteredFormFields"
        :key="field.key"
        :label="field.label"
        :prop="field.key"
        :error="backendErrors[field.key]" 
        >
        <template v-if="field.type === 'text'">
          <el-input 
            v-model="formData[field.key]" 
            :placeholder="'Enter ' + field.label"
          ></el-input>
        </template>

        <template v-if="field.type === 'select'">
          <el-select 
            v-model="formData[field.key]" 
            placeholder="Select a value"
          >
            <el-option
              v-for="(option, index) in field.options"
              :key="index"
              :label="option.label"
              :value="option.value"
            ></el-option>
          </el-select>
        </template>

        <template v-if="field.type === 'number'">
          <el-input-number 
            v-model="formData[field.key]" 
            :placeholder="'Enter ' + field.label"
          ></el-input-number>
        </template>

        <template v-if="field.type === 'textarea'">
          <el-input 
            type="textarea" 
            v-model="formData[field.key]" 
            :placeholder="'Enter ' + field.label"
          ></el-input>
        </template>
      </el-form-item>
    </el-form>

    <template #footer>
      <div class="dialog-footer">
        <el-button @click="handleClose">Cancel</el-button>
        <el-button type="primary" @click="submitForm">Submit</el-button>
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
    entityName: String, 
    formFields: {
      type: Array,
      required: true, 
    },
    entityToEdit: {
      type: Object,
      default: null, 
    },
  },
  data() {
    return {
      formData: {}, 
      formRules: {}, 
      backendErrors: {}, 

    };
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
    filteredFormFields() {
      return this.formFields.filter(field => field.showInList !== true);
    }
  },
  watch: {
    entityToEdit: {
      immediate: true,
      handler(newVal) {
        this.formData = newVal ? { ...newVal } : {}; 

      },
    },
    modelValue: {
      immediate: true,
      handler(newVal) {
        if (!newVal) {
          this.formData = {}; 
        }
      },
    },
    formFields: {
      immediate: true,
      handler() {
        this.generateValidationRules();
      }
    },
  },
  methods: {
  handleClose() {
    this.localVisible = false;
    this.$emit("close");
  },
  submitForm() {
  this.$refs.formRef.validate((valid) => {
    if (valid) {
      const submission = this.$emit("submit", { ...this.formData });

      if (submission && submission instanceof Promise) {
        submission
          .then(() => {
            ElMessage({
              message: "Form submitted successfully!",
              type: "success",
            });
            this.handleClose();
          })
          .catch((error) => {
            if (error.response && error.response.status === 422) {
              this.backendErrors = Object.fromEntries(
                Object.entries(error.response.data.errors).map(([field, errors]) => [
                  field,
                  errors[0],
                ])
              );
              ElMessage.error("Please fix the errors and try again.");
            } else {
              ElMessage.error("An unexpected error occurred.");
            }
          });
      } else {
        ElMessage({
          message: "Form submitted successfully!",
          type: "success",
        });
        this.handleClose();
      }
    } else {
      ElMessage.error("Please correct the form errors");
    }
  });
},

  generateValidationRules() {
    this.formRules = {};
    this.formFields.forEach((field) => {
      let fieldRules = [];

      if (field.required) {
        fieldRules.push({
          required: true,
          message: `${field.label} is required`,
          trigger: "blur",
        });
      }

      if (field.type === "number") {
        fieldRules.push({
          type: "number",
          message: `${field.label} must be a valid number`,
          trigger: "blur",
        });
      }

      if (fieldRules.length > 0) {
        this.formRules[field.key] = fieldRules;
      }
    });
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
