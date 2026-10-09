<template>
    <!-- ======= Contact Section ======= -->
    <section class="contact">
      <div class="container">

        <div class="section-title">
          <h2>Contact</h2>
          <p>We are available for anyone who is interested to join the digital world and also those who joined and need expansion.
          Phone and Email are provided below, do contact us and we will reach out to you and join you in digital race.</p>
        </div>

        <el-row class="contact-info">

          <el-col :span="8">
            <div class="contact-address">
              <i class="bi bi-geo-alt"></i>
              <h3>Address</h3>
              <address>1234 Sudan Streat, Addis Ababa, Ethiopia</address>
            </div>
          </el-col>

          <el-col :span="8">
            <div class="contact-phone">
              <i class="bi bi-phone"></i>
              <h3>Phone Number</h3>
              <p><a href="tel:+251 115 18 6255">+251 115 18 6255</a></p>
            </div>
          </el-col>

          <el-col :span="8">
            <div class="contact-email">
              <i class="bi bi-envelope"></i>
              <h3>Email</h3>
              <p><a href="mailto:dhpisupport@moh.gov.et">dhpisupport@moh.gov.et</a></p>
            </div>
          </el-col>

        </el-row>
      </div>
    </section><!-- End Contact Section -->
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
# Contact
--------------------------------------------------------------*/
.contact .container{
  padding: 30px 0;
  max-width: 60%;
  margin: auto;
}

.contact .contact-info {
  margin-bottom: 20px;
  text-align: center;
}

.contact .contact-info i {
  font-size: 48px;
  display: inline-block;
  margin-bottom: 10px;
  color: #5f3703;
}

.contact .contact-info address, .contact .contact-info p {
  margin-bottom: 0;
  color: #000;
}

.contact .contact-info h3 {
  font-size: 18px;
  margin-bottom: 15px;
  font-weight: bold;
  text-transform: uppercase;
  color: #999;
}

.contact .contact-info a {
  color: #000;
}

.contact .contact-info a:hover {
  color: #5f3703;
}

.contact .contact-address, .contact .contact-phone, .contact .contact-email {
  margin-bottom: 20px;
}

.contact .php-email-form .error-message {
  display: none;
  color: #fff;
  background: #ed3c0d;
  text-align: left;
  padding: 15px;
  font-weight: 600;
}

.contact .php-email-form .error-message br + br {
  margin-top: 25px;
}

.contact .php-email-form .sent-message {
  display: none;
  color: #fff;
  background: #18d26e;
  text-align: center;
  padding: 15px;
  font-weight: 600;
}

.contact .php-email-form .loading {
  display: none;
  background: #fff;
  text-align: center;
  padding: 15px;
}

.contact .php-email-form .loading:before {
  content: "";
  display: inline-block;
  border-radius: 50%;
  width: 24px;
  height: 24px;
  margin: 0 10px -6px 0;
  border: 3px solid #18d26e;
  border-top-color: #eee;
  -webkit-animation: animate-loading 1s linear infinite;
  animation: animate-loading 1s linear infinite;
}

.contact .php-email-form input, .contact .php-email-form textarea {
  border-radius: 0;
  box-shadow: none;
  font-size: 14px;
  height: auto;
  padding: 10px 15px;
  border-radius: 4px;
}

.contact .php-email-form input:focus, .contact .php-email-form textarea:focus {
  border-color: #5f3703;
}

.contact .php-email-form button[type="submit"] {
  background: #5f3703;
  border: 0;
  padding: 10px 30px 12px 30px;
  color: #fff;
  transition: 0.4s;
  border-radius: 4px;
}

.contact .php-email-form button[type="submit"]:hover {
  background: #e39124;
}

@-webkit-keyframes animate-loading {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

@keyframes animate-loading {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

@media (min-width: 768px) {
  .contact .contact-phone {
    border-left: 1px solid #ddd;
    border-right: 1px solid #ddd;
  }
  .contact .contact-address, .contact .contact-phone, .contact .contact-email {
    padding: 20px 0;
  }
}
</style>