<template>
  <div class="container">
    <div class="login_box">
      <div class="instruction_text"> 
        <p>Please enter your details</p>
      </div>
      <div class="welcome_text">
        <h2>Welcome Back</h2>
      </div>
      <el-form ref="loginForm" :model="loginForm" :rules="loginRules" class="login_form" auto-complete="on" label-position="left">
        <el-form-item prop="email" class="form-item">
          <el-input v-model="loginForm.email" name="email" type="text" auto-complete="on" placeholder="Email" />
        </el-form-item>
        <el-form-item prop="password" class="form-item">
          <el-input v-model="loginForm.password" :type="show ? 'text' : 'password'" name="password" placeholder="Password" @keyup.enter="handleLogin">
            <template #append>
              <el-icon>
                <Lock v-if="show" @click="show = false" />
                <View v-if="!show" @click="show = true" />
              </el-icon>
            </template>
          </el-input>
        </el-form-item>
        <el-row justify="center">
          <el-form-item class="login_btn">
            <el-button :loading="loading" type="primary" @click.prevent="handleLogin" class="wide-btn">
              Sign in
            </el-button>
          </el-form-item>
        </el-row>
        <el-row class="sign-up" justify="center">
          <p style="font-size: 0.9rem;">Don't have an account? <a href="/register" class="link">Sign up</a></p>
        </el-row>
      </el-form>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.container {
  background-color: #F7F7F7;
  min-height: 110vh;
  margin-top: 50px;
  display: flex; 
  align-items: center; 
  justify-content: center;
}

.login_box {
  background-color: #ffffff;
  border-radius: 8px;
  padding: 20px;
  width: 450px;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
  height: 500px;
}

.instruction_text {
  text-align: left;
  font-size: 0.9rem;
}

.welcome_text {
  text-align: left;
  margin-bottom: 20px;

  h2 {
    font-size: 1.8rem;
    font-weight: bold;
    color: #111946;
  }
}

.login_form {
  padding: 20px 0;
}

.form-item {
  width: 80%;
  margin: 15px auto;
}

.login_btn {
  display: flex;
  justify-content: center;

  .el-button {
    background-color: #1172b5;
    border-color: #1172b5;
    color: #ffffff;
    width: 100%;
    margin-top: 20px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    padding: 20px;
    width: 350px;
  }

  .el-button:hover {
    background-color: #0d5c8e;
    border-color: #0d5c8e;
  }
}

.wide-btn {
  width: 100%;
}

.link {
  color: #1172b5;
  text-decoration: underline;
}

.forgot-password {
  margin-top: 10px;
  margin-bottom: 20px;
  text-align: right;
}

.sign-up {
  margin-top: 20px;
  text-align: center;
}

@media (max-width: 767.98px) {
  .login_box {
    width: 100%;
    margin: 0 10px;
  }
}
</style>

<script>
import { validEmail } from '@/utils/validate';
import { csrf } from '@/api/auth';

export default {
  name: 'Login',
  data() {
    const validateEmail = (rule, value, callback) => {
      if (!validEmail(value)) {
        callback(new Error('Please enter the correct email'));
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

    return {
      show: false,
      loginForm: {
        email: '',
        password: '',
      },
      loginRules: {
        email: [{ required: true, trigger: 'blur', validator: validateEmail }],
        password: [{ required: true, trigger: 'blur', validator: validatePass }],
      },
      loading: false,
      redirect: undefined,
      otherQuery: {},
    };
  },
  watch: {
    $route: {
      handler(route) {
        const query = route.query;
        if (query) {
          this.redirect = query.redirect;
          this.otherQuery = this.getOtherQuery(query);
        }
      },
      immediate: true,
    },
  },
  methods: {
    handleLogin() {
      this.$refs.loginForm.validate((valid) => {
        if (valid) {
          this.loading = true;
          csrf().then(() => {
            this.$store.dispatch('user/login', this.loginForm).then(() => {
              this.$router.push({ path: this.redirect || '/', query: this.otherQuery });
              this.loading = false;
              this.emitter.emit('is-auth', true);
            }).catch((error) => {
              this.loading = false;
              let message = 'Email or password is incorrect';
              if (error.toString().includes('401')) message = 'User credential error';
              else if (error.toString().includes('403')) message = 'User has been retired. Please contact the administrator';
              this.$message({ message, type: 'error', duration: 5000 });
            });
          });
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    },
    getOtherQuery(query) {
      return Object.keys(query).reduce((acc, cur) => {
        if (cur !== 'redirect') acc[cur] = query[cur];
        return acc;
      }, {});
    },
  },
};
</script>
