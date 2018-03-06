<?php
include_once 'include/kan_session.class.php';

$kan_session->deleteId();
$kan_session->delete("name");
$kan_session->delete("position");
$kan_session->delete("id");
?>
<script>
location.href="/erp";
</script>