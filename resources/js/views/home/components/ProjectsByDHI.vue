<template>
  <div :class="className" :style="{ height: height, width: width }" />
</template>

<script>
import * as  echarts from 'echarts';
require('echarts/theme/macarons'); // echarts theme
import { debounce } from '@/utils';

import Resource from '@/api/resource';

const getDataRoute = new Resource('dashboard/by_dhi');

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
      default: '355px',
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
      console.log(data)
      if (data) {
        const result = data.filter(da => da.projects_count != 0).map(da => ({ 'name': da.type, 'value': da.projects_count }))
console.log(result)
        this.chart.setOption({
          title: {
            text: 'Projects by Digital Health Interventions',
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
          series: [
            {
              name: 'Projects',
              type: 'pie',
              radius: ['35%', '60%'],
              center: ['50%', '45%'],
              // avoidLabelOverlap: false,
              itemStyle: {
                borderRadius: 10,
                borderColor: '#fff',
                borderWidth: 2,
              },
              label: {
                show: false,
                position: 'center',
              },
              labelLine: {
                show: false,
              },
              data: result,
            },
          ],
        });
      }
    },
  },
};
</script>
