<template>
  <div class="errPage-container">
    <h1>Thank you {{this.user.name }}, {{ this.user.requested_role }}  role is not approved yet. Please wait 24hr or communicate administrator</h1>
    <el-descriptions title="Biruk Bayhe">
      <el-descriptions-item label="Email"><a href= "mailto: beruck.bayhe@moh.gov.et?subject=Role Request Approval"> Send email for beruck.bayhe@moh.gov.et</a></el-descriptions-item>
      <el-descriptions-item label="Phone"><a href="tel:0911865642">0911865642</a></el-descriptions-item>
    </el-descriptions>
  </div>
</template>

<script>
import {
  ArrowDown,
} from '@element-plus/icons-vue'

import { mapGetters } from 'vuex';

export default {
  name: 'RequestedRole',
  computed: {
    ...mapGetters([
      'user',
    ])
  }
}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
  .errPage-container {
    width: 800px;
    max-width: 100%;
    margin: 100px auto;
    .pan-back-btn {
      background: #008489;
      color: #fff;
      border: none!important;
    }
    .pan-gif {
      margin: 0 auto;
      display: block;
    }
    .pan-img {
      display: block;
      margin: 0 auto;
      width: 100%;
    }
    .text-jumbo {
      font-size: 60px;
      font-weight: 700;
      color: #484848;
    }
    .list-unstyled {
      font-size: 14px;
      li {
        padding-bottom: 5px;
      }
      a {
        color: #008489;
        text-decoration: none;
        &:hover {
          text-decoration: underline;
        }
      }
    }
  }
</style>
