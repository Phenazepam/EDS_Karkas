<?php

  use RedCore\Users\Collection as Users;
  use RedCore\Indoc\Collection as Indoc;

  Users::setObject("user");
  $c_user = Users::getAuthToken();
  $user_role = Users::getAuthRole();
  $user_id = Users::getAuthId();

  $lb_params = array(
	"token_key" => $c_user
  );

  $c_user = Users::loadBy($lb_params);
?>

<div class="container">
  <div class="row">
	<div class="x_panel">
		<div class="x_title">
		  <h2>Мои документы</h2>
		  <!--ul class="nav navbar-right panel_toolbox">
			<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
			</li>
			<li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i
				  class="fa fa-wrench"></i></a>
			  <ul class="dropdown-menu" role="menu">
				<li><a href="#">Settings 1</a>
				</li>
				<li><a href="#">Settings 2</a>
				</li>
			  </ul>
			</li>
			<li><a class="close-link"><i class="fa fa-close"></i></a>
			</li>
		  </ul-->
		  <div class="clearfix"></div>
		</div>
		<div class="x_content">
		  <!--p>Add the class <code>.btn .btn-app</code> tag</p-->

		  
		  <a class="btn btn-app" href="/indocitems-list-draft">
			<?php
				$doc_count = Indoc::NumberDocs(1,  $user_role, $user_id);
				$class = "bg-green";
				
				if(0 < (int)$doc_count) {
					$class = "bg-red";
				}
				elseif(0 == (int)$doc_count){
					$class = "bg-green";
				}
			?>
			<span class="badge <?=$class?>"><?=$doc_count?></span>
			<i class="fa fa-file"></i> Черновики
		  </a>
		  
		   <a class="btn btn-app" href="/indocitems-list-agreement">
			<?php
				$doc_count = Indoc::NumberDocs(2,  $user_role, $user_id);
				$class = "bg-green";
				
				if(0 < (int)$doc_count) {
					$class = "bg-red";
				}
				elseif(0 == (int)$doc_count){
					$class = "bg-green";
				}
			?>
			<span class="badge <?=$class?>"><?=$doc_count?></span>
			<i class="fa fa-file-o"></i> На согласование
		  </a>
		  
		   <a class="btn btn-app" href="/indocitems-list-approval">
			<?php
				$doc_count = Indoc::NumberDocs(3,  $user_role, $user_id);
				$class = "bg-green";
				
				if(0 < (int)$doc_count) {
					$class = "bg-red";
				}
				elseif(0 == (int)$doc_count){
					$class = "bg-green";
				}
			?>
			<span class="badge <?=$class?>"><?=$doc_count?></span>
			<i class="fa fa-file-text"></i> На утверждение
		  </a>
		  
		   <a class="btn btn-app" href="/indocitems-list-adoption">
			<?php
				$doc_count = Indoc::NumberDocs(4,  $user_role, $user_id);
				$class = "bg-green";
				
				if(0 < (int)$doc_count) {
					$class = "bg-red";
				}
				elseif(0 == (int)$doc_count){
					$class = "bg-green";
				}
			?>
			<span class="badge <?=$class?>"><?=$doc_count?></span>
			<i class="fa fa-file-text-o"></i> На принятие
		  </a>
		  
		</div>
	  </div>

	</div>
  
    <div class="col-md-3   widget widget_tally_box">
		<div class="x_panel">
		  <div class="x_title">
			<h2>Черновики</h2>
			<ul class="nav navbar-right panel_toolbox">
			  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
			  </li>
			  <li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item" href="#">Settings 1</a>
					<a class="dropdown-item" href="#">Settings 2</a>
				  </div>
			  </li>
			  <li><a class="close-link"><i class="fa fa-close"></i></a>
			  </li>
			</ul>
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">

			<div style="text-align: center; margin-bottom: 17px">
			  <span class="chart" data-percent="86">
								  <span class="percent"></span>
			  </span>
			</div>

			<div class="pie_bg" style="text-align: center; display: none; margin-bottom: 17px">
			  <canvas id="canvas_doughnut" height="130"></canvas>
			</div>

			<div style="text-align: center;">
			  <div class="btn-group" role="group" aria-label="First group">
				<button type="button" class="btn btn-default btn-sm">1 D</button>
				<button type="button" class="btn btn-default btn-sm">1 W</button>
				<button type="button" class="btn btn-default btn-sm">1 M</button>
				<button type="button" class="btn btn-default btn-sm">1 Y</button>
			  </div>
			</div>
			<div style="text-align: center; overflow: hidden; margin: 10px 5px 3px;">
			  <canvas id="canvas_line" height="190"></canvas>
			</div>
			<div>
			  <ul class="list-inline widget_tally">
				<li>
				  <p>
					<span class="month">12 December 2014 </span>
					<span class="count">+12%</span>
				  </p>
				</li>
				<li>
				  <p>
					<span class="month">29 December 2014 </span>
					<span class="count">+12%</span>
				  </p>
				</li>
				<li>
				  <p>
					<span class="month">16 January 2015 </span>
					<span class="count">+12%</span>
				  </p>
				</li>
			  </ul>
			</div>
		  </div>
		</div>
	  </div>
  </div>
</div>