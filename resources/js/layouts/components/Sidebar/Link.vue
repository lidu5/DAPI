
<template>
  <!-- eslint-disable vue/require-component-is-->
  <component :is="type(to)" v-bind="linkProps(to)">
    <slot />
  </component>
</template>

<script>
import { isExternal } from '@/utils/validate';

export default {
  props: {
    to: {
      type: String,
      required: true,
    },
  },
  methods: {
    isExternalLink(routePath) {
      return isExternal(routePath);
    },
    linkProps(url) {
      if (this.isExternalLink(url)) {
        return {
          href: url,
          target: '_blank',
          rel: 'noopener',
        };
      }
      return {
        to: url,
      };
    },
    type(url){
      if (this.isExternalLink(url)) {
        return 'a'
      }
      return 'router-link'
    }
  },
};
</script>
