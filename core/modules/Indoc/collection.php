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
require_once ('sql.php');
require_once ('objectIndoc.php');
require_once ('objectDocTypes.php');
require_once ('objectDocLog.php');
require_once ('objectDocRoute.php');

class Collection extends \RedCore\Base\Collection
{

    private static $list = array(
        "0" => "Не выбран",

        "1" => "Черновик",
        "2" => "Зарегистрирован",
        "3" => "Предварительное рассмотрение",
        "4" => "Рассмотрение",
        "5" => "Исполнение",
        "6" => "В деле",
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
            if ($title = Files::upload("oindoc", "file")) {
                $params["oindoc"]["params"]["file_title"] = $title;
            }
            if (! empty($params["oindoc"]["id"])) {
                self::registerDocLog($params["oindoc"]["id"], 2, "", $user_id);
            } else {
                self::setObject("oindoc");
                $lastId = parent::store($params)->object->id;
                self::registerDocLog($lastId, 1, "", $user_id);
                self::MoveRoute($lastId, $params['oindoc']['params']['doctypes'], $role_id, $user_id, '1', '1');

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
            self::setObject("oindoc");
    
            parent::delete($params);
        }

        if ("odoctypes" == key($params)) {
            self::setObject("odoctypes");
            parent::delete($params);
        }

    }

    public static function getStatuslist()
    {
        return self::$list;
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
        $where = Where::Cond()->add("doc_id", "=", $params["id"])->parse();
        $data = self::getList($where);
        // var_dump(end($data));
        if ('10' == end($data)->object->action) {
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

    public static function MoveRoute($doc_id, $doc_type, $role_id, $user_id, $step, $step_order, $isCurrent = '1', $comment = '', $isBack = '0')
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
        if ('1' == $isBack) {
            self::registerDocLog($doc_id, 5, $comment, $user_id);
        } else {

            if ('1' == $current_step && '2' == $step) {
                self::registerDocLog($doc_id, 4, $comment, $user_id);
            }

            if ('2' == $current_step) {
                self::registerDocLog($doc_id, 6, $comment, $user_id);
            }

            if ('3' == $current_step) {
                self::registerDocLog($doc_id, 8, $comment, $user_id);
            }

            if ('2' == $current_step) {
                self::registerDocLog($doc_id, 4, $comment, $user_id);
            }
            if ('3' == $current_step) {
                self::registerDocLog($doc_id, 7, $comment, $user_id);
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
    }

    public static function ajaxMoveRoute($params = array())
    {
        $params = $params["oindoc"];

        Users::setObject('user');

        $doc_id = $params["id"];
        $doc_type = $params["doc_type"];
        $role_id = $params["step_role"];
        $user_id = $params["user_id"];
        $step = $params["step"];
        $step_order = $params["step_order"];
        $isCurrent = '1';
        $comment = $params["comment"];

        $isBack = $params["isback"];

        self::MoveRoute($doc_id, $doc_type, $role_id, $user_id, $step, $step_order, $isCurrent, $comment, $isBack);
        exit();
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

        Users::setObject('user');
        $admin = Users::getAuthRole();
        
        if(2 == $admin) {
            return true;
        }
        
        self::setObject('odocroute');
        $lb_params = array(
            'doc_id' => $doc_id,
            'iscurrent' => '1'
        );
        $route = self::loadBy($lb_params);
        $route = $route->object;
        
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

    public static function getActionDoc()
    {
        return self::$actionDoc;
    }
}
?>