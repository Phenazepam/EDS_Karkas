<?php

use RedCore\Request as Request;

$text = Request::vars("text");
$url = Request::vars("url");
?>
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive" style="text-align: center;">
                            <div>
                                <h2><?= $text ?></h2>
                                <a href="/<?= $url ?>" class="btn btn-primary">Вернуться к реестру записей</a>
                                <a href="#" OnClick="history.back();" class="btn btn-primary">Вернуться назад</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>