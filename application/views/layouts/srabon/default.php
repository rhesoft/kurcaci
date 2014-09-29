<?php
$edit = $this->nbscache->get_explode("menu", $this->session->userdata("id_privilege"));
$menu_ca = unserialize($edit[1]);
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8">
<title>NUSATO - Bisnis Monitoring</title>
<!-- styles -->
<!--<link id="themes" href="<?php print $url?>css/Agabungan.css" rel="stylesheet">-->
<link id="themes" href="<?php print $url?>css/Autama.css" rel="stylesheet">

<!--<link href="<?php print $url?>css/jquery-ui-1.8.16.custom.css" rel="stylesheet">-->
<!--<link href="<?php print $url?>css/bootstrap-responsive.css" rel="stylesheet">-->
<!--<link href="<?php print $url?>js/plupupload/jquery.plupload.queue/css/jquery.plupload.queue.css" rel="stylesheet">-->
<!--<link href="<?php print $url?>css/icons-sprite.css" rel="stylesheet">-->
<!--<link href="<?php print $url?>css/prettify.css" rel="stylesheet">-->
<!--<link href="<?php print $url?>css/elfinder.min.css" rel="stylesheet">-->
<!--<link href="<?php print $url?>css/elfinder.theme.css" rel="stylesheet">-->
<!--<link href="<?php print $url?>css/simpletree.css" rel="stylesheet">-->

<!--<link href="<?php print $url?>css/jquery.jqplot.css" rel="stylesheet">-->
<!--<link href="<?php print $url?>css/fullcalendar.css" rel="stylesheet">-->

<link rel="shortcut icon" href="<?php print $url?>ico/icon.ico">

<script src="<?php print $url?>js/Agabungan.js"></script>

<!--<script src="<?php print $url?>js/jquery.js"></script>-->
<!--<script src="<?php print $url?>js/jquery-ui-1.8.16.custom.min.js"></script>-->
<!--<script src="<?php print $url?>js/jquery.ui.touch-punch.js"></script>-->
<!--<script src="<?php print $url?>js/bootstrap.js"></script>-->
<!--<script src="<?php print $url?>js/prettify.js"></script>
<script src="<?php print $url?>js/jquery.nicescroll.min.js"></script>-->
<!--<script type="text/javascript" charset="utf-8" src="<?php print $url?>js/simpletreemenu.js"></script>-->
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner top-nav">
    <div class="container-fluid">
      <ul class="nav pull-right">
        <li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php print $this->session->userdata('name')?><i class="white-icons admin_user"></i><b class="caret"></b></a>
          <ul class="dropdown-menu">
            <!--<li><?php print $site_juklak['link']?></li>-->
            <li><a href="<?php print site_url("users/edit-profile")?>"><i class="icon-cog"></i> Account Settings</a></li>
            <li class="divider"></li>
            <li><a href="<?php print   site_url("login")?>"><i class="icon-off"></i><strong> Logout</strong></a></li>
          </ul>
        </li>
      </ul>
      <button data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar" type="button"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
      <div class="nav-collapse collapse">
        <ul class="nav">
          <?php
          foreach($menu_ca as $ky => $md){
            if($md){
            ?>
          <li class="dropdown"><a onclick="hilang(<?php print $ky?>)" href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="nav-icon blocks_images"></i><?php print $md['name']?><b class="caret"></b></a>
            <ul class="dropdown-menu" id="anak_hilang_<?php print $ky?>" style="display: none">
              <?php
              foreach($md['child'] as $mns2){
                $link_set = site_url($mns2['link']);
                if(is_array($mns2['child'])){
                  print "<li class='nav-header'>{$mns2['name']}</li>";
                  foreach($mns2['child'] as $cicit){
                    print "<li class='nav-header'><a href='".site_url($cicit['link'])."'><span class='sidenav-icon'><span class='sidenav-link-color'></span></span>{$cicit['name']}</a></li>";
                  }
                }
                else{
                  print <<<EOD
     <li class="nav-header"><a href="{$link_set}"><span class="sidenav-icon"><span class="sidenav-link-color"></span></span>{$mns2['name']}</a></li>
EOD;
                }
              }
              ?>
            </ul>
          </li>
          <?php
            }
          }?>
        </ul>
      </div>
    </div>
  </div>
</div>
<div id="sidebar">
  <center><a href="<?php print   site_url($this->session->userdata("dashbord"))?>"><img src="<?php print $url?>img/logo.png" width="250" alt="Logo"></a></center>
  <ul id="treemenu2" class="treeview side-nav">
    <?php
    foreach($menu_ca as $k_mc => $mc){
      print <<<EOD
      <li><div class="lili"><span class="white-icons blocks_images"></span>{$mc['name']}</div>
EOD;
      $ululnya = '<ul class="acitem">';
      $lilinya = "";
      foreach($mc['child'] as $k_child => $mchild){
        if(count($mchild['child']) > 0){
          $link_sub = $mchild['name'];
        }
        else{
          if($menu == $mchild['link']){
            $ululnya = "<ul class='acitem' rel='open'>";
          }
          $link_sub = "<a href='".site_url($mchild['link'])."'>{$mchild['name']}</a>";
        }
        $lilinya .= <<<EOD
        <li><div class="sublili"><span class="white-icons list"></span>{$link_sub}</div>
EOD;
        if(count($mchild['child']) > 0){
          $ulnya = "<ul>";
          $linya = "";
          foreach($mchild['child'] as $kmchild => $mcchild){
            if($menu == $mcchild['link']){
              $ulnya = "<ul rel='open'>";
            }
            $link_sub_child = site_url($mcchild['link']);
            $linya .= <<<EOD
              <li><div class="subsublili"><span class="white-icons book"></span><a href="{$link_sub_child}">{$mcchild['name']}</a></div>
EOD;
          }
          $lilinya .= $ulnya.$linya."</ul>";
        }
      }
      print $ululnya;
      print $lilinya;
      print <<<EOD
        </ul>
EOD;
    }
    ?>
  </ul>

<script type="text/javascript">

ddtreemenu.createTree("treemenu2", false);

function hilang(id){
  $("#anak_hilang_"+id).fadeToggle();
}

</script>
  
</div>
<div id="main-content">
  <div class="container-fluid">  
  <div class="row-fluid">
      <div class="span12">
        <div class="widget-block">
          <?php
          if($this->session->flashdata('notice')){
          ?>
          <div class="alert alert-error fade in">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>Filed!</strong> <?php print $this->session->flashdata('notice')?>
          </div>
          <?php
          }
          if($this->session->flashdata('success')){
          ?>
          <div class="alert alert-success fade in">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>Success!</strong> <?php print $this->session->flashdata('success')?>
          </div>
          <?php
          }
          if($this->session->flashdata('extent')){
          ?>
          <div class="alert alert-info fade in">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>Warning!</strong> <?php print $this->session->flashdata('extent')?>
          </div>
          <?php
          }
          ?>
        </div>
      </div>
  </div>
  </div>
</div>
<?php print $template['body']?>
</body>
<script src="<?php print $url?>js/respond.min.js"></script>
<?php print $foot?>
</html>