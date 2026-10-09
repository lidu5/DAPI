<template>
  <el-menu 
    :default-active="$route.path" 
    class="el-menu-demo" 
    mode="horizontal" 
    background-color="#fff"
    text-color="#000" 
    active-text-color="#11b51183" 
    :ellipsis="false"
    v-if="!isSmallScreen"
    >
    <div class="logo-container">
      <img 
        src="@/assets/moh/moa picture.png" 
        alt="Digital Health Project Inventory" 
        class="logo-main"
      />
      <img 
        src="@/assets/moh/moalogo_text.png" 
        alt="Logo Text" 
        class="logo-text"
      />
    </div>
      <el-menu-item index="/" @click="goMenu('/')">Home</el-menu-item>
      <el-sub-menu index="2">
        <template #title><span>About</span></template>
        <el-menu-item index="/about" @click="goMenu('/about')">About DAPI</el-menu-item>
       <!-- <el-menu-item index="/dhp" @click="goMenu('/dhp')">About eHA</el-menu-item> -->
      </el-sub-menu>
      <el-menu-item index="/projects/explore" @click="goMenu('/projects/explore')">Projects</el-menu-item>
      <el-menu-item index="/dashboard" @click="goMenu('/dashboard')">Analytics</el-menu-item>
      <el-menu-item index="/resources" @click="goMenu('/resources')">Resources</el-menu-item>
      <el-menu-item index="/contact" @click="goMenu('/contact')">Contact Us</el-menu-item>    
      <div class="flex-grow" />
      <el-menu-item index="/login" v-if="!isAuth" class="auth-button" @click="goMenu('/login')">Login</el-menu-item>
      <el-menu-item index="/register" v-if="!isAuth" class="auth-button" @click="goMenu('/register')">Register</el-menu-item>
      <el-menu-item v-if="isAuth && getUserRole" index="3-1" class="dashboard-button" @click="goHome()">Dashboard</el-menu-item>
      <el-menu-item  v-if="isAuth" index="3-2" class="auth-button" @click="logout">Logout</el-menu-item>
  </el-menu>

  <el-menu 
    :default-active="$route.path" 
    class="el-menu-demo" 
    mode="vertical" 
    background-color="#fff"
    text-color="#000" 
    active-text-color="#2cf0678a" 
    :ellipsis="false"
    v-if="isSmallScreen">
  <div class="logo-container-icons">
    <div class="logo-container">
      <img 
        src="@/assets/moh/logo-main.png" 
        alt="Digital Health Project Inventory" 
        class="logo-main"
      />
      <img 
        src="@/assets/moh/logo_text.jpg" 
        alt="Logo Text" 
        class="logo-text"
      />
    </div>

    <div class="menu-icons">
      <el-icon v-if="isSmallScreen && !menuCollapsed" @click="toggleMenu">
        <Menu />
      </el-icon>
      <el-icon v-if="isSmallScreen && menuCollapsed" @click="toggleMenu">
        <Close />
      </el-icon>
    </div>
  </div>
</el-menu>

<el-menu 
    :default-active="$route.path" 
    class="el-menu-demo collapsed-menu" 
    mode="vertical" 
    background-color="#fff"
    text-color="#000" 
    active-text-color="#11b55b83" 
    :ellipsis="false"
    v-if="isSmallScreen && menuCollapsed" >
    <el-menu-item>
      <div class="logo-container-icons">
    <!-- Logo on the left -->
    <div class="logo-container">
      <img 
        src="@/assets/moh/logo-main.png" 
        alt="Digital Health Project Inventory" 
        class="logo-main"
      />
      <img 
        src="@/assets/moh/logo_text.jpg" 
        alt="Logo Text" 
        class="logo-text"
      />
    </div>
  </div>
    </el-menu-item>
    <el-menu-item index="/" @click="goMenu('/')">Home</el-menu-item>
      <el-sub-menu index="2">
        <template #title><span>About</span></template>
        <el-menu-item index="/about" @click="goMenu('/about')">About DHPI</el-menu-item>
        <el-menu-item index="/dhp" @click="goMenu('/dhp')">About eHA</el-menu-item>
      </el-sub-menu>
      <el-menu-item index="/projects/explore" @click="goMenu('/projects/explore')">Projects</el-menu-item>
      <el-menu-item index="/dashboard" @click="goMenu('/dashboard')">Analytics</el-menu-item>
      <el-menu-item index="/resources" @click="goMenu('/resources')">Resources</el-menu-item>
      <el-menu-item index="/contact" @click="goMenu('/contact')">Contact Us</el-menu-item>    
      <div class="flex-grow" />
      <el-menu-item index="/login" v-if="!isAuth"  @click="goMenu('/login')">Login</el-menu-item>
      <el-menu-item index="/register" v-if="!isAuth" @click="goMenu('/register')">Register</el-menu-item>
        <el-menu-item v-if="isAuth && getUserRole" index="3-1" @click="goHome()">Dashboard</el-menu-item>
        <el-menu-item  v-if="isAuth" index="3-2" @click="logout">Logout</el-menu-item>
  </el-menu>

</template>

<style scoped>
  body, html {
    overflow-x: hidden;
  }

  .el-menu {
    position: fixed;
    top: 0;
    z-index: 99999 !important;
    width: 100%;
    padding: 2px 30px;
    height: auto;
  }

  .logo-container {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    margin-right: 20px;
  }

  .logo-main {
    height: 40px;
    width: auto;
    margin-right: 6px;
  }

  .logo-text {
    height: 40px;
    width: auto;
  }

  .el-menu-item {
    font-family: 'Arial', 'sans-serif';
    font-size: 18px;
    padding: 0 10px;
    font-weight: 500;
  }

  .el-sub-menu__title >span {
    font-family: 'Arial', 'sans-serif';
    font-size: 18px;
    padding: 0 10px;
    font-weight: 500;
  }

  .el-menu-item:hover,
  .el-menu-item:hover .el-menu-item {
    color: #11b5277a !important;
    background-color: white !important;
  }

  .el-menu-item.is-active {
    color: #11b54293 !important;
    background-color: white !important;
    border-bottom: 3px #11b51f93 solid !important;
    font-weight: bold !important;
  }

  .el-sub-menu.is-active {
    color: #11b53a79 !important;
    background-color: white !important;
    border-bottom: 2px #11b5508c solid !important;
  }

  .el-sub-menu.is-active .el-sub-menu__title > span {
    font-weight: bold !important;
  }

  .auth-button {
    border: 1px solid #11b55094;
    border-radius: 25px;
    color: #11b53a83;
    padding: 0 15px;
    margin-left: 15px;
    cursor: pointer;
    font-weight: bold !important;
  }

  .dashboard-button {
    color: #11b52c88;
    font-weight: bold !important;
  }

  .dashboard-button:hover {
    border: 1px solid #11b5357a;
    border-radius: 25px;
  }

  .auth-button:hover {
    background-color: #11b54288 !important;
    color: white !important;
  }

  .auth-button.is-active {
    background-color: #11b5118a !important;
    color: white !important;
  }

  .flex-grow {
    flex-grow: 1;
  }

  @media (max-width: 1100px) {
    .logo-container {
      justify-content: center; 
      margin-right: 0;
    }
    .el-menu {
      padding: 4px 10px;
    }

    .el-menu-item {
      font-size: 16px;
    }

    .el-menu-demo {
      width: 100%;
    }

    .collapsed-menu {
      position: fixed;
      top: 0;
      left: 0;
      width: auto;
      height: 75%; 
      z-index: 999;
      background-color: #fff;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
      overflow-y: auto;
      overflow-x: auto;

    }

    .collapsed-menu .el-menu-item {
      padding: 15px;
      font-size: 18px;
    }
  }
  .menu-icons {
    display: flex;
    align-items: flex-end;
  }

  .el-icon {
    cursor: pointer;
    font-size: 24px;
    margin-left: 10px; 
  }
  .logo-container-icons {
    display: flex;
    justify-content: space-between; 
    align-items: center; 
  }

  .logo-container {
    display: flex;
    align-items: center;
  }
  .menu-icons {
    display: flex;
    align-items: center;
  }

  .el-icon {
    cursor: pointer;
    font-size: 24px;
    margin-left: 10px; 
  }

  .no-scroll {
  overflow: hidden;
}

</style>

<script>
import { mapGetters } from 'vuex';
import { isLogged } from '@/utils/auth';
import { ref } from 'vue';
import { Menu, Close } from '@element-plus/icons-vue';

export default {
  name: 'Header',
  components: {
    Menu,
    Close
  },
  data() {
    return {
      isAuth: isLogged(),
      isSmallScreen: false, 
      menuCollapsed: false, 
    }
  },
  computed: {
    ...mapGetters([
      'name',
      'avatar',
      'device',
      'userId',
      'roles',
      'user',
    ]),
    isUserLoggedIn() {
      return isLogged()
    },
    getUserRole() {
      if (!this.user.roles.includes('visitor'))
        return true
      else {
        if (['qa_approver', 'reg_approver', 'implementer'].includes(this.user.requested_role)) {
          return true
        }
      }
      return false
    }
  },
  methods: {
    async logout() {
      await this.$store.dispatch('user/logout')
      this.$router.push(`/login`)
      this.emitter.emit("is-auth", false);
    },
    goHome() {
      if (!this.roles.includes('visitor')) {
        this.$router.push('/home')
      } else if (this.user.requested_role && !this.roles.includes(this.user.requested_role)) {
        this.$router.push('/requested-role')
      } else {
        this.$router.push('/')
      }
    },
    goMenu(path) {
      this.menuCollapsed = false; 
      this.$router.push(path)
    },
    toggleMenu() {
      this.menuCollapsed = !this.menuCollapsed; 
    },
    checkScreenSize() {
      this.isSmallScreen = window.innerWidth <= 1100; 
    }
  },
  mounted() {
    this.emitter.on("is-auth", isOpen => {
      this.isAuth = !this.isAuth
    });

    window.addEventListener('resize', this.checkScreenSize);
    this.checkScreenSize();
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.checkScreenSize);
  },
}
</script>
