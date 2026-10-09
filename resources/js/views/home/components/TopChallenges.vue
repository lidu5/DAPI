<template>
  <div :class="className" :style="{ height: height, width: width }" />
</template>

<script>
import * as  echarts from 'echarts';
require('echarts/theme/macarons'); // echarts theme
import { debounce } from '@/utils';

import Resource from '@/api/resource';

const getDataRoute = new Resource('dashboard/top_challenges');

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
      default: '400px',
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
      if (data) {
        const result = data.data.filter(da => da.projects_count != 0).map(da => ({ 'name': da.name, 'value': da.projects_count }))

        this.chart.setOption({
          title: {
            text: 'Top 5 Health System Challenges',
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
            bottom: 10,
            left: 'center',
            data: result.map(d => d.name),
          },
          series: [{
            name: 'Projects',
            type: 'pie',
            radius: '50%',
            center: ['50%', '40%'],
            selectedMode: 'single',
            data: result,
            emphasis: {
              itemStyle: {
                shadowBlur: 10,
                shadowOffsetX: 0,
                shadowColor: 'rgba(0, 0, 0, 0.5)',
              },
            },
          }],
        });
      }
    },
  },
};
</script>