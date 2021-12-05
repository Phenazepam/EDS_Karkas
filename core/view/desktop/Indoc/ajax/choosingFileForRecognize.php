<?php
use RedCore\Users\Collection as Users;
use RedCore\Indoc\Collection as Indoc;
use RedCore\Where;

$doc_id = $_REQUEST['oindoc_id'];
?>
<form action="/indocitems-form-view?action=oindoc.ajaxMoveRoute.do" 
    method="post" id="popup" name="oindoc"> 
    <div class="popup_body">
        <input type="hidden" name="orecognition[doc_id]" value="<?=$doc_id?>">
        <!-- <input type="hidden" name="orecognition[step]" value="<?=$next_step?>">
        <input type="hidden" name="oindoc[step_order]" value="<?=$step_order?>">
        <input type="hidden" name="oindoc[doc_type]" value="<?=$doc_type?>">
        <input type="hidden" name="oindoc[user_id]" value="<?=$user_id?>">
        <input type="hidden" name="oindoc[isback]" value="<?=$isBack?>">
        <input type="hidden" name="oindoc[isFinalStep]" value="<?=$isFinalStep?>"> -->

        <label for="orecognition[file]" style="margin-top: 10px; text-align:center;">Загрузить файл</label>
        <input class="form-control" type="file" name="orecognition[file]" id="orecognition[file]">
    </div>
</form>