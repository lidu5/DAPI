<template>
  <section class="resource">
    <div class="container">
      <div class="section-title">
        <h2>Resources</h2>
        <p>
          Below you can find all resources uploaded by the DHPI team. These documents will help you on uploading
          resources.
        </p>
      </div>

      <div class="search-bar">
  <el-input
    v-model="query.keyword"
    clearable
    :placeholder="'search query'"
    class="search-query"
    @keyup.enter="handleFilter"
  />
  <el-button
    class="filter-item"
    type="primary"
    @click="handleFilter"
  >
    <el-icon class="el-icon--left">
      <Search />
    </el-icon>
    {{ $t('table.search') }}
  </el-button>
</div>


      <div class="card-list">
        <div
          v-for="(item, index) in list"
          :key="index"
          class="resource-card"
        >
          <div class="card-image" :style="{ backgroundImage: `url(${defaultBg})` }"></div>
          <div class="card-content">
            <div>
            <h6 class="title">{{ item.name }}</h6>
            <p class="description">{{ item.description }}</p>
          </div>
            <a :href="item.file" target="_blank">
              <el-button type="primary">
                <el-icon class="el-icon--left">
                  <Download />
                </el-icon>
                Download
              </el-button>
            </a>
          </div>
        </div>
      </div>

      <pagination
        v-show="total > 0"
        :total="total"
        :page="query.page"
        :limit="query.limit"
        @pagination="handlePageChange"
      />
    </div>
  </section>
</template>

<script>
import Pagination from '@/components/Pagination'; 
import Resource from '@/api/resource';
import defaultBg from '@/assets/resource/resource.jpg';

const resources = new Resource('resource');

export default {
  name: 'ResourceList',
  components: { Pagination },
  data() {
    return {
      list: [],
      total: 0,
      defaultBg,
      loading: true,
      query: {
        page: 1,
        limit: 15,
        keyword: '',
        name: '',
        from_date: '',
        to_date: '',
      },
    };
  },
  created() {
    this.getList();
  },
  methods: {
    truncateDescription(description) {
      if (description.length > 250) {
        return description.slice(0, 250) + '...';
      }
      return description;
    },

    async getList() {
      this.loading = true;
      try {
        const { data, meta } = await resources.list(this.query);
        this.list = data.map(item => ({
          ...item,
          description: this.truncateDescription(item.description),
        }));
        this.total = meta.total;
      } catch (e) {
        console.error('Failed to fetch resources:', e);
      }
      this.loading = false;
    },

    handleFilter() {
      this.query.page = 1;
      this.getList();
    },
    handlePageChange(params) {
      this.query.page = params.page;
      this.query.limit = params.limit;
      this.getList();
    },
  },
};
</script>


<style scoped>
section {
  overflow: hidden;
  padding: 60px 0;
}

.resource .container {
  padding: 30px 0;
  max-width: 90%;
  margin: auto;
}

.section-title {
  text-align: center;
  padding-bottom: 30px;
}

.section-title h2 {
  font-size: 2.5rem;
  font-weight: bold;
  margin-bottom: 20px;
  font-family: Georgia, 'Times New Roman', Times, serif;
}

.section-title p {
  margin-bottom: 0;
}

.filter-item {
  height: 40px;
  border-radius: 0 10px 10px 0;
  min-width: 100px;
}


.card-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  gap: 20px;
  padding: 20px 0;
  
}


.resource-card {
  display: flex;
  flex-direction: column;
  height: 100%;
  background: #fff;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.resource-card:hover {
  transform: scale(1.03);
}

.card-image {
  height: 150px;
  background-size: cover;
  background-position: center;
}

.card-content {
  
  padding-left: 16px;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.card-content h6.title {
  font-size: 1.3rem;
  font-weight: bold;
  margin-bottom: 10px;
  color: #333;
}
.search-bar {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 5px;
  margin-bottom: 20px;
  padding: 0 10px;
  width: 100%; 
}

.card-content p.description {
  font-size: 0.95rem;
  margin-bottom: 15px;
  color: #555;
}
.search-query{
  flex: 1 1 300px;
  min-width: 250px;
  height: 40px;
  border-radius: 10px 0 0 10px;

}
</style>





