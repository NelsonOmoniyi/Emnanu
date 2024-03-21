<?php
require_once('libs/dbfunctions.php');
require_once('class/menu.php');
if(!isset($_SESSION['username_sess']))
{
    header('location: logout.php');
}
$dbobject = new dbobject();
$menu = new Menu();
$menu_list = $menu->generateMenu($_SESSION['role_id_sess']);
$menu_list = $menu_list['data'];


$sql = "SELECT firstname,lastname FROM userdata WHERE username = '$_SESSION[username_sess]' LIMIT 1 ";
$user_det = $dbobject->db_query($sql);

$sqlDon    = "SELECT amount FROM transactions WHERE status = '1' ";
	$result = $dbobject->db_query($sqlDon);
	$count0 = count($result);

	$sqlm    = "SELECT * FROM message";
	$resultm = $dbobject->db_query($sqlm);
	// var_dump($resultm);

?>
<!DOCTYPE html>
<html lang="en">



<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Admin Dashboard">
	<meta name="author" content="NelsonOmoniyi">

	<title>Admin </title>
	
	<link rel="preconnect" href="http://fonts.gstatic.com/" crossorigin>

	<style>
		body {
			opacity: 0;
		}
	</style>
	
	<script src="js/jquery.min.js"></script>
	<script src="js/settings.js"></script>
	
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-120946860-6');
</script></head>

<body>
	<div class="wrapper">
		<nav class="sidebar">
			<div class="sidebar-content ">
				<a class="sidebar-brand bg-white" href="home.php">
          <i class="align-middle" data-feather="box"></i>
          <span class="align-middle text-dark" style="font-size: 15px; font-weight:bold;">Emnanu</span>
        </a>
<!--     side tab     -->

<hr style="margin-top:0px;">
				<ul class="sidebar-nav">
					
					
					<h3><a href="home.php" class="sidebar-header text-white font-weight-bold text-lg ">Dashboard</a></h3>
					
					<hr>
					<?php
                        foreach($menu_list as $row)
                        {
                        ?>
                            <a href="#k<?php echo $row['menu_id']; ?>" data-toggle="collapse" class="sidebar-link">
                                <i class="align-middle" data-feather="sliders"></i> <span class="align-middle"><?php echo $row['menu_name']; ?></span>
                            </a>
						<?php
                            if($row['has_sub_menu'] == true)
                                {
									echo '<ul id="k'.$row['menu_id'].'"  class="sidebar-dropdown list-unstyled collapse">';
									foreach($row['sub_menu'] as $row2)
                                {
                                    if($row2['menu_id'] == "026")
                                {
                              
                        ?>
							<li class="sidebar-item"><a class="sidebar-link" href="javascript:getpage('<?php echo $row2['menu_url']; ?>','page')"><?php echo $row2['name']; ?></a>
							</li>
						<?php

							}
							else
							{

						?>
							<li class="sidebar-item">
                                <a class="sidebar-link" href="javascript:getpage('<?php echo $row2['menu_url']; ?>','page')">
                                <?php echo $row2['name']; ?>
                               	</a>
                            </li>
						<?php
                        }
                        }
                        	echo '</ul>';
                        }
                        ?>
                        <?php
                        }
                        ?>



				</ul>

				<div class="sidebar-bottom d-none d-lg-block">
					<div class="media">
						<img class="rounded-circle mr-3" src="img/avatars/avatar.jpg" width="40" height="40">
						<div class="media-body">
							<h5 class="mb-1"><?php echo $_SESSION['firstname_sess'].' '.$_SESSION['lastname_sess']; ?></h5>
							<div>
                                <button class="btn btn-danger btn-block" onclick="window.location='logout.php'">Logout</button>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light bg-white">
				<a class="sidebar-toggle d-flex mr-2">
          <i class="hamburger align-self-center"></i>
        </a>

				<a href="javascript:void(0)" class="d-flex mr-2">
                   <?php $state_loc = ":".$dbobject->getitemlabel('lga','stateid',$_SESSION['state_id_sess'],'State'); ?>
                    Your Role: &nbsp; <span style="font-weight:bold; color:#000"><?php echo $_SESSION['role_id_name'];"</small>"; ?></span>
                </a>
				&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&copy; <?php echo date('Y');?> <strong><span>Emnanu Foundation</span></strong>
				<div class="navbar-collapse collapse">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-toggle="dropdown">
                <i class="align-middle" data-feather="settings"></i>
              </a>

			  <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-toggle="dropdown">
                <img src="img/avatars/avatar.jpg" class="avatar img-fluid rounded-circle mr-1" alt="<?php echo $_SESSION['firstname_sess'].' '.$_SESSION['lastname_sess']; ?>"/> <span class="text-dark"><?php echo $_SESSION['firstname_sess'].' '.$_SESSION['lastname_sess']; ?></span>
              </a>
							<div class="dropdown-menu dropdown-menu-right">
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="logout.php">Sign out</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>

			<main class="content" id="page">
				<div class="container-fluid p-0">

					<div class="row">
						<div class="col-6  d-flex">
							<div class="card flex-fill">
								<div class="card-body py-4">
									<div class="media">
										<div class="d-inline-block mt-2 mr-3">
											<i class="feather-lg text-success" data-feather="check-square"></i>
										</div>
										<div class="media-body">
											<?php
												echo '<h3 class="mb-2">'.$count1.'</h3>';
											?>
											<!-- <h3 class="mb-2">2.562</h3> -->
											<div class="mb-0">Scholarship Applicants</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-6 d-flex">
							<div class="card flex-fill">
								<div class="card-body py-4">
									<div class="media">
										<div class="d-inline-block mt-2 mr-3">
										<i class="feather-lg text-warning" data-feather="activity"></i>
										</div>
										<div class="media-body">

											<?php
												echo '<h3 class="mb-2">'.$count0.'</h3>';
											?>
											<div class="mb-0">Donations Made</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
						<br>
					<div class="row">
						<div class=" col-lg-12 d-flex">
							<div class="card flex-fill w-100">
								<div class="card-header">
									<!-- <span class="badge badge-info float-right">Today</span> -->
									<h5 class="card-title mb-0">Messages</h5>
								</div>
								<div class="card-body">
									<div class="media">
										<div class="media-body">
											<?php foreach ($resultm as $i) {?>
												<strong> <?php echo $i['fullname'] ?> </strong> said <strong>..........</strong><br />
												<small class="text-muted"><?php echo $i['date'] ?> </small>
												
												<p><?php echo '"'.$i['message'].'"' ?></p>
												
												<strong> Contact Details </strong>
												<p class="text-muted"><?php echo $i['email']?> </p>
												<p class="text-muted"><?php echo $i['phone']?> </p><br />
												<hr>
											<?php } ?>
											
										</div>
									</div>
									<hr />
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>

			<!-- <footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted ">
						<div class="col-6 text-left">
							<ul class="list-inline">
							<li class="list-inline-item"><i class="text-muted"></i> <a href="../work.php">How We Work</a></li>
							<li class="list-inline-item"><i class="text-muted"></i> <a href="../strategy.php">Our Strategy</a></li>
							<li class="list-inline-item"><i class="text-muted"></i> <a href="../fund.php">What We Fund</a></li>
							<li class="list-inline-item"><i class="text-muted"></i> <a href="../index.php">Home</a></li>
								
							</ul>
						</div>
						<div class="col-6 text-right">
							<p class="mb-0">
							
							</p>
						</div>
					</div>
				</div>
			</footer> -->
		</div>
	</div>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="defaultModalPrimary" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="modal_div">
            <div class="modal-header">
            <h4 class="modal-title" style="font-weight:bold"><?php echo ($operation=="edit")?"Edit ":""; ?> Setup<div><small style="font-size:12px">All asterik fields are compulsory</small></div></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              
            </div>
            
            </div>
        </div>
        </div>
    </div>

	<!-- large modal -->
	<div class="modal fade" id="defaultModallarge" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="modal_div2">
            <div class="modal-header">
            <h4 class="modal-title" style="font-weight:bold"><?php echo ($operation=="edit")?"Edit ":""; ?> Setup<div><small style="font-size:12px">All asterik fields are compulsory</small></div></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              
            </div>
            
            </div>
        </div>
        </div>
    </div>

	
	<script src="js/app.js"></script>
	<script src="js/parsely.js"></script>
	
	<script src="js/sweet_alerts.js"></script>
	<script src="js/main.js"></script>
    <script src="js/jquery.blockUI.js"></script>
	
	

	
<script>
	function year() {
		NOW();
	}
</script>
</body>

</html>