<template>
    <!-- ======= Services Section ======= -->
    <section class="services">
        <div class="container">
            <div class="section-title">
                <h2>eHealth Architecture Components</h2>
            </div>

            <el-row>
                <el-col :span="12" class="icon-box">
                    <div class="icon"><Share /></div>
                    <h4 class="title"><a href="#" target="_blank">Shared Service</a></h4>
                    <p class="description">HIS typically have data and functions that are used across business processes and applications. 
                        This often results in redundant lists with disparity. Curation efforts can be reduced and opportunities for data sharing and exchange, 
                        as well as timeliness and data quality, can be increased by using shared services. 
                        A shared service is designed and developed to provides data or information that are used by other HIS. 
                        Shared services are designed to support interoperability and standards by providing 
                        authoritative sources for data that is used throughout the eHealth system.</p>
                </el-col>
                <el-col :span="12" class="icon-box">
                    <div class="icon"><HomeFilled /></div>
                    <h4 class="title"><a href="#" target="_blank">Institution Based HIS and Data Sources</a></h4>
                    <p class="description">These are data sources and systems that are designed to support key FMOH data and processes. 
                        These Institution-based HIS and Data Sources are administered centrally and support institutional capabilities of the FMOH. 
                        The eHealth architecture supports a way to exchange data with these resources as business processes require. 
                        This data will also be available to the Analytics and Business intelligence components.</p>
                </el-col>
            </el-row>
            <el-row>
                <el-col :span="12" class="icon-box">
                    <div class="icon"><User /></div>
                    <h4 class="title"><a href="#" target="_blank">Population Based HIS and Data Sources</a></h4>
                    <p class="description">Population-based HIS and Data Sources collect data directly from the population often through surveys. 
                        These include systems that provide services like improving indicator denominators using counts of births and deaths. 
                        The eHealth architecture supports a way to exchange data with these resources as business processes require. 
                        This data will also be available to the Analytics and Business intelligence components.</p>
                </el-col>            
                <el-col :span="12" class="icon-box">
                    <div class="icon"><DataAnalysis /></div>
                    <h4 class="title">Analytics and Business Intelligence</h4>
                    <p class="description">Traditionally, M&E has been considered to supply the needs of analytics and business intelligence (ABI). 
                        As a HIS system matures, additional ABI needs are identified. The eHealth Architecture is designed to support Analytics and Business intelligence components. 
                        These components are a technology-driven approach to enhance strategic and operational decision-making by consolidating and analyzing data across organizational units. 
                        Data systems support the acquisition of data, and a data warehouse or data storage platform provides a place for data to reside within a structured model. 
                        Analytics and visualization software are dependent upon the data sources included in the ABI pillar.</p>
                </el-col>
            </el-row>
            <el-row>
                <el-col :span="12" class="icon-box">
                    <div class="icon"><Pointer /></div>
                    <h4 class="title">Point of Service HIS</h4>
                    <p class="description">Point-of-Service HIS are used by health workers throughout the different levels of the Ethiopian Health system to facilitate service delivery. 
                        Examples of these types of systems include systems for reporting infectious disease that trigger case investigations and systems using mobile devices to register a household. 
                        These systems will be connected to Institutional and shared systems through the Interoperability Layer. 
                        As the development and use of these systems increases, the need for sharing data with other HIS systems and services will increase. 
                        The eHealth architecture is designed to facilitate interactions between these systems and the other HIS systems and services through the interoperability layer.</p>
                </el-col>
                <el-col :span="12" class="icon-box">
                    <div class="icon"><Search /></div>
                    <h4 class="title">
                        <router-link to="/projects/explore">
                            Explore Projects
                        </router-link>
                    </h4>
                    <p class="description">Search and explore all published projects</p>
                </el-col>
            </el-row>

        </div>
    </section><!-- End Services Section -->
</template>

<style scoped>
/*--------------------------------------------------------------
# Sections
--------------------------------------------------------------*/
section {
    overflow: hidden;
    padding: 60px 0;
}

/* Sections Header
--------------------------------*/
.section-header .section-title {
    font-size: 32px;
    color: #111;
    text-transform: uppercase;
    text-align: center;
    font-weight: 700;
    margin-bottom: 5px;
}

.section-title {
    text-align: center;
    padding-bottom: 30px;
}

.section-title h2 {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 20px;
    padding-bottom: 0;
    font-family: Georgia, 'Times New Roman', Times, serif;
}

.section-title p {
    margin-bottom: 0;
}

/*--------------------------------------------------------------
# Services
--------------------------------------------------------------*/

.services .container {
  padding: 30px 0;
  max-width: 80%;
  margin: auto;
}

.services .icon-box {
    margin-bottom: 20px;
    text-align: center;
}

.services .icon {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 80px;
    height: 80px;
    margin-bottom: 20px;
    background: #fff;
    border-radius: 50%;
    transition: 0.5s;
    color: #5f3703;
    overflow: hidden;
    box-shadow: 0px 0 25px rgba(0, 0, 0, 0.15);
}

.services .icon i {
    font-size: 36px;
    line-height: 0;
}

.services:hover .icon {
    box-shadow: 0px 0 25px rgba(92, 159, 36, 0.3);
}

.services .title {
    font-weight: 600;
    margin-bottom: 15px;
    font-size: 18px;
    position: relative;
    padding-bottom: 15px;
}

.services .title a {
    color: #444444;
    transition: 0.3s;
}

.services .title a:hover {
    color: #5f3703;
}

.services .title::after {
    content: '';
    position: absolute;
    display: block;
    width: 70px;
    height: 2px;
    background: #5f3703;
    bottom: 0;
    left: calc(50% - 25px);
}

.services .description {
    line-height: 24px;
    font-size: 14px;
    text-align: justify;
    padding: 20px;
}
</style>