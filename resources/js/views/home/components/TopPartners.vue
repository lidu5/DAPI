<template>
  <div :class="className" :style="{height:height,width:width}" />
</template>

<script>
import * as  echarts from 'echarts';
require('echarts/theme/macarons'); // echarts theme
import { debounce } from '@/utils';

import Resource from '@/api/resource';

const getDataRoute = new Resource('dashboard/top_partners');

export default {
  props: {
    className: {
      type: String,
      default: 'chart',
    },
    width: {
      type: String,
      default: '100%',
    },
    height: {
      type: String,
      default: '350px',
    },
  },
  data() {
    return {
      chart: null,
    };
  },
  created() {
    this.getData();
  },
  mounted() {
    this.initChart();
    this.__resizeHandler = debounce(() => {
      if (this.chart) {
        this.chart.resize();
      }
    }, 100);
    window.addEventListener('resize', this.__resizeHandler);
  },
  beforeDestroy() {
    if (!this.chart) {
      return;
    }
    window.removeEventListener('resize', this.__resizeHandler);
    this.chart.dispose();
    this.chart = null;
  },
  methods: {
    initChart() {
      this.chart = echarts.init(this.$el, 'macarons');
    },
    async getData() {
      const { data } = await getDataRoute.list({});
      const result = data.filter(da => da.projects_count != 0).map(da => ({'name': da.name, 'value': da.projects_count}))
      this.chart.setOption({
        title: {
          text: 'Top 5 Partners',
          left: 'center',
          textStyle: {
            color: '#000000',
          },
        },
        tooltip: {
          trigger: 'item',
          textStyle: {
            color: '#000',
          },
        },
        legend: {
          left: 'center',
          bottom: '10',
          data: result.map(d => d.name),
        },
        calculable: true,
        series: [{
          name: 'Projects',
          type: 'pie',
          roseType: 'radius',
          radius: [15, 85],
          center: ['50%', '50%'],
          data: result,
          animationEasing: 'cubicInOut',
          animationDuration: 2600,
        }],
      });
    },
  },
};
</script>
