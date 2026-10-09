<script>
import { h } from 'vue'

export default {
  beforeCreate() {
    const { params, query } = this.$route;
    const { path } = params;
    this.$router.replace({ path: '/' + path.join('/'), query });
  },
  render: function() {
    // return h(); // avoid warning message
    return h('div')
  },
};
</script>
