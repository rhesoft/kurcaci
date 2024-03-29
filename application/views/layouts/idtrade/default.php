<!DOCTYPE html>
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
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">

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
                      <input class="form-control input-md input-search" placeholder="Masukkan kata kunci disini..." />
                    </div>
                    <div class="form-group">
                      <select class="form-control input-md">
                        <option>Kategori</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <select class="form-control input-md">
                        <option>Provinsi</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-md">Cari</button>
                  </form>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                <a href="#" class="btn btn-default btn-sm">Login</a>
                <a href="#" class="btn btn-default btn-sm">Register</a>
              </div>
            </div>
          </div>
        </header>
        <!-- end of header -->

        <!-- kategori selector -->
        <div class="visible-xs visible-sm" style="margin-bottom:1em;">
          <select class="form-control" id="kategori-select">
            <option value="#">Kategori 1</option>
            <option value="http://www.google.com">Kategori 2</option>
            <option>Kategori 3</option>
            <option>Kategori 4</option>
            <option>Kategori 5</option>
            <option>Kategori 6</option>
            <option>Kategori 7</option>
            <option>Kategori 8</option>
          </select>
        </div>
        <!-- end of kategori selector -->

        <div class="row row-offcanvas row-offcanvas-left">
          <!-- left sidebar -->
          <div class="hidden-sm hidden-xs col-md-3 col-lg-2">
            <div class="sidebar">
              <ul class="kategori-nav">
                <li>
                  <a href="#" class="btn btn-primary btn-block">Kategori 1</a>
                  <ul class="subkategori-nav">
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                  </ul>
                </li>
                <li>
                  <a href="#" class="btn btn-primary btn-block">Kategori 2</a>
                  <ul class="subkategori-nav">
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                  </ul>
                </li>
                <li>
                  <a href="#" class="btn btn-primary btn-block">Kategori 3</a>
                  <ul class="subkategori-nav">
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                  </ul>
                </li>
                <li>
                  <a href="#" class="btn btn-primary btn-block">Kategori 4</a>
                  <ul class="subkategori-nav">
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                  </ul>
                </li>
                <li>
                  <a href="#" class="btn btn-primary btn-block">Kategori 5</a>
                  <ul class="subkategori-nav">
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                    <li><a href="#" class="btn btn-primary btn-block">Subkategori</a></li>
                  </ul>
                </li>
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
                    <li class="active"><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                  </ul>
                  <form class="navbar-form navbar-right" role="search">
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Username/Email">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary">Masuk</button>

                    <a href="#" class="btn btn-success">Daftar Gratis</a>
                  </form>
                </div><!-- /.navbar-collapse -->
              </nav>
            </div>
          
          <!-- end of navigation -->

          <!-- content -->
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="slide" style="background:#333; width:100%; height: 300px;"></div>

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
            <div class="col-sm-6 col-md-12 col-lg-12 panel panel-primary login-panel">
              <div class="panel-body">
                <form class="form-horizontal">
                  <fieldset>
                    <legend>Masuk</legend>
                    <div class="form-group">
                      <label for="inputEmail" class="col-lg-4 control-label">Email</label>
                      <div class="col-lg-8">
                        <input type="text" class="form-control" id="inputEmail" placeholder="Email">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword" class="col-lg-4 control-label">Password</label>
                      <div class="col-lg-8">
                        <input type="password" class="form-control" id="inputPassword" placeholder="Password">
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
                  </fieldset>
                </form>
                <a href="#" class="btn btn-block btn-success">Daftar Gratis!</a>
              </div>
            </div>
            <div class="col-sm-6 col-md-12 col-lg-12 panel panel-primary login-detail">
              <div class="panel-body">
                <ul class="nav nav-pills nav-stacked">
                  <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <span class="glyphicon glyphicon-user"></span> Username
                    <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                      <li><a href="#">Edit Profile</a></li>
                      <li><a href="#">Link</a></li>
                      <li class="divider"></li>
                    </ul>
                  </li>
                  <li><a href="#"><span class="glyphicon"></span> Area Member</a></li>
                  <li><a href="#"><span class="glyphicon glyphicon-off"></span> Keluar</a></li>
                </ul>
              </div>
            </div>
            <div class="col-sm-6 col-md-12 col-lg-12 adv">
              <img src="img/adv-rectangle.jpg" />
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
                  <li><a href="#">Sumatra Utara</a></li>
                  <li><a href="#">Sumatra Barat</a></li>
                  <li><a href="#">Sumatra Selatan</a></li>
                  <li><a href="#">DKI Jakarta</a></li>
                  <li><a href="#">Jawa Barat</a></li>
                  <li><a href="#">Jawa Tengah</a></li>
                  <li><a href="#">Jawa Timur</a></li>
                  <li><a href="#">DI Yogyakarta</a></li>
                  <li><a href="#">Kalimantan Barat</a></li>
                  <li><a href="#">Kalimantan Tengah</a></li>
                  <li><a href="#">Kalimantan Selatan</a></li>
                  <li><a href="#">Kalimantan Timur</a></li>
                  <li><a href="#">Bali</a></li>
                  <li><a href="#">NTT</a></li>
                  <li><a href="#">Sulawesi Utara</a></li>
                  <li><a href="#">Sulawesi Barat</a></li>
                  <li><a href="#">Sulawesi Selatan</a></li>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>