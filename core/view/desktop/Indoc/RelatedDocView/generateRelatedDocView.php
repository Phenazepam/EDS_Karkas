<?php

use RedCore\Request;
use RedCore\Where;
use RedCore\Indoc\Collection as Indoc;
use RedCore\Users\Collection as Users;
use RedCore\Session as Session;
use RedCore\Infodocs\Collection as Infodocs;

$doc_id = Session::get("s_relateddoc_id");

$where = $where = Where::Cond()
    ->add("_deleted", "=", "0")
    ->add("and")
    ->add("doc_id", "=", $doc_id)
    ->add("and")
    ->add("type", "=", 1)
    ->parse();

if (0 != $doc_id) {
    Indoc::setObject("orelateddocs");
    $relateddocs = Indoc::getList($where);
}
$where = $where = Where::Cond()
    ->add("_deleted", "=", "0")
    ->add("and")
    ->add("doc_id", "=", $doc_id)
    ->add("and")
    ->add("type", "!=", 1)
    ->parse();

if (0 != $doc_id) {
    Indoc::setObject("orelateddocs");
    $attributes = Indoc::getList($where);
}

Indoc::setObject("oindoc");
$docs = Indoc::getList();

Infodocs::setObject("oinfodocsagents");
$info_agents = Infodocs::getList();

Infodocs::setObject("oinfodocsworks");
$info_works = Infodocs::getList();

Infodocs::setObject("oinfodocsmaterials");
$info_materials = Infodocs::getList();

Infodocs::setObject("oinfodocsstandarts");
$info_standarts = Infodocs::getList();

Users::setObject("user");
$users = Users::getList();

$all["1"] = $docs;
$all["2"] = $info_agents;
$all["3"] = $info_works;
$all["4"] = $info_materials;
$all["5"] = $info_standarts;
$all["6"] = $users;

// var_dump($all["1"]);

$ref = Indoc::GetRelatedDocsReference();

$flag = false;

$r = '<script src="/core/view/desktop/Indoc/js/popupAddingRelatedDoc.js"></script>
    <div class="row form-group">
    <div class="col col-md-12">';
    $r .= '<label for="reg_date" class="form-control-label">
        Связанные документы</label></div>';
    $r .= '<div id="tags_1_tagsinput" class="form-control col col-md-12" style="width: 100%; min-height: 100px; height: 100px;">';
    foreach ($relateddocs as $key => $item) {
        $item = $item->object;
        $name = (string)$ref[$item->type]["columnName"];
        $reference = $ref[$item->type]["reference"] . $item->relateddoc_id;
        $r .= '
                <span class="tag">
                    <span><a href="'.$reference.'">' .$all[$item->type][$item->relateddoc_id]->object->$name . '</a></span>
                    <a title="Удалить"><i class="fa fa-trash" style="cursor: pointer"
                    onclick="popupForDeletingRelatedDoc('.$item->id.')"></i></a>
                </span>';
    }
    $r .= '   <span class="tag" style="background-color: #0069d9;">
                        <span><a onclick="popupAddingRelatedDoc('. $doc_id .')" style="cursor: pointer">Добавить</a></span>
                    </span>
                </div>';
    
    $r .= '<label for="tags_2_tagsinput" class="form-control-label">
        Атрибуты документа</label></div>';
    $r .= '<div id="tags_2_tagsinput" class="form-control col col-md-12" style="width: 100%; min-height: 100px; height: 100px;">';
    foreach ($attributes as $key => $item) {
        $item = $item->object;
        $name = (string)$ref[$item->type]["columnName"];
        $reference = $ref[$item->type]["reference"] . $item->relateddoc_id;
        if ($item->type == 6) {
            $r .= '
                <span class="tag">
                    <span><a href="'.$reference.'">' .$ref[$item->type]["name"].': '.$all[$item->type][$item->relateddoc_id]->object->params->f.' '. $all[$item->type][$item->relateddoc_id]->object->params->i. '</a></span>
                    <a title="Удалить"><i class="fa fa-trash" style="cursor: pointer"
                    onclick="popupForDeletingRelatedDoc('.$item->id.')"></i></a>
                </span>';
        }
        else {
            $r .= '
                    <span class="tag">
                        <span><a href="'.$reference.'">' .$ref[$item->type]["name"].': '.$all[$item->type][$item->relateddoc_id]->object->$name . '</a></span>
                        <a title="Удалить"><i class="fa fa-trash" style="cursor: pointer"
                        onclick="popupForDeletingRelatedDoc('.$item->id.')"></i></a>
                    </span>';
        }
    }
    $r .= '   <span class="tag" style="background-color: #0069d9;">
                        <span><a onclick="popupAddingRelatedDoc('. $doc_id .')" style="cursor: pointer">Добавить</a></span>
                    </span>
                </div>';

    $r.='</div>';

if ($doc_id != false) return $r;
else return '';
?>
