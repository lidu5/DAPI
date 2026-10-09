<template>
<footer class="footer">
  <div class="footer__addr">
    <img src="@/assets/moh/moa_footer.png"/>
        
    <!--<h2>Minister of Agriculture - Ethiopia</h2>-->
    
    <address>
      Addis Ababa (Headquarters), Gurd Shola (Near to Century Mall) <br>
      <a class="footer__btn" href="mailto:info@moh.gov.et">Email Us</a>
    </address>
  </div>
  
  <ul class="footer__nav">
    <li class="nav__item">
      <h2 class="nav__title">Contact Info</h2>

      <ul class="nav__ul">
        <li>
          <a href="#">Tel: +251 11646 21 99</a>
        </li>

        <li>
          <a href="#">Email: info@moa.gov.et</a>
        </li>
            
        <li>
          <a href="#">Working Hours: 2.30am-5.30pm</a>
        </li>
      </ul>
    </li>
    
    <!--<li class="nav__item nav__item--extra">
      <h2 class="nav__title">Useful Links</h2>
      
      <ul class="nav__ul nav__ul--extra">
        <li>
          <a href="https://www.digitalhealthatlas.org/" target="_blank">WHO Digital Health Atlas</a>
        </li>
      </ul>
    </li>
    -->
    
    <li class="nav__item">
      <h2 class="nav__title">Legal</h2>
      
      <ul class="nav__ul">
        <li>
          <a href="#">Privacy Policy</a>
        </li>
        
        <li>
          <a href="#">Terms of Use</a>
        </li>
        
        <li>
          <a href="#">Sitemap</a>
        </li>
      </ul>
    </li>
  </ul>
</footer>
</template>

<style scoped>
.footer {
  display: flex;
  flex-flow: row wrap;
  padding: 30px 30px 20px 30px;
  color: #2f2f2f;
  background-color: #fff;
  border-top: 1px solid #e5e5e5;
}

.footer > * {
  flex:  1 100%;
}

.footer__addr {
  margin-right: 1.25em;
  margin-bottom: 2em;
}

.footer__addr h2 {
  margin-top: 1.3em;
  font-size: 15px;
  font-weight: 400;
}

.nav__title {
  font-weight: 400;
  font-size: 15px;
}

.footer address {
  font-style: normal;
  color: #999;
}

.footer__btn {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 36px;
  max-width: max-content;
  background-color: rgb(33, 33, 33, 0.07);
  border-radius: 100px;
  color: #2f2f2f;
  line-height: 0;
  margin: 0.6em 0;
  font-size: 1rem;
  padding: 0 1.3em;
}

.footer ul {
  list-style: none;
  padding-left: 0;
}

.footer li {
  line-height: 2em;
}

.footer a {
  text-decoration: none;
}

.footer__nav {
  display: flex;
	flex-flow: row wrap;
}

.footer__nav > * {
  flex: 1 50%;
  margin-right: 1.25em;
}

.nav__ul a {
  color: #999;
}

.nav__ul--extra {
  column-count: 2;
  column-gap: 1.25em;
}

@media screen and (min-width: 24.375em) {
  .legal .legal__links {
    margin-left: auto;
  }
}

@media screen and (min-width: 40.375em) {
  .footer__nav > * {
    flex: 1;
  }
  
  .nav__item--extra {
    flex-grow: 2;
  }
  
  .footer__addr {
    flex: 1 0px;
  }
  
  .footer__nav {
    flex: 2 0px;
  }
}
</style>