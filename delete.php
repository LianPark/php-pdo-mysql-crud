<?php
include 'common.php';

$table_name = 'contacts';

/**
 * 검증
 */


/**
 * 
 */
if (isset($_GET['id'])) {
  $rows = $db->query("DELETE FROM ".$table_name." WHERE id = :id", array("id"=>$_GET['id']));
} else {
  alert('No ID specified!');
}

if ($rows < 1)
  alert('delete counts: ' . $rows);

goto_url(GG_HOME.'/read.php?page='.$_GET['page']);
?>