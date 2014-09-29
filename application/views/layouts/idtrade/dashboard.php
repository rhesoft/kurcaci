<!DOCTYPE html>
<?php
$category_temp = $this->nbscache->get_explode("category", "head");
$category = unserialize($category_temp[1]);

//print "<pre>";
//print_r($category); die;
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut" type="x-image/icon" href="favicon.ico">

    <title>IDTRADE</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php print $url?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php print $url?>css/main.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="body-background">
      <div class="container">
        <!-- header -->
        <header>
          <div class="row">
            <div class="col-xs-12">
              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                <div class="logo">
                  <h2>BIZTRADE</h2>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <div class="search">
                  <form class="form-inline">
                    <div class="form-group">  
                      <input class="form-control input-md input-search" placeholder="Cari disini..." />
                    </div>
                    <div class="form-group">
                      <select class="form-control input-md">
                        <option>- Kategori -</option>
                        <?php
                        foreach($category AS $key => $cate){
                          print "<option value='{$key}'>{$cate['name']}</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <select class="form-control input-md">
                        <option>- Provinsi -</option>
                        <?php
                        foreach($provinsi AS $prop){
                          print "<option value='{$prop->id_portal_lokasi}'>{$prop->title}</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-md">Cari</button>
                  </form>
                </div>
              </div>
<!--              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                <a href="#" class="btn btn-default btn-sm">Login</a>
                <a href="#" class="btn btn-default btn-sm">Register</a>
              </div>-->
            </div>
          </div>
        </header>
        <!-- end of header -->

        <!-- kategori selector -->
        <div class="visible-xs visible-sm" style="margin-bottom:1em;">
          <select class="form-control" id="kategori-select">
            <?php
            foreach($category AS $cate){
              print "<option value='kategori/{$cate['nicename']}'>{$cate['name']}</option>";
            }
            ?>
          </select>
        </div>
        <!-- end of kategori selector -->

        <div class="row row-offcanvas row-offcanvas-left">
          <!-- left sidebar -->
          <div class="hidden-sm hidden-xs col-md-3 col-lg-2">
            <div class="sidebar">
              <ul class="kategori-nav">
                <?php
                foreach($category AS $key => $cate){
                  $sub_category_temp = $this->nbscache->get_explode("sub-category", $key);
                  $sub_category = unserialize($sub_category_temp[1]);
                  print "<li>"
                  . "<a href='javascript:void(0);' class='btn btn-primary btn-block'>{$cate['name']}</a>"
                  . "<ul class='subkategori-nav'>";
                  foreach($sub_category AS $key_sub => $subcate){
                    print "<li><a href='".site_url("kategori/sub/".$subcate['nicename'])."' class='btn btn-primary btn-block'>{$subcate['name']}</a></li>";
                  }
                  print "</ul>"
                  . "</li>";
                }
                ?>
              </ul>
            </div>
          </div>
          <!-- end of left sidebar -->

          <!-- navigation -->
            <div class="col-xs-12 col-md-9 col-lg-10">
              <nav class="navbar navbar-default">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                </div>                
                <div class="collapse navbar-collapse" id="main-navbar-collapse">
                  <ul class="nav navbar-nav">
                    <li class="active"><a href="<?php print site_url()?>"><span class="glyphicon glyphicon-home"></span> &nbsp;Home</a></li>
                    <li><a href="<?php print site_url("perusahaan")?>">Perusahaan</a></li>
                    <li><a href="<?php print site_url("produk")?>">Produk</a></li>
                    <li><a href="<?php print site_url("kategori")?>">Kategori</a></li>
                    <li><a href<?php print site_url("penawaran-barang")?>">Penawaran Barang</a></li>
                    <li><a href="<?php print site_url("permintaan-barang")?>">Permintaan Barang</a></li>
                  </ul>
<!--                  <form class="navbar-form navbar-right" role="search">
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Username/Email">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary">Masuk</button>

                    <a href="#" class="btn btn-success">Daftar Gratis</a>
                  </form>-->
                </div><!-- /.navbar-collapse -->
              </nav>
            </div>
          
          <!-- end of navigation -->

          <!-- content -->
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="slide" style="background:#333; width:100%; height: 300px;">
              <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                  <?php
                  $ke = 0;
                  foreach($slide AS $sld){
                    foreach($sld AS $sld_view){
                      if($ke == 0){
                        $active = "active";
                      }
                      else{
                        $active = "";
                      }
                      
                      print "<li data-target='#carousel-example-generic' data-slide-to='{$ke}' class='{$active}'></li>";
                      $data_slide .= "<div class='item {$active}'>"
                        . "<a href='".site_url($sld_view->link)."'><img src='".base_url()."/files/portal/promo/{$sld_view->gambar}' alt='{$sld_view->title}'></a>"
                        . "<div class='carousel-caption'>{$sld_view->title}</div></div>";
                      $ke++;
                    }
                  }
                  ?>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                  <?php print $data_slide;?>
                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                  <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                  <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
              </div>
            </div>

            <div style="clear:both;height:1em;"></div>

            <!-- new products -->
            <div class="new-products">
              <div class="panel panel-default">
                <div class="panel-heading">
                  Produk Terbaru
                </div>
                <div class="panel-body">
                  <div class="col-sm-6 col-md-6 col-lg-3">
                      <div style="background:#333; width:100px; height: 100px; margin:0 auto;"></div>
                      <p class="products-name"><a href="#">Produk baru 1</a></p>
                  </div>  
                  <div class="col-sm-6 col-md-6 col-lg-3">
                      <div style="background:#333; width:100px; height: 100px; margin:0 auto;"></div>
                      <p class="products-name"><a href="#">Produk baru 1</a></p>
                  </div>  
                  <div class="col-sm-6 col-md-6 col-lg-3">
                      <div style="background:#333; width:100px; height: 100px; margin:0 auto;"></div>
                      <p class="products-name"><a href="#">Produk baru 1</a></p>
                  </div>  
                  <div class="col-sm-6 col-md-6 col-lg-3">
                      <div style="background:#333; width:100px; height: 100px; margin:0 auto;"></div>
                      <p class="products-name"><a href="#">Produk baru 1</a></p>
                  </div>
                  <div class="col-sm-6 col-md-6 col-lg-3">
                      <div style="background:#333; width:100px; height: 100px; margin:0 auto;"></div>
                      <p class="products-name"><a href="#">Produk baru 1</a></p>
                  </div>  
                  <div class="col-sm-6 col-md-6 col-lg-3">
                      <div style="background:#333; width:100px; height: 100px; margin:0 auto;"></div>
                      <p class="products-name"><a href="#">Produk baru 1</a></p>
                  </div>  
                  <div class="col-sm-6 col-md-6 col-lg-3">
                      <div style="background:#333; width:100px; height: 100px; margin:0 auto;"></div>
                      <p class="products-name"><a href="#">Produk baru 1</a></p>
                  </div>  
                  <div class="col-sm-6 col-md-6 col-lg-3">
                      <div style="background:#333; width:100px; height: 100px; margin:0 auto;"></div>
                      <p class="products-name"><a href="#">Produk baru 1</a></p>
                  </div>
                </div>
              </div>
            </div>
            <!-- end of new products -->

            <div style="clear:both;height:1em;"></div>

            <div class="promo-tab">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#penawaran-barang" data-toggle="tab">Penawaran Barang</a></li>
                <li><a href="#permintaan-barang" data-toggle="tab">Permintaan Barang</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade in active" id="penawaran-barang">
                  <div class="penawaran-barang-wrapper">
                    <div class="col-lg-8">
                      <ul class="promo-list">
                        <li><a href="#">Link 1: The quick brown fox jumps over the lazy dog</a></li>
                        <li><a href="#">Link 1: The quick brown fox jumps over the lazy dog</a></li>
                        <li><a href="#">Link 1: The quick brown fox jumps over the lazy dog</a></li>
                        <li><a href="#">Link 1: The quick brown fox jumps over the lazy dog</a></li>
                      </ul>
                    </div>
                    <div class="col-lg-4" style="padding:1em 0;">
                      <p>
                        <strong>PT Abs Sejahtera Abadi</strong><br />
                        [<span class="glyphicon glyphicon-star"></span> Gold Member]
                        <br />
                        <a href="#">Lihat halaman perusahaan</a>
                        <a href="#">Lihat penawaran barang</a>
                      </p>
                    </div>
                  </div>                  
                </div>
                <div class="tab-pane fade" id="permintaan-barang">
                  <div class="permintaan-barang-wrapper">
                    <div class="col-lg-8">
                      <ul class="promo-list">
                        <li><a href="#">Link 1: The quick brown fox jumps over the lazy dog. Lorem ipsum dolor sit amet</a></li>
                        <li><a href="#">Link 1: The quick brown fox jumps over the lazy dog. Consectectur adispiscing elit</a></li>
                        <li><a href="#">Link 1: The quick brown fox jumps over the lazy dog</a></li>
                        <li><a href="#">Link 1: The quick brown fox jumps over the lazy dog</a></li>
                      </ul>
                    </div>
                    <div class="col-lg-4" style="padding:1em 0;">
                      <p>
                        <strong>PT Abs Sejahtera Abadi</strong><br />
                        [<span class="glyphicon glyphicon-star"></span> Gold Member]
                        <br />
                        <a href="#">Lihat halaman perusahaan</a>
                        <a href="#">Lihat permintaan barang</a>
                      </p>
                    </div>
                  </div>
                  <div class="permintaan-barang-wrapper">
                    <div class="col-lg-8">
                      <ul class="promo-list">
                        <li><a href="#">Link 1: The quick brown fox jumps over the lazy dog</a></li>
                        <li><a href="#">Link 1: The quick brown fox jumps over the lazy dog</a></li>
                        <li><a href="#">Link 1: The quick brown fox jumps over the lazy dog</a></li>
                        <li><a href="#">Link 1: The quick brown fox jumps over the lazy dog</a></li>
                      </ul>
                    </div>
                    <div class="col-lg-4" style="padding:1em 0;">
                      <p>
                        <strong>PT BCS Makmur Abadi</strong><br />
                        [<span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span> Platinum Member]
                        <br />
                        <a href="#">Lihat halaman perusahaan</a>
                        <a href="#">Lihat permintaan barang</a>
                      </p>
                    </div>
                  </div>                 
                </div>
              </div>
            </div>
          </div>
          <!-- end of content -->

          <!-- right sidebar -->
          <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4">
            <?php
            if(!$this->session->userdata("id")){
            ?>
            <div class="col-sm-6 col-md-12 col-lg-12 panel panel-primary login-panel">
              <div class="panel-body">
                <form class="form-horizontal" action="<?php print site_url("dashboard/login")?>" method="post">
                  <fieldset>
                    <legend>Masuk</legend>
                    <div class="form-group">
                      <label for="inputEmail" class="col-lg-4 control-label">Email</label>
                      <div class="col-lg-8">
                        <input type="text" class="form-control" name="email" id="inputEmail" placeholder="Email">
                        <input type="text" style="display: none" name="lokasi" value="<?php print uri_string()?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword" class="col-lg-4 control-label">Password</label>
                      <div class="col-lg-8">
                        <input type="password" class="form-control" name="sandi" id="inputPassword" placeholder="Password">
<!--                        <div class="checkbox">
                          <label>
                            <input type="checkbox"> Remember me
                          </label>
                        </div>-->
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-lg-8 col-lg-offset-4">
                        <button type="submit" class="btn btn-primary btn-sm">Kirim</button><br />
                        <a href="#" class="text-right">Lupa password?</a>
                      </div>
                    </div>
                  </fieldset>
                </form>
                <a href="#" class="btn btn-block btn-success">Daftar Gratis!</a>
              </div>
            </div>
            <?php }
            else{
            ?>
            <div class="col-sm-6 col-md-12 col-lg-12 panel panel-primary login-detail">
              <div class="panel-body">
                <ul class="nav nav-pills nav-stacked">
                  <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <span class="glyphicon glyphicon-user"></span> <?php print $this->session->userdata("name")?>
                    <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                      <li><a href="#">Edit Profile</a></li>
                      <li><a href="#">Link</a></li>
                      <li class="divider"></li>
                    </ul>
                  </li>
                  <li><a href="<?php print site_url("cms/portal-cms/contact-us")?>" target="_blank"><span class="glyphicon"></span> Area Member</a></li>
                  <li><a href="<?php print site_url("dashboard/logout")?>"><span class="glyphicon glyphicon-off"></span> Keluar</a></li>
                </ul>
              </div>
            </div>
            <?php }?>
            <div class="col-sm-6 col-md-12 col-lg-12 adv">
              <img src="<?php print $url?>img/adv-rectangle.jpg" />
            </div>
            <div class="col-sm-6 col-md-12 col-lg-12 adv">
              
            </div>
            <div class="col-sm-6 col-md-12 col-lg-12 adv">
              <img src="<?php print $url?>img/adv-rectangle.jpg" />
            </div>
          </div>
          <!-- end of right sidebar -->
        </div>

        <!-- footer -->
        <div class="footer-wrapper">
          <div class="row">
            <footer>
              <div class="col-xs-12 provinsi">
                <ul class="footer-provinsi">
                  <?php
                  foreach($provinsi AS $prov){
                    print "<li><a href='".site_url("propinsi/{$prov->nicename}")."'>{$prov->title}</a></li>";
                  }
                  ?>
                </ul>
              </div>
              <div class="col-xs-12 text-center"><p>&copy; BIZTRADE.COM - Direktori Perusahaan Terlengkap Se-Indonesia</p></div>
            </footer>
          </div>
        </div>      
        <!-- end of footer -->
      </div><!-- end of container -->      
    </div>
    
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php print $url?>js/jquery.min.js"></script>
    <script src="<?php print $url?>js/bootstrap.min.js"></script>
    <script src="<?php print $url?>js/main.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php print $url?>js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>