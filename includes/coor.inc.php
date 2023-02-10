<?php

    $db = new PDO("mysql:host=localhost;dbname=_monitoring_system", "root", "");
    $sql = "SELECT * FROM coordinates
            LEFT JOIN holders ON coordinates.didCoordinates = holders.didCoordinates
            UNION
            SELECT * FROM coordinates
            RIGHT JOIN holders ON coordinates.didCoordinates = holders.didCoordinates;";
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