<?php 
	use RedCore\Users\Collection as Users;
	use RedCore\Request as Request;
	use RedCore\Forms as Forms;
	use RedCore\Session as Session;

	$html_object = "user";
	
	$lb_params = array(
		"id" => Request::vars("user_id"),
	);
	
	Users::setObject("user");
	$item = Users::loadBy($lb_params);
	$item = $item->object;
	
	$params = array(
		"list" => Users::$roles	
	);

	//var_dump(Session::get("controller_user_auth"));
	//var_dump($_SESSION);
	$form = Forms::Create()
		->add("action",   "action",   "hidden", "action",                     $html_object. ".store.do",         6, false)
		->add("redirect", "redirect", "hidden", "redirect",                   "users-list",                       6, false)
		
		->add("id",       "Id",       "hidden", $html_object . "[id]",        htmlspecialchars($item->id),        6, false)
		->add("f",        "Фамилия",  "text",   $html_object . "[params][f]", htmlspecialchars($item->params->f), 6, true)
		->add("i",        "Имя",      "text",   $html_object . "[params][i]", htmlspecialchars($item->params->i), 6, true)

		->add("login",    "Логин",    "text",   $html_object . "[login]",     htmlspecialchars($item->login),     4, true)
		->add("password", "Пароль",   "text",   $html_object . "[password]",  htmlspecialchars($item->password),  4, true)
		->add("role",     "Роль",     "select", $html_object . "[role]",      htmlspecialchars($item->role),      4, true, $params)
		->parse();	
?>


<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>ПОЛЬЗОВАТЕЛИ<small>форма редактирования</small></h2>
        
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
          <div class="row">
          <div class="col-sm-12">
            <div class="card-box table-responsive">
                <?=$form?>
       		</div>
	  	  </div>
  		</div>
</div>
    </div>
  </div>
</div>

