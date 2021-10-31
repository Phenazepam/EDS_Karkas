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
            'name' => 'infodocsagents',
            'reference' => '/infodocs-agentsform?oinfodocsagents_id=',
            'columnName' => 'name',
        ),
        "3" => array(
            'name' => 'infodocsworks',
            'reference' => '/infodocs-worksform?oinfodocsworks_id=',
            'columnName' => 'name',
        ),
        "4" => array(
            'name' => 'infodocsmaterials',
            'reference' => '/infodocs-materialsform?oinfodocsmaterials_id=',
            'columnName' => 'gruppa',
        ),
        "5" => array(
            'name' => 'infodocsstandarts',
            'reference' => '/infodocs-standartsform?oinfodocsstandarts_id=',
            'columnName' => 'name',
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
            } else {
                self::setObject("oindoc");
                $lastId = parent::store($params)->object->id;
                self::registerDocLog($lastId, 1, "", $user_id);
                self::MoveRoute($lastId, $params['oindoc']['params']['doctypes'], $role_id, $user_id, '1', '1');
                if ($file["tmp_name"]["file"] != "" ) {
                    self::storeFile($file, $lastId);
                }
                return;
            }
            self::setObject("oindoc");
        }
        parent::store($params);
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

    public static function storeFile($file = -1, $doc_id = -1) {
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
            'txt'
        );
        $filename = $file["tmp_name"]["file"];
        # Допустимый размер загружаемого файла
        $max_filesize = 1382288;
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
                self::UnsetCurrentDocFile($doc_id);
                $params["odocfile"] = array(
                    'name' => $file['name']['file'],
                    'directory' => $destination,
                    'doc_id' => $doc_id,
                    'iscurrent' => 1,
                    'uploadedbyuser' => $user_id
                );
                self::store($params);
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
        self::store($params);
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
	
	public static function GetMyDocsInfo($step) {
				
				
		Users::setObject("user");
		$user_id = Users::getAuthId();
		
		$mydocs = self::GetMyDocs($user_id, $step);
		$count = 1;
		foreach ($mydocs as $item ) {
			$count = $count + 1;
		}

		return $count;
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

        foreach($routes as $key => $route) {
            if (isset($documents[$route->object->doc_id]))
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
                if (isset($documents[$item->doc_id])) {
                    $result[$item->doc_id] = $documents[$item->doc_id];
                }
            }   
        }
        return $result;
    }
}
?>