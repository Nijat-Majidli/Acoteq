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
                <img src="../Acoteq/image/logo1.png" alt="logo" title="logo" class="logo"> 
            </div>

            <!-- Carousel  -->
            <div class="col-lg-7 text-center"> 
              <h4 class="text-primary my-4"> Trouvez la meilleur option d'isolation thermique </h4>   
              
              <div id="carouselExampleInterval" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
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
