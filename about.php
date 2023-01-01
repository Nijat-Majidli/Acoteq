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
    <div class="container-fluid my-5 py-5">
      <div class="row justify-content-center">
        <div class="col-xl-10">
          <div class="row justify-content-center align-items-center">
            <!-- Logo -->
            <div class="col-lg-5 text-center">   
              <img src="image/logo1.png" alt="logo" title="logo" class="logo"> 
            </div>

            <!-- Notre société  -->
            <div class="col-lg-7 text-center"> 
              <h4 class="text-primary my-4">Notre société</h4>   
              <aside class="text-justify border border-warning rounded p-4" style="font-size: x-large;">
                Acoteq est une société d'études pluridisciplinaire en performance de construction et qui a comme objectif 
                pour ses clients d'inscrire la qualité et l'optimisation dans une démarche pérenne de développement durable. 
                Elle est spécialisée dans le secteur d'activités d'architecture et d'ingénierie, études techniques, activités 
                de contrôle et analyses techniques.
                La société accompagne la stratégie nationale en matière d’objectifs de développement durable et de la performance 
                énergétique des bâtiments. L’entreprise intervient sur tous les services et métiers liés aux bâtiments.
              </aside>
            </div>
          </div>
        </div>
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
