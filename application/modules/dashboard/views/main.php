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
              . "<a href='".site_url($sld_view->link)."'><img style='width:550px;height:300px' src='".base_url()."/files/portal/promo/{$sld_view->gambar}' alt='{$sld_view->title}'></a>"
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
        <?php
        foreach($new_product AS $np){
          if($np->picture){
            $gambar_products = base_url()."files/mrp/products/".$np->picture;
          }
          else{
            $gambar_products = base_url()."files/no-pic.png";
          }
          print "<div class='col-sm-6 col-md-6 col-lg-3'>"
          . "<div style='background:#333; width:100px; height: 100px; margin:0 auto;'>"
            . "<img style='width: 100px; height: 100px' src='{$gambar_products}'></div>"
            . "<p class='products-name'><a href='".site_url("produk/{$np->nicename}")."'>{$np->name}</a></p>"
            . "</div>";
        }
        ?>
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