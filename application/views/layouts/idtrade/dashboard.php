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
                  if($sub_category_temp[1]){
                    $sub_category = unserialize($sub_category_temp[1]);
                    print "<li>"
                    . "<a href='javascript:void(0);' class='btn btn-primary btn-block' style='text-align: left; white-space: normal'>{$cate['name']}</a>"
                    . "<ul class='subkategori-nav'>";
                    foreach($sub_category AS $key_sub => $subcate){
                      print "<li><a href='".site_url("produk/kategori/".$subcate['nicename'])."' class='btn btn-primary btn-block'>{$subcate['name']}</a></li>";
                    }
                    print "</ul>"
                    . "</li>";
                  }
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
                    <li class="<?php print $menu_atas['home']?>"><a href="<?php print site_url()?>"><span class="glyphicon glyphicon-home"></span> &nbsp;Home</a></li>
                    <li class="<?php print $menu_atas['perusahaan']?>"><a href="<?php print site_url("perusahaan")?>">Perusahaan</a></li>
                    <li class="<?php print $menu_atas['produk']?>"><a href="<?php print site_url("produk")?>">Produk</a></li>
                    <li class="<?php print $menu_atas['kategori']?>"><a href="<?php print site_url("kategori")?>">Kategori</a></li>
                    <li class="<?php print $menu_atas['penawaran-barang']?>"><a href<?php print site_url("penawaran-barang")?>">Penawaran Barang</a></li>
                    <li class="<?php print $menu_atas['permintaan-barang']?>"><a href="<?php print site_url("permintaan-barang")?>">Permintaan Barang</a></li>
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
          <?php print $template['body']?>
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
                    <div class="form-group">
                      <legend>Masuk</legend>
                      <div class="col-lg-8" style="width: 100%">
                        <input type="text" class="form-control" name="email" id="inputEmail" placeholder="Email" style="padding: 5px 5px;height: inherit;font-size: 12px; width: 40%">
                        <input type="password" class="form-control" name="sandi" id="inputPassword" placeholder="Password" style="padding: 5px 5px;height: inherit; font-size: 12px; width: 40%; ">
                        <input type="text" style="display: none" name="lokasi" value="<?php print uri_string()?>">
                        <button type="submit" value="login" name="submit" class="btn btn-primary btn-sm">Masuk</button>
                      </div>
                      <div class="col-lg-8" style="width: 100%">
                        <a href="#" class="text-right">Lupa password?</a>
                      </div>
                    </div>
                    <div class="form-group">
                      <legend>Mendaftar</legend>
                      <div class="col-lg-8" style="width: 100%">
                        <input type="text" class="form-control" name="first_name" placeholder="Nama Depan" style="padding: 5px 5px;height: inherit;font-size: 12px; width: 49%">
                        <input type="text" class="form-control" name="last_name" placeholder="Nama Belakang" style="padding: 5px 5px;height: inherit; font-size: 12px; width: 49%; ">
                      </div>
                      <div class="col-lg-8" style="width: 100%">
                        <input type="text" class="form-control" name="daftar_email" placeholder="Email" style="padding: 5px 5px;height: inherit;font-size: 12px; width: 99%">
                      </div>
                      <div class="col-lg-8" style="width: 100%">
                        <input type="password" class="form-control" name="pass" placeholder="Password" style="padding: 5px 5px;height: inherit;font-size: 12px; width: 99%">
                      </div>
                      <div class="col-lg-8" style="width: 100%">
                        <input type="password" class="form-control" name="re_pass" placeholder="Masukkan lagi Password" style="padding: 5px 5px;height: inherit;font-size: 12px; width: 99%">
                      </div>
                    </div>
                  </fieldset>
<!--                  <fieldset>
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
                        <div class="checkbox">
                          <label>
                            <input type="checkbox"> Remember me
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-lg-8 col-lg-offset-4">
                        <button type="submit" class="btn btn-primary btn-sm">Kirim</button><br />
                        <a href="#" class="text-right">Lupa password?</a>
                      </div>
                    </div>
                  </fieldset>-->
                
                <button type="submit" value="daftar" class="btn btn-block btn-success" name="submit">Daftar Gratis!</button>
                </form>
                <!--<a href="<?php print site_url("dashboard/register");?>" class="btn btn-block btn-success"></a>-->
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
            <?php }
            foreach($ads['inti'] AS $inti){
              print "<div class='col-sm-6 col-md-12 col-lg-12 adv'>"
              . "<img src='".base_url()."/files/portal/advertisement/{$inti->gambar}' width='330' height='300' />"
              . "</div>"
              . "<div class='col-sm-6 col-md-12 col-lg-12 adv'>"
              . "</div>";
            }
            foreach($ads['tambahan'] AS $tambahan){
              print "<div class='col-sm-6 col-md-12 col-lg-12 adv'>"
              . "<img src='".base_url()."/files/portal/advertisement/{$tambahan->gambar}' width='330' height='300' />"
              . "</div>"
              . "<div class='col-sm-6 col-md-12 col-lg-12 adv'>"
              . "</div>";
            }
            ?>
            
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
                    print "<li><a href='".site_url("produk/propinsi/{$prov->nicename}")."'>{$prov->title}</a></li>";
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