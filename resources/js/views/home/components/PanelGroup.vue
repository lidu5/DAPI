<template>
  <el-row :gutter="40" class="panel-group">
    <el-col :xs="24" :sm="12" :md="12" :lg="6" :xl="4" class="card-panel-col">
      <div class="card-panel">
        <div class="card-panel-icon-wrapper icon-tree">
          <el-icon :size="40"><Loading class="card-panel-icon"/></el-icon>          
        </div>
        <div class="card-panel-description">
          <div class="card-panel-text">
            New DAS
          </div>
          <count-to :start-val="0" :end-val="new_projects" :duration="2600" class="card-panel-num" />
        </div>
      </div>
    </el-col>
    <el-col :xs="24" :sm="12" :md="12" :lg="6" :xl="4" class="card-panel-col">
      <div class="card-panel">
        <div class="card-panel-icon-wrapper icon-table">
          <el-icon :size="40"><EditPen class="card-panel-icon"/></el-icon>          
        </div>
        <div class="card-panel-description">
          <div class="card-panel-text">
            Reg Request
          </div>
          <count-to :start-val="0" :end-val="request_cert_reg" :duration="3000" class="card-panel-num" />
        </div>
      </div>
    </el-col>
    <el-col :xs="24" :sm="12" :md="12" :lg="6" :xl="4" class="card-panel-col">
      <div class="card-panel">
        <div class="card-panel-icon-wrapper icon-list">
          <el-icon :size="40"><Notebook class="card-panel-icon"/></el-icon>          
        </div>
        <div class="card-panel-description">
          <div class="card-panel-text">
            Reg Approved
          </div>
          <count-to :start-val="0" :end-val="cert_reg" :duration="3200" class="card-panel-num" />
        </div>
      </div>
    </el-col>
    <el-col :xs="24" :sm="12" :md="12" :lg="6" :xl="4" class="card-panel-col">
      <div class="card-panel">
        <div class="card-panel-icon-wrapper icon-people">
          <el-icon :size="40"><EditPen class="card-panel-icon"/></el-icon>          
        </div>
        <div class="card-panel-description">
          <div class="card-panel-text">
            Competence Req
          </div>
          <count-to :start-val="0" :end-val="request_cert_comp" :duration="3600" class="card-panel-num" />
        </div>
      </div>
    </el-col>
    <el-col :xs="24" :sm="12" :md="12" :lg="6" :xl="4" class="card-panel-col">
      <div class="card-panel">
        <div class="card-panel-icon-wrapper icon-people">
          <el-icon :size="40"><StarFilled class="card-panel-icon"/></el-icon>          
        </div>
        <div class="card-panel-description">
          <div class="card-panel-text">
            Competence Cert
          </div>
          <count-to :start-val="0" :end-val="cert_comp" :duration="3600" class="card-panel-num" />
        </div>
      </div>
    </el-col>
  </el-row>
</template>

<script>
import { CountTo } from 'vue3-count-to';
import Resource from '@/api/resource';

const getTotalsRoute = new Resource('dashboard/get-totals');

export default {
  components: {
    CountTo,
  },
  data() {
    return {
      new_projects: 0,
      request_cert_reg: 0,
      cert_reg: 0,
      request_cert_comp: 0,
      cert_comp: 0,
    };
  },
  created() {
    this.getTotals();
  },
  methods: {
    async getTotals() {
      const {data} = await getTotalsRoute.list();
      this.new_projects = Number(data.new_projects) || 0;
      this.request_cert_reg = Number(data.request_reg) || 0;
      this.cert_reg = Number(data.reg_apr) || 0;
      this.request_cert_comp = Number(data.request_cert_comp) || 0;
      this.cert_comp = Number(data.cert_comp) || 0;
    },
  },
};
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.panel-group {
  margin-top: 18px;
  .card-panel-col{
    margin-bottom: 32px;
  }
  .card-panel {
    height: 108px;
    cursor: pointer;
    font-size: 12px;
    position: relative;
    overflow: hidden;
    color: #666;
    background: #fff;
    box-shadow: 4px 4px 40px rgba(0, 0, 0, .05);
    border-color: rgba(0, 0, 0, .05);
    &:hover {
      .card-panel-icon-wrapper {
        color: #fff;
      }
      .icon-people {
         background: #40c9c6;
      }
      .icon-table {
        background: #36a3f7;
      }
      .icon-list {
        background: #f4516c;
      }
      .icon-tree {
        background: #34bfa3
      }
    }
    .icon-people {
      color: #40c9c6;
    }
    .icon-table {
      color: #36a3f7;
    }
    .icon-list {
      color: #f4516c;
    }
    .icon-tree {
      color: #34bfa3
    }
    .card-panel-icon-wrapper {
      float: left;
      margin: 14px 0 0 14px;
      transition: all 0.38s ease-out;
      border-radius: 6px;
    }
    .card-panel-icon {
      float: left;
      font-size: 48px;
    }
    .card-panel-description {
      float: right;
      font-weight: bold;
      margin: 26px;
      margin-left: 0px;
      .card-panel-text {
        line-height: 18px;
        color: rgba(0, 0, 0, 0.45);
        font-size: 16px;
        margin-bottom: 12px;
      }
      .card-panel-num {
        font-size: 20px;
      }
    }
  }
}
</style>