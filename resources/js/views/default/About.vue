<template>
    <!-- ======= About Section ======= -->
    <section class="about">
      <div class="container">
        <div class="row no-gutters">
          <div class="col-xl-12 ps-0 ps-lg-5 pe-lg-1 d-flex align-items-stretch">
            <div class="content d-flex flex-column justify-content-center">
              <div class="section-title">
                <h2>About the Digital Agriculture Projects Inventory System</h2>                
              </div>
              <div>
                <p>
                  The Ministry of Agriculture of Ethiopia (MoA) recognized digital agriculture systems as vital tools to transform the agriculture sector and deliver better agricultural services to citizens. The agriculture sector has given close and serious attention and exerted maximum efforts to develop and implement different digital agriculture systems with various purposes that differ in the scale of implementation, focus areas and agricultural interventions.</p>
                <p>
                  As the implementation of digital agriculture systems continues to grow both in number and capabilities, recognizing their use and impact, associated costs, and capitalizing on lessons learned is of high importance. In addition, as it is becoming very challenging to coordinate the various efforts in digital agriculture activities, it is becoming very essential to have an automated platform for registering, validating and certifying digital agriculture solutions that can guide informed decision making by providing reports and visualizations of existing landscapes.
                </p>
                <p>
                  To address these challenges, the MoA has developed a digital agriculture projects inventory system and started the registration, validation, approval and certification processes of digital agriculture systems..
                </p>
              </div>
            </div><!-- End .content-->
          </div>
        </div>
      </div>
    </section><!-- End About Section -->
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

.section-header .section-description {
  text-align: center;
  padding-bottom: 40px;
  color: #999;
}

.section-bg {
  background-color: #f1f1f1;
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
# About
--------------------------------------------------------------*/
.about .content {
  padding: 30px 0;
  max-width: 60%;
  margin: auto;
}

.about .content h3 {
  font-weight: 700;
  font-size: 34px;
}

.about .content p {
  margin-bottom: 0;
}

.about .content .icon-box {
  margin-top: 25px;
}

.about .content .icon-box h4 {
  font-size: 20px;
  font-weight: 700;
  margin: 5px 0 10px 60px;
}

.about .content .icon-box i {
  font-size: 48px;
  float: left;
  color: #5f3703;
}

.about .content .icon-box p {
  font-size: 15px;
  color: #848484;
  margin-left: 60px;
}

.about .image {
  background: url("../img/about-img.jpg") center center no-repeat;
  background-size: cover;
  min-height: 400px;
}

@media (max-width: 991px) {
  .about .image {
    text-align: center;
  }
  .about .image img {
    max-width: 80%;
  }
}

@media (max-width: 667px) {
  .about .image img {
    max-width: 100%;
  }
}
</style>