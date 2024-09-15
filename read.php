<?php
include 'common.php';
include 'pagination.php';


// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;


// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
// $stmt = $pdo->prepare('SELECT * FROM contacts ORDER BY id LIMIT :current_page, :record_per_page');
// $stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
// $stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
// $stmt->execute();
// // Fetch the records so we can display them in our template.
// $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// // Get the total number of contacts, this is so we can determine whether there should be a next and previous button
// $num_contacts = $pdo->query('SELECT COUNT(*) FROM contacts')->fetchColumn();

// $db->bind(':current_page', ($page-1)*$records_per_page);
// $db->bind(':record_per_page', $records_per_page);

$db->bindMore(array("current_page"=>($page-1)*$records_per_page,"record_per_page"=>$records_per_page));
$contacts = $db->query('SELECT * FROM contacts ORDER BY id LIMIT :current_page, :record_per_page');

$num_contacts = $db->single('SELECT COUNT(*) FROM contacts');


// 페이징 처리
$rowsPerPage = $records_per_page;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$totalRows = $num_contacts;

$totalPages = ceil($totalRows / $rowsPerPage);
$offset = ($page - 1) * $rowsPerPage; // 시작 열을 구함

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

// 페이징 클래스에 넘겨주어야 하는 내용
// $totalRows: 전체 row갯수, $rowsPerPage: 페이지당 보여줄 row갯수, 5:보여지는 페이징 갯수 설정 
$paging = new Pagination($totalRows, $rowsPerPage, $actual_link, 5, $page);
?>

<?=template_header('Read')?>

<div class="content read">
	<h2>Read Contacts</h2>
	<a href="create.php" class="create-contact">Create Contact</a>
  <span>Total: <?=$num_contacts?> / Page: <?php echo $page ?></span>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Name</td>
                <td>Email</td>
                <td>Phone</td>
                <td>Title</td>
                <td>Created</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?=$contact['id']?></td>
                <td><?=$contact['name']?></td>
                <td><?=$contact['email']?></td>
                <td><?=$contact['phone']?></td>
                <td><?=$contact['title']?></td>
                <td><?=$contact['created']?></td>
                <td class="actions">
                    <a href="update.php?id=<?=$contact['id']?>&page=<?=$page?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$contact['id']?>&page=<?=$page?>" onclick="del(this.href);return false;" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_contacts): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<div>
  <?php echo $paging->createBootstrap5Links(); ?>
</div>

<?=template_footer()?>