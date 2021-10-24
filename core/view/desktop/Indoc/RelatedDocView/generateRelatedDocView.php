<?php

use RedCore\Request;
use RedCore\Where;
use RedCore\Indoc\Collection as Indoc;
use RedCore\Users\Collection as Users;
use RedCore\Session as Session;

$doc_id = Session::get("s_relateddoc_id");

$where = $where = Where::Cond()
    ->add("_deleted", "=", "0")
    ->add("and")
    ->add("doc_id", "=", $doc_id)
    ->parse();

Indoc::setObject("orelateddocs");
$relateddocs = Indoc::getList($where);

Indoc::setObject("oindoc");
$docs = Indoc::getList();

$r = '<script src="/core/view/desktop/Indoc/js/popupAddingRelatedDoc.js"></script>
    <div class="row form-group">
    <div class="col col-md-12">
    <label for="reg_date" class="form-control-label">
    Связанные документы</label></div>';
$r .= '<div id="tags_1_tagsinput" class="form-control col col-md-12" style="width: 100%; min-height: 100px; height: 100px;">';
foreach ($relateddocs as $key => $item) {
    $item = $item->object;
    $r .= '
            <span class="tag">
                <span><a href="/indocitems-form-view?oindoc_id='.$item->relateddoc_id.'">' . $docs[$item->relateddoc_id]->object->name_doc . '</a></span>
                <a title="Removing tag"><i class="fa fa-trash" style="cursor: pointer"
                onclick="popupForDeletingRelatedDoc('.$item->id.')"></i></a>
            </span>';
}
$r .= '   <span class="tag" style="background-color: #0069d9;">
                    <span><a onclick="popupAddingRelatedDoc('. $doc_id .')" style="cursor: pointer">Добавить</a></span>
                </span>
            </div> </div>';
return $r;
?>
