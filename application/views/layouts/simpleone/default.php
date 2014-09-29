<?php
//$product_list = unserialize($this->input->cookie('cart'));
$edit = $this->nbscache->get_explode("menu_cart", 0);
$menu_ca = unserialize($edit[1]);

$info_temp = $this->nbscache->get_explode("cart", "info");
$info = unserialize($info_temp[1]);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>135 Shop - Boneka, Tas, Dompet, Kreatif, Flanel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="Nugroho Budhi Santoso">
<link href="<?php print $url?>css/font-face.css" rel="stylesheet">
<link href="<?php print $url?>css/bootstrap.css" rel="stylesheet">
<link href="<?php print $url?>css/bootstrap-responsive.css" rel="stylesheet">
<link href="<?php print $url?>css/style.css" rel="stylesheet">
<link href="<?php print $url?>css/flexslider.css" type="text/css" media="screen" rel="stylesheet"  />
<link href="<?php print $url?>css/jquery.fancybox.css" rel="stylesheet">
<link href="<?php print $url?>css/cloud-zoom.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="<?php print $url?>css/noty-css/jquery.noty.css"/>
<link rel="stylesheet" type="text/css" href="<?php print $url?>css/noty-css/noty_theme_default.css"/>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<!-- fav -->
<link rel="shortcut icon" href="<?php print $url?>assets/ico/favicon.html">
</head>
<body>
<!-- Header Start -->
<header>
  <div class="headerstrip">
    <div class="container">
      <div class="row">
        <div class="span12">
          <a href="<?php print site_url(MODULECART)?>" class="logo pull-left"><img src="<?php print base_url()."files/ec/info/".$info['logo']?>" alt="135 Boneka" title="135 Shop"></a>
          <!-- Top Nav Start -->
          <div class="pull-left">
            <div class="navbar" id="topnav">
              <div class="navbar-inner">
                <ul class="nav" >
                  <li><a class="home" href="<?php print   site_url(MODULECART)?>">Home</a>
                  </li>
                  <li><a class="shoppingcart" href="<?php print   site_url("boneka/shopping-cart")?>">Shopping Cart</a>
                  </li>
                  <li><a class="checkout" href="<?php print   site_url("boneka/checkout")?>">CheckOut</a>
                  </li>
                  <li><a class="myaccount" href="<?php print   site_url("boneka/my-account")?>">My Account</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <!-- Top Nav End -->
<!--          <div class="pull-right">
            <form class="form-search top-search">
              <input type="text" class="input-medium search-query" placeholder="Search Here…">
            </form>
          </div>-->
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="headerdetails">
      <?php
      if($this->session->userdata('affiliate')){
      ?>
      <div class="pull-left">
        Link Affiliate <input type="text" value="<?php print site_url($this->uri->uri_string()."?a=".$this->session->userdata('affiliate'))?>" style="width: 400px" />
      </div>
      <?php
      }
      ?>
      <form action="<?php print site_url(MODULECART."/product-search")?>" method="post">
      <div class="pull-left">
        <ul class="nav language pull-left">
          <li class="dropdown hover">
            Title <input name="cari_title" value="<?php print $cari_title?>" type="text" class="search-query input-medium" placeholder="Search Here…">
          </li>
          <li class="dropdown hover">
            Price 
            <input name="cari_price_from" id="cari_price_from" value="<?php print $cari_price_from?>" type="text" class="search-query input-medium"> -
            <input name="cari_price_to" id="cari_price_to" value="<?php print $cari_price_to?>" type="text" class="search-query input-medium">
          </li>
        </ul>
        <br />
            <input type="submit" value="Search" class="btn btn-orange">
      </div>
      </form>
      <div class="pull-right">
        <ul class="nav topcart pull-left">
          <li class="dropdown hover carticon " style="width: 300px">
            <a href="<?php print   site_url("boneka/shop")?>" class="dropdown-toggle" > 
              <?php
              $session = $this->session->userdata("cart");
              $session = unserialize($session);
              $gt = 0;
              foreach ($session AS $id_products => $ss){
                $product_f = $this->global_models->get("mrp_products", array("id_mrp_products" => $id_products));
                $ppk .= "
                  <tr class='ppk' id='ppk_{$product_f[0]->id_mrp_products}'>
                    <td class='name'><a href='".site_url(MODULECART."/products/".$product_f[0]->nicename)."'>{$product_f[0]->name}</a></td>
                    <td class='quantity'>x&nbsp;{$ss}</td>
                    <td class='total'>Rp ".number_format(($product_f[0]->price * $ss), 0, ",", ".")."</td>
                    <td class='remove'><i class='icon-remove' onclick='hapus_cart({$product_f[0]->id_mrp_products})'></i></td>
                  </tr>
                  ";
                $total_cart += ($product_f[0]->price * $ss);
                $gt++;
              }
              ?>
              Shopping Cart <span class="label label-orange font14"><span id="total_items"><?php print $gt?></span> Item(s)</span> - Rp 
              <span id="total_cart1"><?php print number_format($total_cart, 0, ",", ".")?></span> <b class="caret"></b></a>
            <ul class="dropdown-menu topcartopen ">
              <li>
                <table name="cart">
                  <tbody id="act">
                    <?php
                    print $ppk;
                    ?>
                  </tbody>
                </table>
                <table>
                  <tbody>
                    <tr>
                      <td class="textright"><b>Sub-Total:</b></td>
                      <td class="textright">Rp <span id="total_cart"><?php print number_format($total_cart, 0, ",", ".")?></span></td>
                    </tr>
<!--                    <tr>
                      <td class="textright"><b>Eco Tax (-2.00):</b></td>
                      <td class="textright">$2.00</td>
                    </tr>
                    <tr>
                      <td class="textright"><b>VAT (17.5%):</b></td>
                      <td class="textright">$87.50</td>
                    </tr>
                    <tr>
                      <td class="textright"><b>Total:</b></td>
                      <td class="textright">$589.50</td>
                    </tr>-->
                  </tbody>
                </table>
                <div class="well pull-right buttonwrap">
                  <a class="btn btn-orange" href="<?php print   site_url("boneka/shopping-cart")?>">View Cart</a>
                  <a class="btn btn-orange" href="<?php print   site_url("boneka/checkout")?>">Checkout</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
    <div id="categorymenu">
      <nav class="subnav">
        <ul class="nav-pills categorymenu">
          <?php
          foreach($menu_ca as $mc){
            print "<li><a href='".  site_url($mc['link'])."'>".$mc['name']."</a>";
            if(count($mc['anak']) > 0){
              print "<div><ul>";
              foreach($mc['anak'] as $anak){
                print "<li><a href='".  site_url($anak['link'])."'>".$anak['name']."</a></li>";
              }
              print "</ul></div>";
            }
            print "</li>";
          }
          ?>
<!--          <li><a class="active"  href="site">Home</a>
          </li>-->
<!--          <li><a href="product.html">Products</a>
            <div>
              <ul>
                <li><a href="product.html">Product style 1</a>
                </li>
                <li><a href="product2.html">Product style 2</a>
                </li>
                <li><a href="#"> Women's Accessories</a>
                </li>
                <li><a href="#">Men's Accessories <span class="label label-success">Sale</span>
                  </a>
                </li>
                <li><a href="#">Dresses </a>
                </li>
                <li><a href="#">Shoes <span class="label label-warning">(25)</span>
                  </a>
                </li>
                <li><a href="#">Bags <span class="label label-info">(new)</span>
                  </a>
                </li>
                <li><a href="#">Sunglasses </a>
                </li>
              </ul>
              <ul>
                <li><img src="img/proudctbanner.jpg" alt="" title="">
                </li>
              </ul>
            </div>
          </li>-->
          
<!--          <li><a href="shopping-cart.html">Shopping Cart</a>
          </li>
          <li><a href="checkout.html">Checkout</a>
          </li>-->
          <li><a href="<?php print   site_url("boneka/my-account")?>">My Account</a>
            <div>
              <ul>
                <?php
                if($this->session->userdata('id') > 0){
                  print "
                  <li><a href='".site_url("boneka/my-account")."'>My Account</a></li>
                  <li><a href='".site_url("boneka/shopping-history")."'>Shopping History</a></li>
                  <li><a href='".site_url("boneka/wishlist")."'>Wishlist</a></li>
                  <li><a href='".site_url("boneka/affiliate")."'>Affiliate</a></li>
                  <li><a href='".site_url("boneka/logout")."'>Logout</a></li>
                  ";
                }
                else{
                  print "
                    <li><a href='".site_url("boneka/login")."'>Login</a></li>
                    <li><a href='".site_url("boneka/register")."'>Register</a></li>
                  ";
                }
                ?>
              </ul>
            </div>
          </li>
          <li><a href="<?php print site_url(MODULECART."/contact")?>">Contact</a>
          </li>         
        </ul>
      </nav>
    </div>
  </div>
</header>
<!-- Header End -->

<div id="maincontainer">
  <div class="container">
    <?php
    if($this->session->flashdata('notice') OR $this->session->flashdata('success')){
    ?>
    <section class="messages">
      <?php
      if($this->session->flashdata('success')){
      ?>
      <div class="successmsg alert">
        <a class="clostalert">close</a>
        <strong>Sucess!</strong> <?php print $this->session->flashdata('success')?> </div>
      <?php
      }
      if($this->session->flashdata('notice')){
      ?>
      <div class="errormsg alert">
        <a class="clostalert">close</a>
        <strong>Error!</strong> <?php print $this->session->flashdata('notice')?> </div>
      <?php
      }
      ?>
    </section>
    <?php
    }
    ?>
    <div class="row">
      <div class="span9">
        <?php print $template['body']?>
      </div>
      <aside class="span3">
        <!-- Category-->
        <?php
        if($kategori_view){
        ?>
        <div class="sidewidt">
          <h2 class="heading2"><span>Categories</span></h2>
          <ul class="nav nav-list categories">
            <?php
            foreach($kategori_view AS $kt){
            ?>
            <li>
              <a href="<?php print site_url("boneka/product-category/".$kt->nicename) ?>"><?php print $kt->name ?></a>
            </li>
            <?php
            } ?>
          </ul>
        </div>
        <?php
        }
        if($brand_view){
        ?>
        <div class="sidewidt">
          <h2 class="heading2"><span>Brand</span></h2>
          <ul class="nav nav-list categories">
            <?php
            foreach($brand_view AS $brn){
            ?>
            <li>
              <a href="<?php print site_url("boneka/product-brand/".$brn->nicename) ?>"><?php print $brn->name ?></a>
            </li>
            <?php
            } ?>
          </ul>
        </div>
        <?php }?>
        <!-- Best Seller-->
<!--        <div class="sidewidt">
          <h2 class="heading2"><span>Best Seller</span></h2>
          <ul class="bestseller">
            <li>
              <img width="50" height="50" src="img/prodcut-40x40.jpg" alt="product" title="product">
              <a class="productname" href="product.html"> Product Name</a>
              <span class="procategory">Women Accessories</span>
              <span class="price">$250</span>
            </li>
            <li>
              <img width="50" height="50" src="img/prodcut-40x40.jpg" alt="product" title="product">
              <a class="productname" href="product.html"> Product Name</a>
              <span class="procategory">Electronics</span>
              <span class="price">$250</span>
            </li>
            <li>
              <img width="50" height="50" src="img/prodcut-40x40.jpg" alt="product" title="product">
              <a class="productname" href="product.html"> Product Name</a>
              <span class="procategory">Electronics</span>
              <span class="price">$250</span>
            </li>
          </ul>
        </div>-->
        <!-- Testimonial-->
        <?php
        if($testimonial_view){
        ?>
        <div class="sidewidt">
          <h2 class="heading2"><span>Testimonials</span></h2>
          <div class="flexslider" id="testimonialsidebar">
            <ul class="slides">
              <?php
              foreach($testimonial_view AS $tv){
              ?>
              <li>
                <?php print $tv->note?><br>
                <span class="pull-right orange">By : <?php print $tv->author?></span>
              </li>
              <?php
              }
              ?>
              
            </ul>
          </div>
        </div>
        <?php }
        if($must_view){
        ?>
        <!-- BMust Have-->
        <div class="sidewidt mt20">
          <h2 class="heading2"><span>Must have</span></h2>
          <div class="flexslider" id="mainsliderside">
            <ul class="slides">
              <?php
              foreach($must_view AS $mv){
                print "
                  <li>
                    <a href='".site_url(MODULECART."/products/{$mv->nicename}")."'>
                      <img src='".base_url()."files/mrp/products/{$mv->picture}' alt='{$mv->name}' />
                    </a>
                  </li>
                  ";
              }
              ?>
            </ul>
          </div>
        </div>
        <?php }?>
      </aside>
    </div>
  </div>
</div>
<!-- /maincontainer -->
<!-- Footer -->
<footer id="footer">
  <section class="footersocial">
    <div class="container">
      <div class="row">
        <div class="span3 aboutus">
          <h2>About Us </h2>
          <?php print $info['about_us'];?>
        </div>
        <div class="span3 contact">
          <h2>Contact Us </h2>
          <ul>
            <li class="phone"><?php print $info['handphone'];?></li>
            <li class="mobile"><?php print $info['telphone'];?></li>
            <li class="email"><?php print $info['email']?></li>
          </ul>
          <?php print $info['address']?>
        </div>
        <div class="span3 twitter">
          <h2>Twitter </h2>
          <div id="twitter">
          </div>
        </div>
        <div class="span3 facebook">
          <h2>Facebook </h2>
<!--          <div id="fb-root"></div>
          <script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>
          <script type="text/javascript">FB.init("");</script>
          <script type="text/javascript">
//<![CDATA[
document.write('<fb:fan profile_id="80655071208" stream="0"	connections="6"	logobar="0" height="190px"	width="200"css="css/fb.css"></fb:fan> ');
//]]>
</script>-->
        </div>
      </div>
    </div>
  </section>
  <section class="footerlinks">
    <div class="container">
      <div class="info">
        <ul>
          <li><a href="#">Privacy Policy</a>
          </li>
          <li><a href="#">Terms &amp; Conditions</a>
          </li>
          <li><a href="#">Affiliates</a>
          </li>
          <li><a href="#">Newsletter</a>
          </li>
        </ul>
      </div>
      <div id="footersocial">
        <a href="#" title="Facebook" class="facebook">Facebook</a>
        <a href="#" title="Twitter" class="twitter">Twitter</a>
        <a href="#" title="Linkedin" class="linkedin">Linkedin</a>
        <a href="#" title="rss" class="rss">rss</a>
        <a href="#" title="Googleplus" class="googleplus">Googleplus</a>
        <a href="#" title="Skype" class="skype">Skype</a>
        <a href="#" title="Flickr" class="flickr">Flickr</a>
      </div>
    </div>
  </section>
  <section class="copyrightbottom">
    <div class="container">
      <div class="row">
        <div class="span6"> </div>
        <div class="span6 textright">&copy; <img src="<?php print $url?>img/icon.ico" width="13" /> <a target="_blank" href="http://nusato.com">nusato.com</a> @ 2013 </div>
      </div>
    </div>
  </section>
  <!--<a id="gotop" href="#">Back to top</a>-->
</footer>
<!-- javascript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php print $url?>js/jquery.js"></script>
<script src="<?php print $url?>js/bootstrap.js"></script>
<script src="<?php print $url?>js/respond.min.js"></script>
<script src="<?php print $url?>js/application.js"></script>
<script src="<?php print $url?>js/bootstrap-tooltip.js"></script>
<script defer src="<?php print $url?>js/jquery.fancybox.js"></script>
<script defer src="<?php print $url?>js/jquery.flexslider.js"></script>
<script type="text/javascript" src="<?php print $url?>js/jquery.tweet.js"></script>
<script  src="<?php print $url?>js/cloud-zoom.1.0.2.js"></script>
<script  type="text/javascript" src="<?php print $url?>js/jquery.validate.js"></script>
<script type="text/javascript"  src="<?php print $url?>js/jquery.carouFredSel-6.1.0-packed.js"></script>
<script type="text/javascript"  src="<?php print $url?>js/jquery.mousewheel.min.js"></script>
<script type="text/javascript"  src="<?php print $url?>js/jquery.touchSwipe.min.js"></script>
<script type="text/javascript"  src="<?php print $url?>js/jquery.ba-throttle-debounce.min.js"></script>

<script defer src="<?php print $url?>js/custom.js"></script>

<script src="<?php print $url?>js/noty-script.js"></script>
<script src="<?php print $url?>js/jquery.noty.js"></script>

<link href="<?php print $url?>css/jquery-ui-1.8.16.custom.css" rel="stylesheet">
<script src="<?php print $url?>js/jquery-ui-1.8.16.custom.min.js"></script>
<script src="<?php print $url?>js/jquery.ui.core.js"></script>
<script src="<?php print $url?>js/jquery.ui.widget.js"></script>
<script src="<?php print $url?>js/jquery.ui.position.js"></script>
<script src="<?php print $url?>js/jquery.ui.autocomplete.js"></script>
<script src="<?php print $url?>js/jquery.price_format.1.8.min.js"></script>

<?php print $foot?>
</body>
</html>
<script>
  $(function() {
    $( '#cari_price_from' ).priceFormat({
      prefix: 'Rp ',
      centsLimit: 0,
      thousandsSeparator: '.'
    });
    $( '#cari_price_to' ).priceFormat({
      prefix: 'Rp ',
      centsLimit: 0,
      thousandsSeparator: '.'
    });
  });
</script>";