<?php
use RedCore\Indoc\Collection as Indoc;
use RedCore\Where as Where;
use RedCore\Session as Session;

session_start();

Indoc::setObject(oindoc);
$doc_indoc = Indoc::getList();

$str = $_POST['string'];
$mass = explode("", $str);
$count = count($mass);

$sql = "SELECT id, name_doc, reg_number, reg_date FROM 'eds_karkas__document' LIKE '%".$mass[0]."%'";

$result = $db->query($sql);
$result->setFetchMode(PDO::FETCH_ASSOC);

$id_mass = array();
$i = 1;

while ($row = $result->fetch()) {
    $id_mass[$i] = $row['id'];
    
    $i++;
}

$id_count = count($id_mass);

for ($i=1; $i<=$count-1 ; $i++) {
    for ($j=1; $j<=$id_count; $j++) {
        
        $sql = "SELECT id, name_doc, reg_number, reg_date FROM 'eds_karkas__document' WHERE id=".$id_mass[$j]." AND content LIKE '%".$mass[$i]."%'";
        
        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        
        $id_mass2 = array();
        
        $row = $result->fetch();

        $temp = $row['id'];
        
        if($temp!=$id_mass[$j]) {
            $id_mass[$j] = -1;
        }
    }  
}

$l=1;

for($i=1; $i < $id_count+1; $i++) {
    if ($id_mass[$i] == -1) continue;
    else {
        $_SESSION['id'][$l] = $id_mass[$i];
        $l++;
    }
}

header('Location: RedCore\view\desktop\Search\list.php');