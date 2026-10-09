<template>
  <div :class="className" :style="{ height: height, width: width }" />
</template>

<script>
import * as  echarts from 'echarts';
require('echarts/theme/macarons'); // echarts theme
import { debounce } from '@/utils';

import Resource from '@/api/resource';

const getDataRoute = new Resource('dashboard/regional-projects-count');

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
      this.chart.setOption({
        title: {
          text: 'Number of Projects in Coverage Area',
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
        grid: {
          left: '3%',
          right: '4%',
          bottom: '3%',
          containLabel: true,
        },
        yAxis: [
          {
            type: 'category',
            data: data.map(d => d.name),
            axisTick: {
              alignWithLabel: true,
            },
            axisLabel: {
              interval: 0,
              // rotate: 30 //If the label names are too long you can manage this by rotating the label.
            }
          },
        ],
        xAxis: [
          {
            type: 'value',
          },
        ],
        series: [
          {
            name: 'Projects Coverage',
            type: 'bar',
            barWidth: '45%',
            data: data.map(d => d.projects_count),
          },
        ],
      });
    },
  },
};
</script>
