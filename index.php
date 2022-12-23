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
    <div class="container-fluid mt-5" style="padding-bottom:20px;">
      <div class="row justify-content-center no-gutters">
        <!-- LOGO -->
        <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">   
            <section class="maison">
              <img src="../Acoteq/image/logo1.png" alt="logo" title="logo" style="width:40vh;"> 
            </section>
        </div>

        <!-- Aside  -->
        <div class="col-12 col-sm-12 col-md-7 col-lg-7 col-xl-7"> 
          <aside class="aside">
            <div class="slogan_1 col-8">
              <h5> Trouvez la meilleur option d'isolation thermique </h5>   
            </div>

            <div id="carouselExampleInterval" class="carousel slide w-75" data-ride="carousel">
              <div class="carousel-inner w-100">
                <div class="carousel-item active" data-interval="2000">
                  <img src="../Acoteq/image/slide1.png" class="col-12 d-block w-100" alt="...">
                </div>
                <div class="carousel-item" data-interval="2000">
                  <img src="../Acoteq/image/slide2.png" class="col-12 d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                  <img src="../Acoteq/image/slide3.png" class="col-12 d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                  <img src="../Acoteq/image/slide4.png" class="col-12 d-block w-100" alt="...">
                </div>
              </div>
              <a class="carousel-control-prev" href="#carouselExampleInterval" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true" ></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleInterval" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
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
