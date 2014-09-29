<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>135 Budhi Santoso | Information System Management</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="135 Budhi Santoso Information System Management. ERP System">
        <meta name="author" content="Nugroho Budhi Santoso">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="<?php print $url?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php print $url?>css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php print $url?>css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php print $url?>css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link href="<?php print $url?>css/simpletree.css" rel="stylesheet">
        <?php print $css;?>
    </head>
    <body class="skin-blue">
        <header class="header">
            <a href="<?php site_url()?>" class="logo">
                135 Budhi Santoso
            </a>
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope"></i>
                                <span class="label label-success"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 0 messages</li>
                                <li>
                                    <ul class="menu">
<!--                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                  <?php
                                                  if($this->session->userdata("avatar")){
                                                    $avatar = $this->session->userdata("avatar");
                                                  }
                                                  else{
                                                    $avatar = $url."img/no-pic.png";
                                                  }
                                                  ?>
                                                    <img src="<?php print $avatar?>" class="img-circle" alt="User Image"/>
                                                </div>
                                                <h4>
                                                    Support Team
                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>-->
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">See All Messages</a></li>
                            </ul>
                        </li>
                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-warning"></i>
                                <span class="label label-warning">!</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">Promo Prioritas</li>
                                <?php
                                $info_promo = $this->global_models->informasi_promo();
                                ?>
                                <li>
                                    <ul class="menu">
                                      <?php
                                      foreach($info_promo AS $ip){
                                      ?>
                                        <li>
                                            <a href="<?php print site_url($ip['link'])?>">
                                                <h4 style="margin: 0">
                                                    <?php print $ip["company"]?>
                                                </h4>
                                                <p style="margin: 0"><?php print $ip["title"]?></p>
                                                <p style="margin: 0"><small><i class="fa fa-clock-o"></i>End Date : <?php print date("d F Y", strtotime($ip["end_date"]))?></small></p>
                                            </a>
                                        </li>
                                      <?php }?>
                                    </ul>
                                </li>
                                <li class="footer"></li>
                            </ul>
                        </li>
                        <li class="dropdown tasks-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-tasks"></i>
                                <span class="label label-danger"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 0 tasks</li>
                                <li>
                                    <ul class="menu">
<!--                                        <li>
                                            <a href="#">
                                                <h3>
                                                    <small class="pull-right">20%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">20% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>-->
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="#">View all tasks</a>
                                </li>
                            </ul>
                        </li>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php print $this->session->userdata("name")?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                  <?php
                                  if($this->session->userdata("avatar")){
                                    $avatar = $this->session->userdata("avatar");
                                  }
                                  else{
                                    $avatar = $url."img/no-pic.png";
                                  }
                                  ?>
                                    <img src="<?php print $avatar?>" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php print $this->session->userdata("name")." - ".$this->global_models->get_field("m_privilege", "name", array("id_privilege" => $this->session->userdata("id_privilege")))?>
                                    </p>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?php print site_url("users/edit-profile")?>" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php print site_url("login")?>" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <aside class="left-side sidebar-offcanvas">
                <section class="sidebar">
                    <div class="user-panel">
                        <center><img src="<?php print $url?>img/logo.png" width="150" alt="135 System" /></center>
                    </div>
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    
<?php
$edit = $this->nbscache->get_explode("menu", $this->session->userdata("id_privilege"));
$menu_ca = unserialize($edit[1]);
?>
                        
                    <ul id="treemenu2" class="treeview sidebar-menu">
    <?php
    foreach($menu_ca as $k_mc => $mc){
      print <<<EOD
      <li class='treeview'>
          <a href="javascript:void(0)">
            <i class="fa {$mc['icon']}"></i>
            <span>{$mc['name']}</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
EOD;
      $ululnya = '<ul class="acitem treeview-menu">';
      $lilinya = "";
      foreach($mc['child'] as $k_child => $mchild){
        if(count($mchild['child']) > 0){
          $link_sub = "<a href='javascript:void(0)'><i class='fa fa-angle-double-right'></i> {$mchild['name']}</a>";
        }
        else{
          if($menu == $mchild['link']){
            $ululnya = "<ul class='acitem treeview-menu' rel='open'>";
          }
          $link_sub = "<a href='".site_url($mchild['link'])."'><i class='fa fa-angle-double-right'></i> {$mchild['name']}</a>";
        }
        $lilinya .= <<<EOD
        <li>
          {$link_sub}
EOD;
        if(count($mchild['child']) > 0){
          $ulnya = "<ul class='treeview-menu'>";
          $linya = "";
          foreach($mchild['child'] as $kmchild => $mcchild){
            if($menu == $mcchild['link']){
              $ulnya = "<ul class='treeview-menu' rel='open'>";
            }
            $link_sub_child = site_url($mcchild['link']);
            $linya .= <<<EOD
              <li><a href="{$link_sub_child}">&nbsp;&nbsp;&nbsp;&nbsp;{$mcchild['name']}</a>
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

                </section>
            </aside>
            <aside class="right-side">
                <?php
                if($this->session->flashdata('notice')){
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <b>Filed!</b> <?php print $this->session->flashdata('notice')?>.
                </div>
                <?php
                }
                if($this->session->flashdata('success')){
                ?>
                <div class="alert alert-success alert-dismissable">
                    <i class="fa fa-check"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <b>Success!</b> <?php print $this->session->flashdata('success')?>.
                </div>
                <?php
                }
                if($this->session->flashdata('extent')){
                ?>
                <div class="alert alert-warning alert-dismissable">
                    <i class="fa fa-warning"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <b>Warning!</b> <?php print $this->session->flashdata('extent')?>.
                </div>
                <?php
                }
                ?>
                <section class="content-header">
                    <h1>
                        <?php print $title?>
                        <small><?php print $title_small?></small>
                    </h1>
                    <ol class="breadcrumb">
                      <?php
                      foreach($breadcrumb AS $breadcrumb_key => $breadcrumb_value){
                        print "<li><a href='".site_url($breadcrumb_value)."'><i class='fa fa-dashboard'></i> {$breadcrumb_key}</a></li>";
                      }
                      ?>
                        <li class="active"><?php print $title?></li>
                    </ol>
                </section>
                <section class="content">
                  <div class="row">
                        <div class="col-md-12">
                            <div class="box box-solid">
                                <div class="box-body">
                                    Note : <span id="note_batch">Note</span> <br />
                                    Progress : <span id="prossess_batch">0</span><br />
                                    Total Post : <span id="total_batch"><?php print $total_pos?></span> <br />
                                    <span id="redirect_batch"></span>
                                    <div class="progress sm progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 0%" id="progress_bar_batch">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col (left) -->
                    </div>
                </section>
            </aside>
        </div>

        
        <script src="<?php print $url?>js/jquery.min.js"></script>
        <script src="<?php print $url?>js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <script src="<?php print $url?>js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php print $url?>js/AdminLTE/app.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8" src="<?php print $url?>js/simpletreemenu.js"></script>
        <script type="text/javascript">

        ddtreemenu.createTree("treemenu2", false);

        function hilang(id){
          $("#anak_hilang_"+id).fadeToggle();
        }

        </script>
        <?php print $template['body']?>
        <?php print $foot;?>
    </body>
</html>