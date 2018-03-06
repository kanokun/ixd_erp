<?php
include_once 'include/kan_session.class.php';
$dbh = new PDO('mysql:host=localhost;dbname=ixd_erp','root','qlalfqjs1', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$table = $_POST['table'];
$db_type = $_POST['db_type'];


switch($db_type) {
    case "insert":
        
        $name = $_POST['name'];
        $etc = $_POST['etc'];
        
        switch($table) {
            
            case "company":
            case "company_self":
                
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $fax = $_POST['fax'];
                $admin = $_POST['admin'];
                $code = $_POST['code'];
                
                $stmt = $dbh->prepare("INSERT INTO $table (`id_acc`,`name`,`email`,`phone`,`fax`,`admin`,`code`,`etc`) VALUES (".$_SESSION['id'].",'$name','$email','$phone','$fax','$admin','$code','$etc')");
                $stmt->execute();
                
                break;
                
            case "type_purchase":
            case "type_sales":
                
                $stmt = $dbh->prepare("INSERT INTO $table (`id_acc`,`name`,`etc`) VALUES (".$_SESSION['id'].",'$name','$etc')");
                $stmt->execute();
                
                break;
                
            case "sales":
                
                $consignment = $_POST['consignment'];
                $id_comp_self = $_POST['company_self'];
                $id_comp = $_POST['company'];
                $id_type = $_POST['type'];
                $date = str_replace('/','',$_POST['date']);
                $cost = $_POST['cost'];
                $tax = $_POST['tax'];
                
                // 여기서 세금계산서 추가.
                if($consignment != "on")
                {
                    
                }
                
            case "purchase":
                
                $id_comp_self = $_POST['company_self'];
                $id_comp = $_POST['company'];
                $id_type = $_POST['type'];
                $date = str_replace('/','',$_POST['date']);
                $cost = $_POST['cost'];
                $tax = $_POST['tax'];
                $type_detail = $_POST['detail'];
                $cost_type = $_POST['cost-type'];
                $etc = $_POST['etc'];
                $state = $_POST['state'];
                
                $cost = str_replace(',','',$cost);
                $tax = str_replace(',','',$tax);
                
                $stmt = $dbh->prepare("INSERT INTO $table (`id_acc`,`date`,`id_comp_self`,`id_comp`,`id_type`,`type_detail`,`cost_type`,`cost`,`tax`,`etc`,`state`) VALUES (".$_SESSION['id'].",$date,$id_comp_self,$id_comp,$id_type,'$type_detail','$cost_type',$cost,$tax,'$etc','$state')");
                $stmt->execute();
                
                break;
                
            case "calendar":
                
                $title = $_POST['title'];
                $date_start = $_POST['date-start'];
                $date_end = $_POST['date-end'];
                $color = $_POST['color'];
                
                $stmt = $dbh->prepare("INSERT INTO $table (`id_acc`,`name`,`startdate`,`enddate`,`color`) VALUES (".$_SESSION['id'].",'$title','$date_start','$date_end','$color')");
                $stmt->execute();
                break;
                
            case "draft":
                $title = $_POST['title'];
                $content = $_POST['content'];
                $files = $_POST['files'];
                
                $stmt = $dbh->prepare("INSERT INTO $table (`id_acc`,`title`,`html`,`files`) VALUES (".$_SESSION['id'].",'$title','$content','$files')");
                $stmt->execute();
                $id = $dbh->lastInsertId();
                
                if($files != '')
                {
                    $uploads_dir = '/home/kanokun/public_html/erp/file/uploads/';
                    
                    @mkdir($uploads_dir.$id, 0777);
                    @chmod($uploads_dir.$id, 0777);
                    
                    $files = explode('|', $files);
                    
                    for($i=0; $i<sizeof($files); $i++){
                        
                        rename($uploads_dir.$files[$i], $uploads_dir.$id.'/'.$files[$i]);
                    }
                }
                
                break;
                
            case "draft_holiday":
                $date_start = $_POST['date-start'];
                $date_end = $_POST['date-end'];
                
                $count = $_POST['count'];
                $etc = $_POST['etc'];
                
                $stmt = $dbh->prepare("INSERT INTO $table (`id_acc`,`date_start`,`count`,`etc`) VALUES (".$_SESSION['id'].",'$date_start',$count,'$etc')");
                $stmt->execute();
                
                ?>
                <script>
                alert("신청 되었습니다.");
                parent.reload();
                </script>                
                <?php
                exit;

                break;

            case "magazine":

                $type = $_POST['type'];
                $month = $_POST['month'];
                $count_call = $_POST['count-call'];
                $count_homepage = $_POST['count-homepage'];
                $count_themagazine = $_POST['count-themagazine'];
                $count_unit = $_POST['count-unit'];
                $count_exhibit = $_POST['count-exhibit'];
                $count_etc = $_POST['count-etc'];
                $count_finish = $_POST['count-finish'];
                $count_resubscr = $_POST['count-resubscr'];
                $count_subscr = $_POST['count-subscr'];
                $count_all = $_POST['count-all'];

                $stmt = $dbh->prepare("INSERT INTO $table (`id_acc`,`month`,`type`,`count_call`,`count_homepage`,`count_exhibit`,`count_etc`,`count_unit`,`count_subscr`,`count_resubscr`,`count_finish`,`count_all`,`etc`) VALUES (".$_SESSION['id'].",'$month','$type',$count_homepage,$count_themagazine,$count_exhibit,$count_etc,$count_unit,$count_subscr,$count_resubscr,$count_finish,$count_all,'$etc')");
                $stmt->execute();

                break;

            case "sample_receiver":
                
                $id_sender = $_POST['id_sender'];
                $receiver = $_POST['receiver'];
                $addr = $_POST['addr'];
                $phone = $_POST['phone'];
                $ixd = $_POST['ixd'];
                $deco = $_POST['deco'];
                $jurak = $_POST['jurak'];
                $etc = $_POST['etc'];
                
                $stmt = $dbh->prepare("INSERT INTO $table (`id_acc`,`id_sender`,`receiver`,`addr`,`phone`,`ixd`,`deco`,`jurak`,`etc`) VALUES (".$_SESSION['id'].",$id_sender,'$receiver','$addr','$phone','$ixd','$deco','$jurak','$etc')");
                $stmt->execute();
                
                break;
        }
        ?>

        <script>
        alert("추가 되었습니다.");
        parent.reload();
        </script>
        <?php 
        break;

    case "update":

        $id = $_POST['id'];
        $etc = $_POST['etc'];
        
        switch($table) {
            
            case "company":
            case "company_self":
                
                $name = $_POST['name'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $fax = $_POST['fax'];
                $admin = $_POST['admin'];
                $code = $_POST['code'];
                
                $stmt = $dbh->prepare("UPDATE $table SET `name`='$name',`email`='$email',`phone`='$phone',`fax`='$fax',`admin`='$admin',`code`='$code',`etc`='$etc' WHERE `id`=$id LIMIT 1");
                $stmt->execute();
                
                break;
                
            case "type_purchase":
            case "type_sales":
                
                $name = $_POST['name'];
                
                $stmt = $dbh->prepare("UPDATE $table SET `name`='$name',`etc`='$etc' WHERE `id`=$id LIMIT 1");
                $stmt->execute();
                
                break;
                
            case "purchase":
            case "sales":
                
                $id_comp_self = $_POST['company_self'];
                $id_comp = $_POST['company'];
                $id_type = $_POST['type'];
                $date = str_replace('/','',$_POST['date']);
                $type_detail = $_POST['detail'];
                $cost_type = $_POST['cost-type'];
                $cost = $_POST['cost'];
                $tax = $_POST['tax'];
                $etc = $_POST['etc'];
                $state = $_POST['state'];
                
                $cost = str_replace(',','',$cost);
                $tax = str_replace(',','',$tax);
                
                $stmt = $dbh->prepare("UPDATE $table SET `date`=$date,`id_comp_self`=$id_comp_self,`id_comp`=$id_comp,`id_type`=$id_type,`type_detail`='$type_detail',`cost_type`='$cost_type',`cost`=$cost,`tax`=$tax,`etc`='$etc',`state`='$state' WHERE `id`=$id LIMIT 1");
                $stmt->execute();
                
                break;
                
            case "magazine":
                
                $type = $_POST['type'];
                $month = $_POST['month'];
                $count_call = $_POST['count-call'];
                $count_homepage = $_POST['count-homepage'];
                $count_themagazine = $_POST['count-themagazine'];
                $count_unit = $_POST['count-unit'];
                $count_exhibit = $_POST['count-exhibit'];
                $count_etc = $_POST['count-etc'];
                $count_finish = $_POST['count-finish'];
                $count_resubscr = $_POST['count-resubscr'];
                $count_subscr = $_POST['count-subscr'];
                $count_all = $_POST['count-all'];
                
                $stmt = $dbh->prepare("UPDATE $table SET `month`='$month',`type`='$type',`count_call`=$count_call,`count_homepage`=$count_homepage,`count_themagazine`=$count_themagazine,`count_exhibit`=$count_exhibit,`count_etc`=$count_etc,`count_unit`=$count_unit,`count_subscr`=$count_subscr,`count_resubscr`=$count_resubscr,`count_finish`=$count_finish,`count_all`=$count_all,`etc`='$etc' WHERE `id`=$id LIMIT 1");
                $stmt->execute();
                
                break;
                
            case "sample_receiver":
                
                $id_sender = $_POST['id_sender'];
                $receiver = $_POST['receiver'];
                $addr = $_POST['addr'];
                $phone = $_POST['phone'];
                $ixd = $_POST['ixd'];
                $deco = $_POST['deco'];
                $jurak = $_POST['jurak'];
                $etc = $_POST['etc'];
                
                $stmt = $dbh->prepare("UPDATE $table SET `id_acc`=".$_SESSION['id'].",`id_sender`=$id_sender,`receiver`='$receiver',`addr`='$addr',`phone`='$phone',`ixd`=$ixd,`deco`=$deco,`jurak`=$jurak,`etc`='$etc' WHERE `id`=$id LIMIT 1");
                $stmt->execute();
                
                break;
        }
        ?>
        <script>
        alert("수정 되었습니다.");
        parent.reload();
        </script>
        <?php
        break;
        
    case "delete":
        $id = $_POST['id'];
        
        $stmt = $dbh->prepare("DELETE FROM $table WHERE `id`=$id");
        $stmt->execute();
        break;
        
    default:
        ?>
        <script>
        alert("<?=$db_type?> 잘못된 페이지 접근 입니다.");
        location.href="/erp";
        </script>
        <?php 
        break;
}
?>