<?php
use RedCore\Indoc\Collection as Indoc;
use RedCore\Request;
use RedCore\Where;
use RedCore\Users\Collection as Users;

Indoc::setObject("oindoc");

$lb_params = array(
    "id" => Request::vars("oindoc_id")
);

$item = Indoc::loadBy($lb_params);

Indoc::setObject("odoctypes");

$where = Where::Cond()->add("_deleted", "=", "0")->parse();

$DocTypes_list = Indoc::getList($where);

$doc_steps = Indoc::getRouteStatuses();

$user_roles = Users::getRolesList();

?>
<div class="row">
	<div class="col-md-12 col-sm-12 ">
		<div class="x_panel">
			<div class="x_title">
				<h2>
					ДОКУМЕНТЫ<small>форма просмотра</small>
				</h2>

				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="col-sm-12">
						<div class="card-box table-responsive">

							<ul class="nav nav-tabs" id="myTab" role="tablist">
								<li class="nav-item"><a class="nav-link active" id="home-tab"
									data-toggle="tab" href="#home" role="tab" aria-controls="home"
									aria-selected="true">Маршрут документа</a></li>
								<li class="nav-item"><a class="nav-link" id="profile-tab"
									data-toggle="tab" href="#profile" role="tab"
									aria-controls="profile" aria-selected="false">Просмотр</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="home" role="tabpanel"
									aria-labelledby="home-tab">
									<div class="row">
										<div class="col">
											<table border=1 id=""
												class="table table-striped table-bordered"
												style="width: 100%">
												<thead>
													<tr>
														<th>Шаг №</th>
														<th>Роль</th>
														<th>Статус</th>
													</tr>
												</thead>
												<tbody>
												<?php 
												$tstep = $item->object->step; // шаг документа
												$trole = $item->object->step_role; // роль для документа
												$t = Users::GetDocRoute($item->object->params->doctypes);
												foreach ($t as $key => $value) :
												    /*if ($value['role'] == $trole && $value['step'] == $tstep) {
												        echo '-> '.$key. ' '. $user_roles[$value['role']] . ' - ' . $doc_steps[$value['step']].'<br>';
												    }
												    else {
												        echo $key. ' '. $user_roles[$value['role']] . ' - ' . $doc_steps[$value['step']].'<br>';
												    } */
												
												?>
													<tr>
														<td><?= $key ?></td>
														<td><?= $user_roles[$value['role']] ?></td>
														<td><?= $doc_steps[$value['step']] ?></td>
													</tr>
													<?php endforeach;?>
												</tbody>
											</table>
										</div>
										<div class="col">sdfsdf</div>
									</div>
									<a class="btn btn-danger" href="/indocitems-list">Отмена</a>
								</div>
								<div class="tab-pane" id="profile" role="tabpanel"
									aria-labelledby="profile-tab">
									<table border=1 id="datatable"
										class="table table-striped table-bordered" style="width: 100%">
										<tbody>
											<tr>
												<td><b>Тип документа</b></td>
												<td><?= $DocTypes_list[$item->object->params->doctypes]->object->title ?></td>
											</tr>
											<tr>
												<td><b>Имя документа</b></td>
												<td><?= $item->object->name_doc ?></td>
											</tr>
											<tr>
												<td><b>№ Регистрации</b></td>
												<td><?= $item->object->reg_number ?></td>
											</tr>
											<tr>
												<td><b>Дата регистрации</b></td>
												<td><?= $item->object->reg_date ?></td>
											</tr>
											<tr>
												<td><b>Файл</b></td>
												<td><img
													src="<?= IMAGES . SEP . $item->object->params->file_title ?>"></td>
											</tr>
										</tbody>
									</table>
									<a class="btn btn-primary"
										href="/indocitems-form-addupdate?oindoc_id=<?=$item->object->id?>">Редактировать</a>
									<a class="btn btn-danger" href="/indocitems-list">Отмена</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>