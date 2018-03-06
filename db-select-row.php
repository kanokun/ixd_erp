<?PHP
//$query = "SELECT * FROM company_self";
$query = $_GET['query'];

$dbh = new PDO('mysql:host=localhost;dbname=ixd_erp','root','qlalfqjs1', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$stmt = $dbh->prepare($query);
$stmt->execute();
$list = $stmt->fetchAll(PDO::FETCH_ASSOC);


$data;

$idx = 0;
foreach($list as $row){
    $data[$idx] = $row;
    $idx++;
}

header('Content-Type: application/json');
echo json_encode($data);
?>