<template>
  <div class="project-sections">
    <el-empty v-if="!visibleSections.length" description="No information provided yet." />

    <section v-for="section in visibleSections" :key="section.title" class="info-section">
      <h3 class="info-title">{{ section.title }}</h3>

      <div v-if="section.facts.length" class="fact-table">
        <div v-for="item in section.facts" :key="item.label" class="fact-row">
          <div class="fact-label">{{ item.label }}</div>
          <div class="fact-value">{{ displayValue(item) }}</div>
        </div>
      </div>

      <div v-for="item in section.blocks" :key="item.label" class="info-block">
        <div class="block-label">{{ item.label }}</div>

        <p v-if="item.type === 'long'" class="block-long">{{ item.value }}</p>

        <div v-else-if="item.type === 'tags'" class="block-tags">
          <el-tag v-for="(tag, index) in item.value" :key="index" type="success" effect="light" round>
            {{ tag }}
          </el-tag>
        </div>

        <el-link
          v-else-if="item.type === 'link' || item.type === 'email'"
          type="primary"
          :href="href(item)"
          :target="item.type === 'link' ? '_blank' : '_self'"
          :underline="false"
        >
          <el-icon class="el-icon--left"><Link /></el-icon>{{ item.value }}
        </el-link>

        <a v-else-if="item.type === 'file'" :href="item.value" target="_blank" rel="noopener">
          <el-button type="primary" plain size="small">
            <el-icon class="el-icon--left"><Download /></el-icon>Download
          </el-button>
        </a>
      </div>
    </section>
  </div>
</template>

<script>
import { Link, Download } from '@element-plus/icons-vue';

const FACT_TYPES = ['text', 'bool'];

export default {
  name: 'ProjectSections',
  components: { Link, Download },
  props: {
    sections: {
      type: Array,
      default: () => [],
    },
  },
  computed: {
    visibleSections() {
      return this.sections
        .map(section => {
          const items = section.items.filter(item => !this.isEmpty(item));
          return {
            title: section.title,
            facts: items.filter(item => FACT_TYPES.includes(item.type)),
            blocks: items.filter(item => !FACT_TYPES.includes(item.type)),
          };
        })
        .filter(section => section.facts.length || section.blocks.length);
    },
  },
  methods: {
    isEmpty(item) {
      const value = item.value;
      if (value === null || value === undefined) return true;
      if (Array.isArray(value)) return value.length === 0;
      return String(value).trim() === '';
    },
    displayValue(item) {
      if (item.type === 'bool') {
        return item.value === true || item.value === 1 || item.value === '1' ? 'Yes' : 'No';
      }
      return item.value;
    },
    href(item) {
      const value = String(item.value).trim();
      if (item.type === 'email') return `mailto:${value}`;
      return /^https?:\/\//i.test(value) ? value : `http://${value}`;
    },
  },
};
</script>

<style scoped>
.info-section {
  margin-bottom: 28px;
}

.info-title {
  margin: 0 0 14px;
  padding-left: 12px;
  border-left: 4px solid #11b54a;
  font-size: 18px;
  font-weight: 700;
  color: #1f2d24;
}

.fact-table {
  border: 1px solid #e3ece6;
  border-radius: 10px;
  overflow: hidden;
  margin-bottom: 16px;
}

.fact-row {
  display: grid;
  grid-template-columns: 240px 1fr;
  border-bottom: 1px solid #e3ece6;
}

.fact-row:last-child {
  border-bottom: none;
}

.fact-label {
  padding: 12px 16px;
  background: #f3f8f5;
  font-weight: 600;
  color: #2f3f35;
}

.fact-value {
  padding: 12px 16px;
  color: #3b4a41;
  word-break: break-word;
}

.info-block {
  margin-bottom: 16px;
}

.block-label {
  margin-bottom: 6px;
  font-size: 13px;
  font-weight: 600;
  letter-spacing: 0.3px;
  text-transform: uppercase;
  color: #6b7a71;
}

.block-long {
  margin: 0;
  line-height: 1.7;
  color: #3b4a41;
  white-space: pre-line;
  word-break: break-word;
}

.block-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

@media (max-width: 768px) {
  .fact-row {
    grid-template-columns: 1fr;
  }

  .fact-label {
    padding-bottom: 4px;
  }

  .fact-value {
    padding-top: 4px;
  }
}
</style>
