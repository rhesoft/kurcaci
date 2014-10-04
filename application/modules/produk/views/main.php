<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
  <div class="category-page-wrapper">
    <div class="category-product-wrapper">
      <?php
      foreach($products AS $produk){
        if($produk->picture){
          $gambar_products = base_url()."files/mrp/products/".$produk->picture;
        }
        else{
          $gambar_products = base_url()."files/no-pic.png";
        }
        
        print "<div class='category-product'>"
        . "<h3><a href='".site_url("produk/{$produk->nicename}")."'>{$produk->name}</a></h3>"
          . "<img src='{$gambar_products}' style='width:150px;height:150px' alt='product' class='pull-left'>"
          . "<h4>Deskripsi</h4>"
          . $produk->note
//          . "<h4>Spesifikasi</h4>"
//          . $produk->spesification
          . "<div class='clearfix'></div>"
          . "<div class='panel panel-primary'>"
          . "<div class='panel-body'>"
          . "<p>"
          . "<a href='#' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-envelope'></span> &nbsp; Minta Penawaran</a>"
          . "<a href='#' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-shopping-cart'></span> &nbsp; Masukkan Troli Permintaan</a>"
          . "</p>"
          . "<p>Penjual: "
//          . "[<span class='glyphicon glyphicon-star'></span> Gold Member]"
          . "<strong><a target='_blank' href='".site_url("{$produk->company_nicename}/home")."'>{$produk->company}</a></strong></p>"
          . "{$produk->address}<a href='".site_url("produk/propinsi/{$produk->lokasi_nicename}")."'>{$produk->lokasi}</a>"
          . "</div>"
          . "</div>"
          . "</div>";
      }
      ?>
    </div>
    <div class="clearfix"></div>
  </div>

  <!-- pagination -->
  <div class="text-center">
    <ul class="pagination">
      <li class="disabled"><a href="#">«</a></li>
      <li class="active"><a href="#">1</a></li>
      <li><a href="#">2</a></li>
      <li><a href="#">3</a></li>
      <li><a href="#">4</a></li>
      <li><a href="#">5</a></li>
      <li><a href="#">»</a></li>
    </ul>
  </div>
  <!-- end of pagination -->
</div>