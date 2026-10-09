<template>
  <header-component />
    <router-view/>
  <footer-component />
</template>

<script>
import { defineAsyncComponent } from 'vue'

const HeaderComponent = defineAsyncComponent(() => import('@/components/base/Header'))
const FooterComponent = defineAsyncComponent(() => import('@/components/base/Footer'))

export default {
  name: 'LayoutDefault',
  components: {
    HeaderComponent,
    FooterComponent,
  },
};
</script>