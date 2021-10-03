<form name="form" action="" method="post">
  <table>
    <tr>
      <td>Имя документа:</td>
      <td><input type="text" name="doc_name" /> </td>
    </tr>
    <tr>
      <td>№ Регистрации</td>
       <td><input type="text" name="reg_number" /> </td>
    </tr>
    
	 <tr>
      <td>
        <input type="submit" name="search" value="Искать" />
      </td>
    </tr>
  </table>
</form>

<?php 

use RedCore\Search\Collection as Search;

Search::setObject("osearch");
$test_list = Search::getList();


function addWhere($where, $add, $and = true) {
    if ($where) {
        if ($and) $where .= " AND $add";
        else $where .= " OR $add";
    }
    else $where = $add;
    return $where;
}
if (!empty($_POST["search"])) {
    $where = "";
    if ($_POST["doc_name"]) $where = addWhere($where, "`name_doc` = '".htmlspecialchars($_POST["doc_name"]))."'";
    if ($_POST["reg_number"]) $where = addWhere($where, "`reg_namber` = '".htmlspecialchars($_POST["reg_number"]))."'";

    if ($where) $test_list .= " WHERE $where";
    echo $test_list;
}
?>
