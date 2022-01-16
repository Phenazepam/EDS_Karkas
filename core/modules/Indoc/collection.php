<?php
/**
 * @copyright 2021
 * @author Darkas
 * @copyright REDUIT Co.
 */
namespace RedCore\Indoc;

use RedCore\Where as Where;
use RedCore\Files;
use RedCore\Session;
use RedCore\Controller;
use RedCore\Core as Core;
use RedCore\Request;
use RedCore\Users\Collection as Users;
use RedCore\Validator as Validator;

require_once ('sql.php');
require_once ('objectIndoc.php');
require_once ('objectDocTypes.php');
require_once ('objectDocLog.php');
require_once ('objectDocRoute.php');
require_once ('objectRelatedDocs.php');
require_once ('objectDocFile.php');
require_once ('objectRecognition.php');

class Collection extends \RedCore\Base\Collection
{

    private static $statuses = array(
        "0" => "Не выбран",

        "1" => "Черновик",
        "2" => "На согласовании",
        "3" => "На утверждении",
        "4" => "На принятии",
        "5" => "Утвержден",
        "6" => "Принят",
        "7" => "В архиве"
    );

    private static $routeStatuses = array(
        "1" => "Черновик",
        "2" => "Согласование",
        "3" => "Утверждение",
        "4" => "Принятие"
    );

    private static $actionDoc = array(
        "1" => "Черновик создан",
        "2" => "Черновик изменен",
        "3" => "Черновик удален",
        "4" => "Направлен на согласование",
        "5" => "Возврат на доработку",
        "6" => "Согласован",
        "7" => "Направлен на утверждение",
        "8" => "Утвержден",
        "9" => "Принят",
        "10" => "Документ просмотрен"
    );

    private static $relatedDocsReference = array(
        "1" => array(
            'name' => 'document',
            'reference' => '/indocitems-form-addupdate?oindoc_id=',
            'columnName' => 'name_doc',
        ),
        "2" => array(
            'name' => 'Контаргент',
            'reference' => '/infodocs-agentsform?oinfodocsagents_id=',
            'columnName' => 'name',
        ),
        "3" => array(
            'name' => 'Вид работ',
            'reference' => '/infodocs-worksform?oinfodocsworks_id=',
            'columnName' => 'name',
        ),
        "4" => array(
            'name' => 'Материал',
            'reference' => '/infodocs-materialsform?oinfodocsmaterials_id=',
            'columnName' => 'gruppa',
        ),
        "5" => array(
            'name' => 'Норма',
            'reference' => '/infodocs-standartsform?oinfodocsstandarts_id=',
            'columnName' => 'name',
        ),
        "6" => array(
            'name' => 'Ответственный',
            'reference' => '/users-form?user_id=',
            'columnName' => '-_-',
        ),
    );

    /**
     *
     * @method \RedCore\Base\Collection setObject()
     */
    public static function setObject($obj = "oindoc")
    {
        if ("oindoc" == $obj) {
            self::$object = "oindoc";
            self::$sql = Sql::$sqlIndoc;
            self::$class = "RedCore\Indoc\ObjectIndoc";
        } elseif ("odoctypes" == $obj) {
            self::$object = "odoctypes";
            self::$sql = Sql::$sqlDocTypes;
            self::$class = "RedCore\Indoc\ObjectDocTypes";
        } elseif ("odoclog" == $obj) {
            self::$object = "odoclog";
            self::$sql = Sql::$sqlDocLog;
            self::$class = "RedCore\Indoc\ObjectDocLog";
        } elseif ("odocroute" == $obj) {
            self::$object = "odocroute";
            self::$sql = Sql::$sqlDocRoute;
            self::$class = "RedCore\Indoc\ObjectDocRoute";
        } elseif ("orelateddocs" == $obj) {
            self::$object = "orelateddocs";
            self::$sql = Sql::$sqlRelatedDocs;
            self::$class = "RedCore\Indoc\objectRelatedDocs";
        } elseif ("odocfile" == $obj) {
            self::$object = "odocfile";
            self::$sql = Sql::$sqlDocFile;
            self::$class = "RedCore\Indoc\objectDocFile";
        }
        elseif ("orecognition" == $obj) {
            self::$object = "orecognition";
            self::$sql = Sql::$sqlRecognition;
            self::$class = "RedCore\Indoc\objectRecognition";
        }
    }

    /**
     *
     * @method \RedCore\Base\Collection loadBy()
     *        
     * @return \RedCore\Indoc\ObjectIndoc ObjectIndoc
     */
    public static function loadBy($params = array())
    {
        return parent::loadBy($params);
    }

    /**
     *
     * @method \RedCore\Base\Collection getList()
     *        
     * @return \RedCore\Base\ObjectBase ObjectBase
     */
    public static function getList($where = "")
    {
        return parent::getList($where);
    }

    public static function store($params = array())
    {
        if ("oindoc" == key($params)) {
            Users::setObject("user");
            $user_id = Users::getAuthId();
            $role_id = Users::getAuthRole();
            $file = $_FILES["oindoc"];
            if (!empty($params["oindoc"]["id"])) {
                if (1 == $params["oindoc"]["status"])
                self::registerDocLog($params["oindoc"]["id"], 2, "", $user_id);
                if ($file["tmp_name"]["file"] != "" ) {
                    self::storeFile($file, $params["oindoc"]["id"]);
                }
                parent::store($params);
                Controller::Redirect('/indocitems-form-view?oindoc_id='.$params["oindoc"]["id"].'&view');
            } else {
                self::setObject("oindoc");
                $lastId = parent::store($params)->object->id;
                self::registerDocLog($lastId, 1, "", $user_id);
                self::MoveRoute($lastId, $params['oindoc']['params']['doctypes'], $role_id, $user_id, '1', '1');
                if ($file["tmp_name"]["file"] != "" ) {
                    self::storeFile($file, $lastId);
                }
                // return;
                Controller::Redirect('/indocitems-form-view?oindoc_id='.$lastId.'&view');
            }
            self::setObject("oindoc");
        }
        return parent::store($params);
    }

    public static function delete($params = array())
    {
        if ("oindoc" == key($params)) {
            Users::setObject("user");
            $user_id = Users::getAuthId();
    
            if ($params["oindoc"]["id"]) {
                self::registerDocLog($params["oindoc"]["id"], 3, "", $user_id);
            }
            self::UnsetCurrentStep($params["oindoc"]["id"]);
            self::setObject("oindoc");
            parent::delete($params);
        }

        if ("odoctypes" == key($params)) {
            self::setObject("odoctypes");
            parent::delete($params);
        
        }
        if ("orelateddocs" == key($params)) {
            self::setObject("orelateddocs");
            parent::delete($params);
            var_dump($params);
            exit();
        }

    }

    public static function storeFile($file = -1, $doc_id = -1, $isForRecognition = 0, &$file_id = -1) {
        $out = array(
            'errorCode' => '0',
            'errorText' => ''
        );

        if (-1 == $file || -1 == $doc_id) return  
            array(
            'errorCode' => '1',
            'errorText' => 'Файл не выбран или не заполнен id документа'
        );

        $dir_prefix = $doc_id;

        $allowed_filetypes = array(
            'doc',
            'docx',
            'pdf',
            'xls',
            'xlsx',
            'txt',
            'jpeg',
            'jpg'
        );
        $filename = $file["tmp_name"]["file"];
        # Допустимый размер загружаемого файла
        $max_filesize = 13822880;
        # Директория для загрузки
        $upload_path = '../doc_files/';
        # Получаем расширение файла
        $extension = pathinfo($file['name']['file'], PATHINFO_EXTENSION);
        # Формируем имя файла
        $destination = $upload_path . $dir_prefix.'_'.
            Collection::getRandomFileName($upload_path, $extension) .
            '.'. $extension;
        if ($file['error']["file"]) {
            $out = array(
                'errorCode' => '2',
                'errorText' => 'Файл загружен с ошибками'
            );
        } elseif (!in_array($extension, $allowed_filetypes)) {
            $out = array(
                'errorCode' => '3',
                'errorText' => 'Некорректный формат файла'
            );
        } elseif ($file['size']['file'] > $max_filesize) {
            $out = array(
                'errorCode' => '3',
                'errorText' => 'Превышен максимальный размер файла'
            );
        } else {
            // var_dump($filename);
            // var_dump($destination);
            Users::setObject('user');
            $user_id = Users::getAuthId();
            if(move_uploaded_file($filename, $destination)) {
                self::setObject('odocfile');
                if (0 == $isForRecognition) {
                    self::UnsetCurrentDocFile($doc_id);
                    $params["odocfile"] = array(
                        'name' => $file['name']['file'],
                        'directory' => $destination,
                        'doc_id' => $doc_id,
                        'iscurrent' => 1,
                        'uploadedbyuser' => $user_id,
                        'for_recognition' => $isForRecognition,
                    );
                }
                else {
                    $params["odocfile"] = array(
                        'name' => $file['name']['file'],
                        'directory' => $destination,
                        'doc_id' => $doc_id,
                        'iscurrent' => 0,
                        'uploadedbyuser' => $user_id,
                        'for_recognition' => $isForRecognition,
                    );
                }
                $file_id = parent::store($params)->object->id;
            }
		}
        return $out;
    }
    private static function getRandomFileName($path, $extension='')
    {
        $extension = $extension ? '.' . $extension : '';
        $path = $path ? $path . '/' : '';
        do {
            $name = md5(microtime() . rand(0, 9999));
            $file = $path . $name . $extension;
        } while (file_exists($file));
        return $name;
    }
    private static function UnsetCurrentDocFile($doc_id = - 1)
    {
        if (- 1 == $doc_id)
            return;
        $sql = 'UPDATE `eds_karkas__docfile` SET iscurrent= 0 WHERE doc_id = ' . $doc_id;
        Core::$db->execute($sql);
    }


    public static function getStatuslist()
    {
        return self::$statuses;
    }

    public static function getRouteStatuses()
    {
        return self::$routeStatuses;
    }

    public static function registerDocLog($doc_id = '', $action = '', $comment = '', $user_id = '')
    {
        self::setObject("odoclog");

        $params["odoclog"] = array(
            'doc_id' => $doc_id,
            'action' => $action,
            'comment' => $comment,
            'user_id' => $user_id
        );
        // var_dump($params);
        self::store($params);
    }

    public static function ajaxRegisterDocLog($params = array())
    {
        if ((empty($params["doclog"]) or (is_null($params["doclog"]["id"]))))
            exit();
        $params = $params["doclog"];
        self::setObject("odoclog");
        $where = Where::Cond()
            ->add("doc_id", "=", $params["id"])
            ->parse();
        $data = self::getList($where);
        // var_dump(end($data));
        // var_dump($params["doclog"]["user_id"]);
        if ('10' == end($data)->object->action && $params["user_id"] == end($data)->object->user_id) {
            exit();
        }
        self::registerDocLog($params["id"], $params["action"], $params["comment"], $params["user_id"]);
        exit();
    }

    public static function getDocTypesList()
    {
        self::setObject("odoctypes");
        $where = Where::Cond()->add("_deleted", "=", "0")->parse();
        $list = self::getList($where);

        foreach ($list as $key => $value) {
            $res[$value->object->id] = $value->object->title;
        }
        return $res;
    }

    public static function MoveRoute($doc_id, $doc_type, $role_id, $user_id, $step, 
        $step_order, $isCurrent = '1', $comment = '', $isBack = '0', $isFinalStep = '0')
    {
        self::setObject("odocroute");
        $lb_params = array(
            'doc_id' => $doc_id,
            'iscurrent' => '1'
        );
        $item = self::loadBy($lb_params);

        Users::setObject("user");
        $current_user = Users::getAuthId();

        $current_step = $item->object->step;

        if (1 == $isFinalStep && 1 != $isBack) {
            if (3 == $current_step) {
                self::registerDocLog($doc_id, 8, $comment, $current_user);
                self::ChangeDocumentStatus($doc_id, 5);
            }
            if (4 == $current_step) {
                self::registerDocLog($doc_id, 9, $comment, $current_user);
                self::ChangeDocumentStatus($doc_id, 6);
            }
            self::setObject("odocroute");
            $params["odocroute"] = array(
                'id' => $item->object->id,
                'user_id' => $current_user,
                'iscurrent' => '0'
            );
            self::store($params);
        } 
        else {
            if ('1' == $isBack) {
                self::registerDocLog($doc_id, 5, $comment, $user_id);
            } else {

                if ('1' == $current_step && '2' == $step) {
                    self::registerDocLog($doc_id, 4, $comment, $current_user);
                }

                if ('2' == $current_step) {
                    self::registerDocLog($doc_id, 6, $comment, $current_user);
                }

                if ('3' == $current_step) {
                    self::registerDocLog($doc_id, 8, $comment, $current_user);
                }

                if ('2' == $current_step) {
                    self::registerDocLog($doc_id, 4, $comment, $current_user);
                }
                if ('3' == $current_step) {
                    self::registerDocLog($doc_id, 7, $comment, $current_user);
                }
            }

            self::setObject("odocroute");
            // self::UnsetCurrentStep($doc_id);
            $params["odocroute"] = array(
                'id' => $item->object->id,
                'user_id' => $current_user,
                'iscurrent' => '0'
            );
            // var_dump($params);
            // exit();
            self::store($params);

            $params["odocroute"] = array(
                'doc_id' => $doc_id,
                'doc_type' => $doc_type,
                'role_id' => $role_id,
                'user_id' => $user_id,
                'step' => $step,
                'step_order' => $step_order,
                'iscurrent' => $isCurrent
            );
            // var_dump($params["oindoc"]);
            self::store($params);

            switch ($step) {
                case 1:
                    self::ChangeDocumentStatus($doc_id, 1);
                    break;
                case 2:
                    self::ChangeDocumentStatus($doc_id, 2);
                    break;
                case 3:
                    self::ChangeDocumentStatus($doc_id, 3);
                    break;
                case 4:
                    self::ChangeDocumentStatus($doc_id, 4);
                    break;
            }
        }
    }

    public static function ajaxMoveRoute($params = array())
    {
        $file = $_FILES["oindoc"];
        // var_dump($file);
        $params = $params["oindoc"];

        Users::setObject('user');


        $doc_id = $params["id"];
        $doc_type = $params["doc_type"];
        $role_id = $params["step_role"];
        $user_id = $params["user_id"];
        $step = $params["step"];
        $step_order = $params["step_order"];
        $isFinalStep = $params["isFinalStep"];
        $isCurrent = '1';
        $comment = $params["comment"];

        $isBack = $params["isback"];

        if ($file["tmp_name"]["file"] != "") {
            $out = self::storeFile($file, $doc_id);
            if ($out["errorCode"] != 0) {
                echo json_encode($out);
            }
            else {
                echo json_encode($out);
                self::MoveRoute($doc_id, $doc_type, $role_id, $user_id, $step, $step_order, $isCurrent, $comment, $isBack, $isFinalStep);
            } 
        }  
        else {
            $out = array(
                'errorCode' => '0',
                'errorText' => ''
            );
            echo json_encode($out);
            self::MoveRoute($doc_id, $doc_type, $role_id, $user_id, $step, $step_order, $isCurrent, $comment, $isBack, $isFinalStep);
        }
        exit();
    }

    public static function ChangeDocumentStatus($doc_id, $status){
        $params["oindoc"] = array(
            'id' => $doc_id,
            'status' => $status,
        );
        self::setObject("oindoc");
        parent::store($params);
    }

    protected static function UnsetCurrentStep($doc_id = - 1)
    {
        if (- 1 == $doc_id)
            return;
        $sql = 'UPDATE `eds_karkas__docroute` SET iscurrent= 0 WHERE doc_id = ' . $doc_id;
        Core::$db->execute($sql);
    }

    public static function CanUserEditDocs($doc_id = -1, $user_role = -1, $user_id = -1) {
        if (-1 == $doc_id || -1 == $user_role  || -1 == $user_id ) return;

        self::setObject("oindoc");
		$document = self::loadBy(array('id' => $doc_id));
		if(5 == $document->object->status || 6 == $document->object->status) return false;
        
        self::setObject('odocroute');
        $lb_params = array(
            'doc_id' => $doc_id,
            'iscurrent' => '1'
        );
        $route = self::loadBy($lb_params);
        $route = $route->object;


        Users::setObject('user');
        $admin = Users::getAuthRole();
        if(2 == $admin || 1 == $admin) {
            return true;
        }

        if (1 == $route->step) {
            if (0 == $route->user_id) {
                if ($user_role == $route->role_id) {
                    return true;
                }
            }
            else {
                if ($user_id == $route->user_id) {
                    return true;
                }
            }
        }    
        return false; 
    }
    
   

    public static function NumberDocs($step = -1, $user_role, $user_id)
    {   
        
        self::setObject('odocroute');
        if ( -1 == $step) {
            $where = Where::Cond()
            ->add("_deleted", "=", "0")
            ->add("and")
            ->add("iscurrent", "=", "1")
            ->parse();
        } else {
            $where = Where::Cond()
            ->add("_deleted", "=", "0")
            ->add("and")
            ->add("iscurrent", "=", "1")
            ->add("and")
            ->add("step", "=", $step)
            ->parse();
        }
        $number = self::getList($where);
        
        $count = 0;
        foreach($number as $item) {
            $item = $item->object; 
            if (1 == $user_role || 2 == $user_role) {
                if (-1 == $step) {
                    $count++;
                }
                else if ($step  == $item->step) {
                    $count++;
                }
            }
            else {
                if (-1 == $step) {
                    if (0 == $item->user_id) {
                        if ($user_role == $item->role_id) {
                            $count++;
                        }
                    }
                    else {
                        if ($user_id == $item->user_id) {
                            $count++;
                        }
                    }
                }
                else if ($step  == $item->step) {
                    if (0 == $item->user_id) {
                        if ($user_role == $item->role_id) {
                            $count++;
                        }
                    }
                    else {
                        if ($user_id == $item->user_id) {
                            $count++;
                        }
                    }
                }
            }
        }
        return $count;
    }
    public static function GetAllDocsNumber()
    {   
        self::setObject('oindoc');
        $where = Where::Cond()
        ->add("_deleted", "=", "0")
        ->parse();
        $data = self::getList($where);
        $count = count((array)$data);
        return $count;
    }

    public static function AddRelatedDoc($params)
    {   
        $tmp = $params["relateddoc"];
        
        
        $doc_id = $tmp["doc_id"];
        $relateddoc_id = $tmp["relateddoc_id"];
        $type = $tmp["type"];

        $params["orelateddocs"] = array(
            'doc_id'=>$doc_id,
            'relateddoc_id' => $relateddoc_id,
            'type' => $type
        );
        // var_dump($params);
        // exit();
        self::setObject("orelateddocs");
        self::store($params);
        Controller::Redirect("/indocitems-form-addupdate?oindoc_id=".$doc_id);
    }

    public static function ajaxDeleteRelatedDoc($params)
    {   
        self::setObject("orelateddocs");
        self::delete($params);
        exit();
    }

    public static function getActionDoc()
    {
        return self::$actionDoc;
    }

    public static function GetProgressPercent($doc_id) {
        self::setObject("oindoc");
        $document = self::loadBy(array('id' => $doc_id));
        $document = $document->object;

        if (5 == $document->status || 6 == $document->status) return 100;
        
        Users::setObject("doctyperolematrix");
        $where = Where::Cond()
            ->add("_deleted", "=", "0")
            ->add("and")
            ->add("doctype", "=", $document->params->doctypes)
            ->parse();
        $steps = Users::getList($where);
        $step_count = count((array)$steps);

        self::setObject("odocroute");
        $lb_params = array(
            'doc_id' => $document->id,
            'iscurrent' => '1' 
        );
        $current_step = self::loadBy($lb_params);
        $current_step = $current_step->object;

        $percent = round(($current_step->step_order / ($step_count + 1))*100);

        return $percent;
    }

    public static function GetRelatedDocsReference(){
        return self::$relatedDocsReference;
    }
    
    public static function GetNameStatuses(){
        return self::$statuses;
    }
	
	public static function GetMyDocsInfo() {
		
		$user_id = Users::getAuthId();
		
		$where = $where = Where::Cond()
			->add("_deleted", "=", "0")
			->parse();
		
		self::setObject('odocroute');
		$docs = self::getList($where);

		$chern = 0;
		$sogl = 0;
		$utv = 0;
		$prin = 0;

		
		
				// sort by statuses
		foreach($docs as $item) {
			$user = $item->user_id ;
			$stp_ordr = $item->step_order;
			
			if ($user == $user_id) {
				if ( $stp_ordr == 1 ) {
					$chern++;
				}
				if ( $stp_ordr == 2 ) {
					$sogl++;
				}
				if ( $stp_ordr == 3 ) {
					$utv++;
				}
				if ( $stp_ordr == 4 ) {
					$prin++;
				}
			}
		}
		

		$retResult = array();
		$retResult[0] = (string) $chern;
		$retResult[1] = (string) $sogl;
		$retResult[2] = (string) $utv;
		$retResult[3] = (string) $prin;


		return $retResult;
	}
	
	public static function getRegNumber() {
		$where = Where::Cond()
			->add("_deleted", "=", "0")
			->parse();


		// get table oindoc
		self::setObject("oindoc");
		$docs = self::getList();

		// get registration numbers from table
		$a = array();
		foreach($docs as $item) {
			$c = $item->object->reg_number;
			array_push($a, $c);
		}

		//searching max value and increment it
		$max = max($a);
		$new_number = $max +1;
		$stringNewNum = (string) $new_number;


		return $stringNewNum;
	}		

    public static function GetMyDocs($user_id, $status = -1) {
        self::setObject("odocroute");
        $where = Where::Cond()
            ->add("_deleted", "=", "0")
            ->add("and")
            ->add("user_id", "=", $user_id)
            ->add("and")
            ->add("step_order", "=", 1)
            ->parse();
        $routes = self::getList($where);
        // var_dump($routes);

        self::setObject("oindoc");
        if (-1 == $status) {
            $where = Where::Cond()
                ->add("_deleted", "=", "0")
                ->parse();
        }
        else {
            $where = Where::Cond()
            ->add("_deleted", "=", "0")
            ->add("and")
            ->add("status", "=", $status)
            ->parse();
        }
        $documents = self::getList($where);

        
        if (5 == $status || 6 == $status) {
            return $documents;
        }

        foreach($routes as $key => $route) {
            if (isset($documents[$route->object->doc_id]) 
                && $documents[$route->object->doc_id]->object->status != 5
                && $documents[$route->object->doc_id]->object->status != 6)
            $result[$route->object->doc_id] = $documents[$route->object->doc_id];
        }

        return $result;
    }

    public static function GetInDocs($user_id, $user_role, $status = -1) {
        self::setObject("odocroute");
        $where = Where::Cond()
            ->add("_deleted", "=", "0")
            ->add("and")
            ->add("iscurrent", "=", 1)
            ->add("and")
            ->add("role_id", "=", $user_role)
            ->parse();
        $routes = self::getList($where);

        self::setObject("oindoc");
        if (-1 == $status) {
            $where = Where::Cond()
                ->add("_deleted", "=", "0")
                ->parse();
        }
        else {
            $where = Where::Cond()
            ->add("_deleted", "=", "0")
            ->add("and")
            ->add("status", "=", $status)
            ->parse();
        }
        $documents = self::getList($where);

        foreach ($routes as $key => $item) {
            $item = $item->object;
            
            if ($user_id == $item->user_id || (0 == $item->user_id && $user_role == $item->role_id)) {
                if (isset($documents[$item->doc_id])
                    && $documents[$item->doc_id]->object->status != 1
                    && $documents[$item->doc_id]->object->status != 5
                    && $documents[$item->doc_id]->object->status != 6) {
                    $result[$item->doc_id] = $documents[$item->doc_id];
                }
            }   
        }
        return $result;
    }

    public static function GetApprovedDocs() {    
        self::setObject("oindoc");
        $where = Where::Cond()
            ->add("_deleted", "=", "0")
            ->add("and")
            ->add("status", "=", 5)
            ->parse();
        $where1 = Where::Cond()
            ->add("_deleted", "=", "0")
            ->add("and")
            ->add("status", "=", 6)
            ->parse();
        
        $documents = array_merge(self::getList($where), self::getList($where1));

        self::setObject("odoctypes");
            $where = Where::Cond()
            ->add("_deleted", "=", "0")
            ->parse();
        $DocTypes_list = self::getList($where);
        $DocTypesid = array();
        foreach ($DocTypes_list as $id => $temp) {
            $DocTypesid[$id] = $temp->object->id;
        }

        $read_doc = Users::CanUserReadDocs($DocTypesid);
        foreach ($documents as $item) {
            if ($read_doc[$item->object->params->doctypes]) {
              $tmp[] = $item;
            }
          }
        $documents = $tmp;
        
        return $documents;
    }

    public static function GetDelayedDocs($fromDate = -100, $dueDate = -7) {    
        self::setObject("oindoc");
        $where = Where::Cond()
            ->add("_deleted", "=", "0")
            ->add("and")
            ->add("status", "not in", '(5, 6)')
            ->parse();
        
        $documents = self::getList($where);

        self::setObject("odoclog");
            $where = Where::Cond()
            ->add("_deleted", "=", "0")
            ->parse();
        $logs = self::getList($where);

        $fromDate = date('Y-m-d', strtotime($fromDate.' day', strtotime(date('Y-m-d'))));
        $dueDate = date('Y-m-d', strtotime($dueDate.' day', strtotime(date('Y-m-d'))));

        // var_dump($fromDate);
        // var_dump($dueDate);

        foreach($logs as $item) {
            $item = $item->object;
            if (!is_null($documents[$item->doc_id])) {
                $prepared[$item->doc_id] = -1;
                $prepared[$item->doc_id] 
                = $prepared[$item->doc_id] < strtotime($item->_updated) ? strtotime($item->_updated) : 
                $prepared[$item->doc_id];
            }
        }
        $res=0;
        foreach ($prepared as $key => $item) {
            if (date('Y-m-d', $item) >= $fromDate && date('Y-m-d', $item) <= $dueDate) {
                // var_dump($key);
                $res++;
            }
        }

        return $res;
    }


    /**
     * --------------------------
     * Recoginition
     * ----------------------------
     */

    public static function ajaxRecStoreFile($params){
        $file = $_FILES["orecognition"];
        $params = $params["orecognition"];
        $doc_id = $params["doc_id"];
        $file_id = -1;

        self::storeFile($file, $doc_id, 1, $file_id);
        $out = array(
           "file_id" => $file_id
        );
        echo json_encode($out); 
        exit();
    }

    public static function ajaxGetBase64($params){
        $file_id = $params['orecognition']['file_id'];
        self::setObject("odocfile");
        $lb_params = array(
            "id" => $file_id
        );
        
        $item = self::loadBy($lb_params);
        
        $directory = $item->object->directory;
        
        $file = file_get_contents($directory);
        // var_dump($file);
        $out = array(
            'file' => base64_encode($file)
        );
        echo json_encode($out);
        // $myCurl = curl_init();
        // curl_setopt_array($myCurl, array(
        //     CURLOPT_URL => 'http://176.119.159.70/recognaize',
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_POST => true,
        //     CURLOPT_POSTFIELDS => json_encode(array(array(
        //         "file"=> base64_encode($file),
        //         "id" => "1",
        //         "extension"=> "JPG",
        //         "id_file"=> "1")))
        // ));
        // print_r(json_encode(array(array(
        //     "file"=> base64_encode($file),
        //     "id" => "1",
        //     "extension"=> "JPG",
        //     "id_file"=> "1"))));
        // $response = curl_exec($myCurl);
        // curl_close($myCurl);
        // var_dump($response);
        exit();
    }

    public static function ajaxStoreRecognition($params) {
        
        $params = $params["orecognition"];
        $doc_id = $params['doc_id'];
        $file_id = $params['file_id'];
        $rec_text = $params['rec_text'];

        self::setObject("orecognition");
        $params['orecognition'] = array(
            'doc_id' => $doc_id,
            'file_id' => $file_id,
            'rec_text' => $rec_text
        );
        $res = self::store($params);
        if(!is_null($res)) {
            echo json_encode(array('result' => '0'));
        }
        else {
            echo json_encode(array('result' => '-1'));
        }
        exit();
    }

    public static function ajaxStoreRecognitionFromBase64($params = null) {
        
        $params = $params["orecognition"];
        $doc_id = $params['doc_id'];
        $base_text = $params['base_text'];
        $extension = $params['extension'];
        $source_file_id = $params['source_file_id'];
        $upload_path = '../doc_files/';

        $filename = $doc_id.'_rec.'.$extension;

        $data = base64_decode($base_text);

        $rand = $upload_path.$doc_id.'_'.self::getRandomFileName($filename, $extension) .
        '.'. $extension;
        
        $ifp = fopen($rand, "w+" ); 
        fwrite( $ifp,  $data ); 
        fclose( $ifp ); 

        Users::setObject('user');
        $user_id = Users::getAuthId();

        $params["odocfile"] = array(
            'name' => $filename,
            'directory' => $rand,
            'doc_id' => $doc_id,
            'iscurrent' => 0,
            'uploadedbyuser' => $user_id,
            'for_recognition' => 2,
        );
    
        self::setObject('odocfile');
        $file_id = parent::store($params)->object->id;

        $params['orecognition'] = array(
            'doc_id' => $doc_id,
            'file_id' => $source_file_id,
            'rec_text' => '',
            'recognized_file_id' => $file_id
        );
        self::setObject("orecognition");
        $res = self::store($params);
        if(!is_null($res)) {
            echo json_encode(array('result' => '0'));
        }
        else {
            echo json_encode(array('result' => '-1'));
        }
        exit();
        
    }
}

?>