<?php
  if (file_exists("header.php"))
  {
    include("header.php");
  }
  else
  {
    echo "file 'header.php' n'existe pas";
  }
?>

<!-- PAGE CONTENT -->
<div class="container-fluid mt-5" style="padding-bottom:30px;" >
  <div class="row justify-content-center no-gutters">
    <!-- LOGO -->
    <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">   
        <section class="maison">
          <img src="../Acoteq/image/logo1.png" alt="logo" title="logo" style="width:40vh;"> 
        </section>
    </div>

    <!-- Aside  -->
    <div class="col-12 col-sm-12 col-md-7 col-lg-7 col-xl-7" style="margin-top:90px"> 
        <h3>Notre société</h3>
      <aside class="aside" style="border:2px solid grey; border-radius:10px; width:70%; padding:30px; margin-top:20px; margin-bottom:50px;">
        <div style="font-size: 1.4rem;">
            Acoteq est une société d'études pluridisciplinaire en performance de construction et qui a comme objectif 
            pour ses clients d'inscrire la qualité et l'optimisation dans une démarche pérenne de développement durable. 
            Elle est spécialisée dans le secteur d'activités d'architecture et d'ingénierie, études techniques, activités 
            de contrôle et analyses techniques.
            La société accompagne la stratégie nationale en matière d’objectifs de développement durable et de la performance 
            énergétique des bâtiments. L’entreprise intervient sur tous les services et métiers liés aux bâtiments.
        </div>
      </aside>
    </div>
    <div style="clear: left;"> </div>  
  </div>
</div> 
<!-- PAGE CONTENT END -->   


<?php
  if (file_exists("footer.php"))
  {
    include("footer.php");
  }
  else
  {
    echo "file 'footer.php' n'existe pas";
  }
?>
