</div>
<!-- /.container -->

<div class="container" style="width:80%;">

    <hr>

    <!-- Footer -->
    <footer>
        <div class="row">
            <div class="col-lg-12">
              <div class="containerFooter">
              </div>
                <p class="copyright">Copyright &copy; Franck Chen - DEALWIZIT - 2018</p>
            </div>
        </div>
    </footer>

</div>
<!-- /.container -->
</body>
</html>

<script type="text/javascript">

function clear(){
  return "<div class='clear'></div>";
}

var menuFooter = document.querySelector(".containerFooter");

var menuAPropos =[
  {
    url:"legalNotice.html",
    libelle:"Mentions légales",
  },
  {
    url:"cgu.html",
    libelle:"C.G.U.",
  },
  {
    url:"sitemap.php",
    libelle:"Plan du site",
  },
];

var menuNousRecontrer =[
  {
    url:"index.php",
    libelle:"Nos annonces"
  },
  {
    url:"#",
    libelle:"Plan d'accés"
  },
  {
    url:"contact.php",
    libelle:"Contactez-nous"
  },
];

var menuFooterSocial = [
  {
    url:"https://www.facebook.com",
    icone:"fa fa-facebook fa-lg",
    target: true,
  },
  {
    url:"https://www.linkedin.com",
    icone:"fa fa-linkedin fa-lg",
    target: true,
  },
  {
    url:"https://www.twitter.com",
    icone:"fa fa-twitter fa-lg",
    target: true,
  },
  {
    url:"https://www.instagram.com",
    icone:"fa fa-instagram fa-lg",
    target: true,
  },

];

function htmlLogoFooter(){
  var htmlFooter =  "<div class='icone'>";
  htmlFooter += "<h4><a href='index.php'>DEALWIZIT</a></h4>";
  htmlFooter += "</div>";
  return htmlFooter;
}

function htmlAPropos(menuAPropos){
  var htmlFooter = "<div class='menuAPropos'>";
  htmlFooter += "<h3>A Propos</h3>";
  htmlFooter += "<ul>";
  for (var i in menuAPropos) {
    htmlFooter += "<li>";
    htmlFooter += "<a href='"+menuAPropos[i].url+"'>";
    htmlFooter += menuAPropos[i].libelle + "</a>" + "</li>";
  }
  htmlFooter += "</ul></div>";
  return htmlFooter;
}

function htmlNousRencontrer(menuNousRecontrer){
  var htmlFooter = "<div class='menuNousRecontrer'>";
  htmlFooter += "<h3>Nous Contacter</h3>";
  htmlFooter += "<ul>";
  for (var i in menuNousRecontrer) {
    htmlFooter += "<li>";
    htmlFooter += "<a href='"+menuNousRecontrer[i].url+"'>";
    htmlFooter += menuNousRecontrer[i].libelle + "</a>" + "</li>";
  }
  htmlFooter += "</ul>";
  htmlFooter += "</div>";
  return htmlFooter;
}

function htmlFooterSocial(menuFooterSocial){
  var htmlFooter = "<div class='menuFooterSocial'>";
  // htmlFooter += "<h3>Réseaux sociaux</h3>";
  // htmlFooter += "<ul>";
  // for (var i in menuFooterSocial) {
  // htmlFooter += "<li>";
  // if (menuFooterSocial[i].target == true) { //if de gestion des linkFooter
  //   htmlFooter += "<a href='"+menuFooterSocial[i].url+"' target='_blank'>";
  //   } else {
  //     htmlFooter += "<a href='"+menuFooterSocial[i].url+"'>";
  //   }
  //   htmlFooter += "<i class='"+menuFooterSocial[i].icone+"'>";
  //   htmlFooter += "</i></a></li>";
  // }
  // htmlFooter += "</ul>";
  htmlFooter += "<h3>Restez informé</h3>";
  htmlFooter += "<p>Inscrivez-vous à notre Newsletter</p>";
  htmlFooter += "<form class='ajax-form newsletter-form form-inline' format='json' accept-charset='UTF-8' data-remote='true' method='post'><input name='utf8' type='hidden'>";
  htmlFooter += "<div class='newsLetterContainer'>";
  htmlFooter += "<input type='email' name='email' id='email' value='' class='newsletter-form-input form-input' placeholder='Votre adresse email' required='required'><button name='button' type='submit' class='btn btn-submit btn-primary'>Go</button>";
  // htmlFooter += ;
  htmlFooter += "</div></div></form>";
  return htmlFooter;
}

// CONKAT FONCTIONS
var htmlFooter =  "<div class='footerContainer'>";
    htmlFooter += htmlLogoFooter();
    htmlFooter += htmlAPropos(menuAPropos)
    htmlFooter += htmlNousRencontrer(menuNousRecontrer);
    htmlFooter += htmlFooterSocial(menuFooterSocial);
    htmlFooter += clear();
    htmlFooter += "</div>";

menuFooter.innerHTML = htmlFooter;
//FIN DU FOOTER
</script>

<style>
.footerContainer{
  margin: 0 auto;
  position: relative;
}
.newsLetterContainer{
  display:inline-flex;
}
.icone, .menuAPropos, .menuNousRecontrer, .menuFooterSocial{
  display: inline-grid;
  padding-left: 8%;
}
.menuAPropos ul, .menuNousRecontrer ul{
  list-style-type: none;
  display: inline-grid;
  padding-left: 0;
}
.copyright{
  float: right;
  padding-top: 5%;
}

</style>
