<template>
  <section class="projects">
    <div class="container">
      <el-aside :width="sidebarWidth" style="background-color: #f8f8f8;" class="filter-menu desktop-aside">

        <h4> 
          <el-icon>
            <Filter />
          </el-icon>
          Filter By:
        </h4>        
        <el-select v-model="query.component" clearable filterable @change="handleFilter" multiple placeholder="e-Health Component" class="filter-select" size="large"
          style="width: 220px">
          <el-option v-for="component in search_data.components" :key="component.id" :label="component.name" :value="component.id" class="filter-option" />
        </el-select>
        <el-select v-model="query.application_type" clearable filterable @change="handleFilter" multiple placeholder="Application Type" class="filter-select" size="large"
          style="width: 220px">
          <el-option v-for="application_type in search_data.application_types" :key="application_type.id" :label="application_type.name" :value="application_type.id"
            class="filter-option" />
        </el-select>
        <el-select v-model="query.focus_area" clearable filterable @change="handleFilter" multiple placeholder="Health Focus Area" class="filter-select" size="large"
          style="width: 220px">
          <el-option v-for="focus_area in search_data.focus_areas" :key="focus_area.id" :label="focus_area.name" :value="focus_area.id" class="filter-option" />
        </el-select>
        <el-select v-model="query.region" clearable filterable @change="handleFilter" multiple placeholder="Coverage" class="filter-select" size="large"
          style="width: 220px">
          <el-option v-for="region in search_data.regions" :key="region.id" :label="region.name" :value="region.id" class="filter-option" />
        </el-select>
        <el-select v-model="query.challenge" clearable filterable @change="handleFilter" multiple placeholder="Health System Challenge" class="filter-select" size="large"
          style="width: 220px">
          <el-option v-for="challenge in search_data.challenges" :key="challenge.id" :label="challenge.name" :value="challenge.id" class="filter-option" />
        </el-select>
        <h4> 
          <el-icon>
            <Sort />
          </el-icon>
          Order By:
        </h4>

        <el-select v-model="query.sort_by" @change="handleFilter" placeholder="Order By" class="order-select" size="large" style="width: 220px">
          <el-option label="Last Updated" value="" />
          <el-option label="Date Added (Newest First)" value="date_newest" />
          <el-option label="Date Added (Oldest First)" value="date_oldest" />
          <el-option label="By Name (A-Z)" value="name_asc" />
          <el-option label="By Name (Z-A)" value="name_desc" />
          <el-option label="Start Date (Newest First)" value="start_date_newest" />
          <el-option label="Start Date (Oldest First)" value="start_date_oldest" />
        </el-select>
      </el-aside>

      <div class="content-area">
        <div class="section-title">
          <h2>Digital Agriculture Solutions</h2>
          <p class="section-subtitle">
            Explore innovative digital health solutions transforming healthcare.
            <span class="total-count">({{ total }})</span>
              <el-button class="mobile-icon-button" type="primary" plain @click="$router.push('/dashboard')">
                Analytics 
                <el-icon><DataAnalysis /></el-icon>
              </el-button>
            <span class="mobile-filter-controls">
              <el-button @click="showFilterMenu = !showFilterMenu" class="mobile-icon-button" type="info" plain>
                <el-icon>
                  <Filter />
                </el-icon>
                Filter
              </el-button>
               <el-popover placement="bottom-end" :width="200" trigger="click" :teleported="true">
                <template #reference>
                  <el-button class="mobile-icon-button" type="info" plain>
                    <el-icon>
                      <Sort />
                    </el-icon>
                    Order
                  </el-button>
                </template>
                <div class="popover-sort-content">
                  <el-select v-model="query.sort_by" @change="handleFilter" size="large" placeholder='Last Updated' style="width: 100%;">
                    <el-option label="Last Updated" value="last_update"  selected="selected" />
                    <el-option label="Date Added (Newest First)" value="date_newest" />
                    <el-option label="Date Added (Oldest First)" value="date_oldest" />
                    <el-option label="By Name (A-Z)" value="name_asc" />
                    <el-option label="By Name (Z-A)" value="name_desc" />
                    <el-option label="Start Date (Newest First)" value="start_date_newest" />
                    <el-option label="Start Date (Oldest First)" value="start_date_oldest" />
                  </el-select>
                </div>
              </el-popover>
            </span>
          </p>

          <transition name="el-zoom-in-top">
            <div v-show="showFilterMenu" class="mobile-filter-menu">
              <div class="mobile-menu-header">
                <h3>Filter Options</h3>
                <el-button @click="showFilterMenu = false" circle>
                  <el-icon>
                    <Close />
                  </el-icon>
                </el-button>
              </div>
              <el-select v-model="query.component" clearable filterable @change="handleFilter" multiple placeholder="e-Health Component" class="filter-select"
                size="large">
                <el-option v-for="component in search_data.components" :key="component.id" :label="component.name" :value="component.id" class="filter-option" />
              </el-select>
              <el-select v-model="query.application_type" clearable filterable @change="handleFilter" multiple placeholder="Application Type" class="filter-select"
                size="large">
                <el-option v-for="application_type in search_data.application_types" :key="application_type.id" :label="application_type.name" :value="application_type.id"
                  class="filter-option" />
              </el-select>
              <el-select v-model="query.focus_area" clearable filterable @change="handleFilter" multiple placeholder="Health Focus Area" class="filter-select"
                size="large">
                <el-option v-for="focus_area in search_data.focus_areas" :key="focus_area.id" :label="focus_area.name" :value="focus_area.id" class="filter-option" />
              </el-select>
              <el-select v-model="query.region" clearable filterable @change="handleFilter" multiple placeholder="Coverage" class="filter-select" size="large">
                <el-option v-for="region in search_data.regions" :key="region.id" :label="region.name" :value="region.id" class="filter-option" />
              </el-select>
              <el-select v-model="query.challenge" clearable filterable @change="handleFilter" multiple placeholder="Health System Challenge" class="filter-select"
                size="large">
                <el-option v-for="challenge in search_data.challenges" :key="challenge.id" :label="challenge.name" :value="challenge.id" class="filter-option" />
              </el-select>
               <el-button @click="handleClose('filter')" type="info" size="large" style="width:100%;">
                  <el-icon>
                    <Close /> Close
                  </el-icon>
                </el-button>
            </div>
          </transition>
        </div>

        <div class="filter-container">

          <el-input v-model="query.keyword" clearable :placeholder="'Search Projects by name or keywords'" class="search-item" @keyup.enter="handleFilter" suffix-icon="el-icon-search"
            style="width: 100%; border-radius: 25px; padding-right: 35px;" size="large" />
          <el-button type="primary" @click="handleFilter" class="search" size="large">
            <el-icon class="el-icon--left">
              <Search />
            </el-icon>{{ $t('table.search') }}
          </el-button>
        </div>

        <div class="card-container">
          <div v-for="item in list" :key="item.uuid" class="card">
            <router-link :to="'/project/' + item.uuid" class="card-link">
              <div class="card-image-wrapper">
                <!-- <img
                  :src="getRandomHealthTechImage()"
                  alt="Health Tech Image"
                  class="card-image"
                  :class="{ 'with-logo': item.logo }"
                />
                <img
                  v-if="item.logo"
                  :src="item.logo"
                  alt="Project Logo"
                  class="project-logo"
                /> -->
                  <img
    :src="item.logo ? item.logo : getRandomHealthTechImage()"
    alt="Project Image"
    class="card-image"
  />
                <div class="card-image-tags">
                  <el-tag v-if="item.focus_areas && item.focus_areas.length > 0" class="focus-area-tag" :title="item.focus_areas.map(f => f.name).join(', ')">
                    {{ getDisplayFocusArea(item.focus_areas) }}
                  </el-tag>
                  <el-tag v-if="item.focus_areas && item.focus_areas.length > 1" class="focus-area-count-tag" :title="item.focus_areas.map(f => f.name).join(', ')">
                    +{{ item.focus_areas.length - 1 }} more
                  </el-tag>
                </div>
                <el-tooltip v-if="item.certificates.length > 0 && item.status === 'cert competence'" content="This DHS has been certified by the MoH." placement="top"
                  effect="light">
                  <div class="card-badge">
                    <img src="@/assets/home/quality.png" alt="Certified" class="qa-badge" />
                  </div>
                </el-tooltip>
              </div>
              <div class="card-header">
                <h3>{{ item.name }}</h3>
              </div>
              <div class="card-body">
                <p>
                  <el-icon>
                    <OfficeBuilding />
                  </el-icon> {{ item.organization.name }}
                </p>
                <p>
                  <el-icon>
                    <CollectionTag />
                  </el-icon> {{ item.components.map(component => component.name).join(', ') }}
                </p>
                <p>
                  <el-icon>
                    <Tickets />
                  </el-icon> {{ item.application_types.map(application_type => application_type.name).join(', ') }}
                </p>
              </div>
            </router-link>
          </div>
        </div>

        <pagination v-show="total > 0" :total="total" :page="query.page" :limit="query.limit" @pagination="handlePageChange" />
      </div>
    </div>
  </section>
</template>
 <script>
import Pagination from '@/components/Pagination';
import Resource from '@/api/resource';
import { ElIcon } from 'element-plus';
import { Filter, Search, Close, Grid, Tickets, OfficeBuilding, CollectionTag, CloseBold, Sort, DataAnalysis } from '@element-plus/icons-vue';
import image1 from '@/assets/project-images/image1.jpg';
import image4 from '@/assets/project-images/image4.jpg';

const search = new Resource('search');
const projectSearchData = new Resource('projects/search-data');

export default {
  name: 'Resource List',
  components: { Pagination, ElIcon, Filter, Search, Close, Sort, CloseBold, Tickets, OfficeBuilding, CollectionTag },
  data() {
    return {
      list: null,
      total: 0,
      loading: true,
      downloading: false,
      query: {
        page: 1,
        limit: 15,
        keyword: '',
        organization: [],
        focus_area: [],
        region: [],
        component: [],
        challenge: [],
        application_type: [],
        sort_by: ''
      },
      search_data: {},
      sidebarCollapsed: false,
      showFilterMenu: false,
      showOrderMenu: false,
      healthTechImages: [
        image1,
        image4
      ]
    };
  },
  created() {
    this.getList();
    this.getSearchData();
  },
  computed: {
    sidebarWidth() {
      return this.sidebarCollapsed ? '50px' : '20%'; 
    }
  },
  methods: {
    async getList() {
      this.loading = true;
      const { data, meta } = await search.list(this.query);
      this.list = data;
      this.total = meta.total;
      this.loading = false;
    },
    handlePageChange(params) {
      this.query.page = params.page;
      this.query.limit = params.limit;
      this.getList();
    },
    async getSearchData() {
      const data = await projectSearchData.list({});
      this.search_data.organizations = data.organizations;
      this.search_data.focus_areas = data.focus_areas;
      this.search_data.regions = data.regions;
      this.search_data.components = data.components;
      this.search_data.challenges = data.challenges;
      this.search_data.application_types = data.application_types;
    },
    handleFilter() {
      if (!this.query.sort_by) {
        delete this.query.sort_by;
      }
      this.query.page = 1;
      this.getList();
    },
    handleClose(menuType) {
      if (menuType === 'filter') {
        this.showFilterMenu = false;
      } else if (menuType === 'order') {
        this.showOrderMenu = false;
      }
    },
    toggleSidebar() {
      this.sidebarCollapsed = !this.sidebarCollapsed;
    },
    getRandomHealthTechImage() {
      const randomIndex = Math.floor(Math.random() * this.healthTechImages.length);
      return this.healthTechImages[randomIndex];
    },
    getDisplayFocusArea(focusAreas) {
      if (focusAreas && focusAreas.length > 0) {
        const firstFocusArea = focusAreas[0].name;
        return firstFocusArea.length > 22 ? `${firstFocusArea.substring(0, 22)}...` : firstFocusArea;
      }
      return '';
    }
  }
};
</script> 
 <style scoped>
section {
  padding: 0;
}

.projects .container {
  display: flex;
  padding: 50px 0;
}

.el-aside {
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  position: sticky;
  top: 50px;
  align-self: flex-start;
  min-height: 100vh;
  padding-bottom: 40px;
  overflow-y: auto;
}


.content-area {
  flex-grow: 1;
  padding: 20px;
  position: relative;
}

.content-area::-webkit-scrollbar {
  width: 3px;
  height: 6px;
}

.content-area::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

.content-area::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 10px;
}

.content-area::-webkit-scrollbar-thumb:hover {
  background: #555;
}

.card-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 20px;
  padding: 10px;
}

.card {
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  transition: box-shadow 0.3s, transform 0.3s;
  display: flex;
  flex-direction: column;
  padding-bottom: 8px;
}

.card:hover {
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.35);
  transform: translateY(-5px);
}

.card-link {
  text-decoration: none;
  color: inherit;
  display: flex;
  flex-direction: column;
  height: 100%;
}

.card-header {
  font-size: 18px;
  font-weight: bold;
  display: flex;
  justify-content: space-between;
  padding: 0 15px;
  align-items: baseline;
}

.card-image {
  width: 100%;
  height: 150px;
  object-fit: cover;
  border-radius: 8px 8px 0 0;
  margin-bottom: 15px;
  transition: opacity 0.3s ease;
}

.card-body {
  margin-top: auto;
  padding: 0 15px;
}

.card-body p {
  margin: 3px 0;
  display: flex;
  align-items: center;
  gap: 5px;
}

.filter-container {
  display: flex;
  justify-content: center;
  padding: 20px;
  width: 100%;
  gap: 10px;
}

.card-image-wrapper {
  position: relative;
}

.card-image-tags {
  position: absolute;
  top: 10px;
  left: 10px;
  display: flex;
  flex-direction: column;
  gap: 5px;
}

.focus-area-tag {
  background-color: #89cff0;
  color: #00334d;
  padding: 5px 10px;
  border-radius: 10px;
  font-size: 12px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 200px;
}

.focus-area-count-tag {
  background-color: #00334d;
  color: #fff;
  padding: 5px 8px;
  border-radius: 10px;
  font-size: 12px;
}

.card-badge {
  position: absolute;
  top: 5px;
  right: 5px;
  z-index: 1;
}

.qa-badge {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background-color: white;
  padding: 2px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.filter-menu h1 {
  margin-bottom: 20px;
  font-size: 1.8rem;
  color: #333;
}

.filter-select {
  width: 100%;
  margin-bottom: 10px;
}
.order-select {
  width: 100%;
  margin-top: 10px;
}

.filter-option {
  padding: 8px 12px;
  font-size: 14px;
}

.search {
  background-color: #1172b5;
  border: 1px #1172b5 solid;
  padding-left: 15px;
  padding-right: 15px;
  border-radius: 4px;
  padding-top: 4px;
  padding-bottom: 4px;
  width: 150px;
}

.section-title h2 {
  font-size: 2.5rem;
  font-weight: bold;
  margin-bottom: 20px;
  padding-bottom: 0;
  font-family: Georgia, 'Times New Roman', Times, serif;
  text-align: center;
}

.section-subtitle {
  text-align: center;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
  gap: 10px;
}

.total-count {
  white-space: nowrap;
}

.mobile-filter-controls,
.mobile-filter-menu,
.mobile-order-menu {
  display: none;
}

@media (min-width: 1024px) {
  .desktop-aside {
    display: flex;
  }

  .mobile-filter-controls,
  .mobile-filter-menu,
  .mobile-order-menu {
    display: none !important;
  }

  .projects .container {
    flex-direction: row;
  }

  .el-aside {
    width: 280px;
    flex-shrink: 0; 
  }
}

@media (max-width: 1023px) {
  .projects .container {
    flex-direction: column;
    padding: 20px 0;
  }

  .el-aside.desktop-aside {
    display: none;
  }

  .content-area {
    width: 100%;
    padding: 10px;
  }

  .mobile-filter-controls {
    display: flex;
    gap: 10px;
    margin-left: 10px;
  }

  .mobile-icon-button {
    font-size: 1rem;
    padding: 8px 12px;
  }

  .mobile-filter-menu,
  .mobile-order-menu {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    padding-top:200px;
    background-color: rgba(255, 255, 255, 0.98);
    z-index: 1000;
    display: flex;
    flex-direction: column;
    padding: 20px;
    box-sizing: border-box;
    overflow-y: auto;
  }

  .mobile-menu-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-top:50px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
  }

  .mobile-menu-header h3 {
    margin: 0;
    font-size: 1rem;
  }

  .mobile-filter-menu .filter-select,
  .mobile-order-menu .filter-select {
    width: 100%;
    margin-bottom: 15px;
  }

  .filter-container {
    flex-direction: column;
  }

  .search-item {
    margin-bottom: 10px;
  }

  .search {
    width: 100%;
  }

  .card-container {
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
  }
}

@media (max-width: 480px) {
  .section-title h2 {
    font-size: 1.8rem;
  }

  .section-subtitle {
    flex-direction: column;
    gap: 5px;
  }

  .mobile-filter-controls {
    margin-left: 0;
  }

  .card-container {
    grid-template-columns: 1fr;
  }
}
</style>