<template>
  <el-row class="container">
    <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12" class="image-column">
      <img src="@/assets/registration/moa_registration.jpg" alt="Digital Agriculture Projects" class="left-image" />
    </el-col>
    <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12" class="form-column">
      <el-card class="box-card" style="background-color: white;">
        <template #header>
          <div class="card-header">
            <span>Create an Account</span>
          </div>
        </template>
        <el-form ref="registrationForm" :model="registrationForm" :rules="registrationRule" class="login_form" auto-complete="on" label-position="top">
          <el-form-item label="Full Name" required style="margin-bottom: 0;">
            <el-row :gutter="10">
              <el-col :xs="24" :sm="24" :md="8" :lg="8" :xl="8">
                <el-form-item prop="firstName">
                  <el-input v-model="registrationForm.firstName" placeholder="First Name" />
                </el-form-item>
              </el-col>
              <el-col :xs="24" :sm="24" :md="8" :lg="8" :xl="8">
                <el-form-item prop="middleName">
                  <el-input v-model="registrationForm.middleName" placeholder="Father Name" />
                </el-form-item>
              </el-col>
              <el-col :xs="24" :sm="24" :md="8" :lg="8" :xl="8">
                <el-form-item prop="lastName">
                  <el-input v-model="registrationForm.lastName" placeholder="Grandfather Name" />
                </el-form-item>
              </el-col>
            </el-row>
          </el-form-item>
          <!-- <el-form-item label="Request Role" prop="role">
            <el-select v-model="registrationForm.role" placeholder="please select your role">
              <el-option v-for="role in formData.roles" :key="role.id" :label="role.name.toUpperCase()" :value="role.name" :title="roleDescriptions[role.name]" />
            </el-select>
          </el-form-item> -->
          <el-form-item label="Organization" prop="work">
            <el-select v-model="registrationForm.work" placeholder="please select your organization">
              <el-option v-for="work in formData.works" :key="work.id" :label="work.name" :value="work.name" />
            </el-select>
          </el-form-item>
          <el-form-item label="Profession" prop="profession">
            <el-select v-model="registrationForm.profession" placeholder="please select your profession">
              <el-option v-for="profession in formData.professions" :key="profession.id" :label="profession.name" :value="profession.name" />
            </el-select>
          </el-form-item>
          <el-form-item label="Address" prop="address">
            <el-select v-model="registrationForm.address" placeholder="please select your Address">
              <el-option v-for="address in formData.addresses" :key="address.id" :label="address.name" :value="address.name" />
            </el-select>
          </el-form-item>
          <el-form-item prop="email" label="Email">
            <el-input v-model="registrationForm.email" type="text" />
          </el-form-item>
          <el-form-item prop="phoneNumber" label="Phone Number">
            <el-input v-model="registrationForm.phoneNumber" type="text" autocomplete="off" />
          </el-form-item>
          <el-form-item prop="password" label="Password">
            <el-input v-model="registrationForm.password" :type="show ? 'text' : 'password'" autocomplete="new-password">
              <template #append>
                <el-icon>
                  <Lock v-if="show" @click="show = false" />
                  <View v-if="!show" @click="show = true" />
                </el-icon>
              </template>
            </el-input>
          </el-form-item>
          <el-form-item prop="confirmPassword" label="Confirm Password">
            <el-input v-model="registrationForm.confirmPassword" :type="showConfirm ? 'text' : 'password'">
              <template #append>
                <el-icon>
                  <Lock v-if="showConfirm" @click="showConfirm = false" />
                  <View v-if="!showConfirm" @click="showConfirm = true" />
                </el-icon>
              </template>
            </el-input>
          </el-form-item>
          <el-form-item prop="agreement">
  <div style="display: flex; align-items: center;">
    <input 
      type="checkbox" 
      v-model="registrationForm.agreement" 
      style="width: 18px; height: 18px; margin-left: 2px; margin-right: 8px; cursor: pointer; accent-color: #007bff;" 
    />
<span>I agree to the Terms and Conditions of the DHPI system.<span class="superscript">*</span></span>
  </div>
</el-form-item>

          <el-row justify="end">
            <el-form-item class="login_btn">
              <el-button :loading="loading" type="primary" @click.prevent="handleRegister">
                Create Account
              </el-button>
            </el-form-item>
          </el-row>
        </el-form>
      </el-card>
    </el-col>
  </el-row>
</template>

<style scoped>
.container {
  overflow: hidden;
  padding: 60px 0;
  max-width: 90%;
  margin: auto;
  margin-top: 10px;
}
.image-column {
  padding-right: 10px;
}
.form-column {
  padding-left: 10px;
}
.left-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.el-card {
  height: 100%;
}
.el-form-item {
  margin-bottom: 20px;
}
.el-select {
  width: 100%;
}

.superscript {
    vertical-align: super;
    font-size: big;
    color: #f56c6c; 
}
.card-header {
  text-align: center;
  font-weight: bold;
  font-size: 1.5rem;
}
</style>

<script>
import { validEmail } from '@/utils/validate'
import Resource from '@/api/resource';

const getFormData = new Resource('registration/form-data');
const registerUser = new Resource('auth/register');

export default {
  name: 'Registration',
  data() {
    const validateEmail = (rule, value, callback) => {
      if (!validEmail(value)) {
        callback(new Error('Please enter valid email'));
      } else {
        callback();
      }
    };
    const validatePass = (rule, value, callback) => {
      if (value.length < 4) {
        callback(new Error('Password cannot be less than 4 digits'));
      } else {
        callback();
      }
    };
    const validateConfPass = (rule, value, callback) => {
      if (value !== this.registrationForm.password) {
        callback(new Error('Confirm password does not match password'));
      } else {
        callback();
      }
    };
    const validateName = (rule, value, callback) => {
      const regex = /^[a-zA-Z]+$/;
      if (!regex.test(value)) {
        callback(new Error(`${rule.field} only should contain alphabets`));
      } else {
        callback();
      }
    };
    const validatePhoneNumber = (rule, value, callback) => {
      const regex = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
      if (!regex.test(value)) {
        callback(new Error('Please enter valid phone number(09XXXXXXXX)'));
      } else {
        callback();
      }
    };
    return {
      registrationForm: {
        firstName: '',
        middleName: '',
        lastName: '',
        work: '',
        profession: '',
        address: '',
        phoneNumber: '',
        email: '',
        password: '',
        confirmPassword: '',
        // role: '',
        agreement: false,
      },
      formData: {
        // roles: [],
        works: [],
        professions: [],
        addresses: [],
      },
      registrationRule: {
        firstName: [{ required: true, trigger: 'blur', validator: validateName }],
        middleName: [{ required: true, trigger: 'blur', validator: validateName }],
        lastName: [{ required: true, trigger: 'blur', validator: validateName }],
        // role: [{ required: true, trigger: 'blur' }],
        agreement: [{ required: true, trigger: 'blur', validator: (rule, value, callback) => {
          return value ? callback() : callback(new Error('Agreement should be set'));
        }}],
        phoneNumber: [{ required: true, trigger: 'blur', validator: validatePhoneNumber }],
        email: [{ required: true, trigger: 'blur', validator: validateEmail }],
        password: [{ required: true, trigger: 'blur', validator: validatePass }],
        confirmPassword: [{ required: true, trigger: 'blur', validator: validateConfPass }],
      },
      loading: false,
      show: false,
      showConfirm: false,
      redirect: undefined,
      otherQuery: {},
    };
  },
  methods: {
    handleRegister() {
      this.$refs.registrationForm.validate(valid => {
        if (valid) {
          this.loading = true;
          registerUser.store(this.registrationForm)
            .then(response => {
              // const role = this.formData.roles.find(role => role.id == this.registrationForm.role);
              let message = "Account has been created successfully! Please sign in to access your account.";
              // if (role && role.name !== "Visitor") {
              //   message = `Sign in and wait until the administrator validates your account for the ${role.name} role.`;
              // }
              this.$message({
                message: message,
                type: "success",
                duration: 5000,
              });
              this.$router.push("/login");
            })
            .catch(error => {
              console.log(error.response);
              if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;
                let errorMessages = [];
                for (const field in errors) {
                  if (errors.hasOwnProperty(field)) {
                    errorMessages.push(errors[field][0]);
                  }
                }
                this.$message({
                  message: errorMessages.join("<br>"),
                  type: "error",
                  dangerouslyUseHTMLString: true,
                  duration: 7000,
                });
              } else {
                this.$message({
                  message: error.response?.data?.message || "An unexpected error occurred. Please try again.",
                  type: "error",
                  duration: 5000,
                });
              }
            })
            .finally(() => {
              this.loading = false;
            });
        } else {
          this.$message.error("Form error! Please input valid values.");
          return false;
        }
      });
    },
    async getFormDatas() {
      const data = await getFormData.list();
      this.formData.works = data.works;
      this.formData.professions = data.professions;
      this.formData.addresses = data.addresses;
    }
  },
  created() {
    this.getFormDatas();
  }
};
</script>
