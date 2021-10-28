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

  

  

  

  Indoc::setObject("odoctypes");



	$DocTypes = Indoc::getList($where);



	$DocTypesid = array();

	foreach ($DocTypes as $id => $temp) {

		$DocTypesid[$id] = $temp->object->id;

	}



	$DocTypesAcceess = Users::GetDocTypesByUser($DocTypesid);

	$DocTypesResult = array();

	//$DocTypesResult["list"][0] = "Не выбрано";

	foreach ($DocTypesAcceess as $key => $item) {

		if ($item) {

			$DocTypesResult[$key] = $DocTypes[$key]->object->title;

		}

	}

  

?>



<div class="container">

  <div class="row">

	<div class="x_panel">

		<div class="x_title">

		  <h2>Создание документов</h2>

		  <div class="clearfix"></div>

		</div>

		<div class="x_content">

		  <!--p>Add the class <code>.btn .btn-app</code> tag</p-->



			<?php

				foreach($DocTypesResult as $key => $item):

			?>

			

				<a style=" width: 100px; height: 120px" class="btn btn-app bg-gradient" href="/indocitems-form-addupdate?type=<?=$key?>">

					<i style="font-size: 3em; margin-bottom: 10px; color:#79dfc1 " class="fa fa-file-text"></i>

					<div style="font-size: 0.9em"><?=$item?></div>

			    </a>

				

			<?	

				endforeach;

			?>



		</div>

	  </div>







<div class="x_panel">

		<div class="x_title">

		  <h2>Моя аналитика</h2>

		  <div class="clearfix"></div>

		</div>

		<div class="x_content">

			

			<canvas style="max-width: 150px;" id="canvasDoughnut1" class="canvasDoughnut1"></canvas>



		</div>

</div>



<script>

jQuery(document).ready(function () {

	<?

		$all_docs = 50;

		$today = 5;

		$days3 = 10;

		$days7 = 15;

		$days30 = 20;

	?>

 

	var chart_doughnut_settings = {

            type: 'doughnut',

            tooltipFillColor: "rgba(51, 51, 51, 0.55)",

            data: {

                labels: [

                    "Документы",

                    "0",

                ],

                datasets: [{

                    data: [15, 85],

                    backgroundColor: [

                        "#BDC3C7",

                        "#9B59B6",

                    ],

                    hoverBackgroundColor: [

                        "#CFD4D8",

                        "#B370CF",

                    ]

                }]

            },

            options: {

                legend: false,

                responsive: true

            },

			centerText: {

				display: true,

				text: "280"

			}

        }



        jQuery('.canvasDoughnut1').each(function () {



            var chart_element = jQuery(this);

            var chart_doughnut = new Chart(chart_element, chart_doughnut_settings);



        }); 



		Chart.pluginService.register({

		  beforeDraw: function(chart) {

			var width = chart.chart.width,

				height = chart.chart.height,

				ctx = chart.chart.ctx;



			ctx.restore();

			var fontSize = (height / 114).toFixed(2);

			ctx.font = fontSize + "em sans-serif";

			ctx.textBaseline = "middle";



			var text = "75%",

				textX = Math.round((width - ctx.measureText(text).width) / 2),

				textY = height / 2;



			ctx.fillText(text, textX, textY);

			ctx.save();

		  }

		});



	  

});





</script>

  

  <style>

  .count {

    font-size: 60px;

    line-height: 67px;

    font-weight: 600;

	}

  </style>

  

  <div class="x_panel">

		<div class="x_title">

		  <h2>Мои документы</h2>

		  <div class="clearfix"></div>

		</div>

		<div class="x_content">

  

  
	<a href="/indocitems-list?my_doc_step=1">
    <div class="col-md-3 widget widget_tally_box">

		<div style="background-color: #311b92; min-height: 320px;" class="x_panel bg-gradient text-white">

		  <div class="x_title">

			<h2 style="font-size: 26px"><i class="fa fa-file-o"></i> Черновики</h2>

			<div class="clearfix"></div>

		  </div>

		  <div class="x_content">

		    <?php

				$doc_count = Indoc::NumberDocs(1, $user_role, $user_id);

			?>

			<h1 class="count" style="padding-right: 20px"><?=$doc_count?></h1>

			

			Подготовка и согласование проектов документов, подписание документов, формирование документов по шаблону, передача документов на рассмотрение, ознакомление и отправка 

		  </div>

		</div>

	</div>
	</a>
	
	<a href="/indocitems-list?my_doc_step=2">
	<div class="col-md-3 widget widget_tally_box">

		<div style="background-color: #0dcaf0; min-height: 320px;" class="x_panel bg-gradient text-white">

		  <div class="x_title">

			<h2 style="font-size: 26px"><i class="fa fa-file-o"></i> На согласовании</h2>

			<div class="clearfix"></div>

		  </div>

		  <div class="x_content">

		    <?php

				$doc_count = Indoc::NumberDocs(2, $user_role, $user_id);

			?>

			<h1 class="count" style=" padding-right: 20px"><?=$doc_count?></h1>

			

			Содержит перечень документов, отправленных или полученных для электронного согласования 

		  </div>

		</div>

	</div>
	</a>
	
	<a href="/indocitems-list?my_doc_step=3">
	<div class="col-md-3 widget widget_tally_box">

		<div style="background-color: #20c997;  min-height: 320px;"  class="x_panel bg-gradient text-white">

		  <div class="x_title">

			<h2 style="font-size: 26px"><i class="fa fa-file-o"></i> На утверждении</h2>

			<div class="clearfix"></div>

		  </div>

		  <div class="x_content">

		    <?php

				$doc_count = Indoc::NumberDocs(3, $user_role, $user_id);

			?>

			<h1 class="count" style=" padding-right: 20px"><?=$doc_count?></h1>

			

			Перечень переданных документов на утверждение 

		  </div>

		</div>

	</div>
	</a>
	
	<a href="/indocitems-list?my_doc_step=4">
	<div class="col-md-3 widget widget_tally_box ">

		<div style="background-color: #d63384;  min-height: 320px;"  class="x_panel bg-gradient text-white">

		  <div class="x_title">

			<h2 style="font-size: 26px"><i class="fa fa-file-o"></i> К принятию</h2>

			<div class="clearfix"></div>

		  </div>

		  <div class="x_content">

		    <?php

				$doc_count = Indoc::NumberDocs(4, $user_role, $user_id);

			?>

			<h1 class="count" style=" padding-right: 20px"><?=$doc_count?></h1>

			

			Перечень подготовленных документов для принятия в работу 

		  </div>

		</div>

	</div>
	</a>
	
	<a href="/indocitems-list?my_doc_step=0">
	<div class="col-md-3 widget widget_tally_box">

		<div style="background-color: #fd7e14;  min-height: 320px;"  class="x_panel bg-gradient text-white">

		  <div class="x_title">

			<h2 style="font-size: 26px"><i class="fa fa-file-o"></i> Хранилище</h2>

			<div class="clearfix"></div>

		  </div>

		  <div class="x_content">

		  <?php
				$doc_count = Indoc::NumberDocs(-1, $user_role, $user_id);
			?>
			<h1 class="count" style=" padding-right: 20px"><?= $doc_count ?></h1>

			

			Общее хранилище документов

		  </div>

		</div>

	</div>
	</a>
	</div>
	</div>
	</div>
  </div>