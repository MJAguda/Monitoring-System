
	<?php

    $db = new PDO("mysql:host=localhost;dbname=monitoring_system", "root", "");
    $sql = "SELECT * FROM holders";
    $rs = $db->query($sql);

    if (!$rs) {
        echo "An SQL error occured.\n";
        exit;
    }

    $rows = array();

    while($r = $rs->fetch(PDO::FETCH_ASSOC)) {
        $rows[] = $r;
    }

    print json_encode($rows);
    $db = NULL;

?>