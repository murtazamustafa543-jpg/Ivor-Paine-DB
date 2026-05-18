<?php


//sql server connection here....

define('DB_SERVER',   'DESKTOP-6Q7G8U2\SQLEXPRESS');
define('DB_NAME', 'HospitalDB_v2');
define('DB_USER','');       
define('DB_PASS',''); 

function getConn() {
    $connectionInfo = [
        "Database"               => DB_NAME,
        "UID"                    => DB_USER,
        "PWD"                    => DB_PASS,
        "CharacterSet"           => "UTF-8",
        "TrustServerCertificate" => true,
    ];
    $conn = sqlsrv_connect(DB_SERVER, $connectionInfo);
    if ($conn === false) {
        $errors = sqlsrv_errors();
        die(json_encode(['error' => $errors[0]['message']]));
    }
    return $conn;
}

function queryRows($sql, $params = []) {
    $conn = getConn();
    $stmt = $params ? sqlsrv_query($conn, $sql, $params) : sqlsrv_query($conn, $sql);
    if ($stmt === false) {
        $e = sqlsrv_errors();
        return ['error' => $e[0]['message']];
    }
    $rows = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        // Convert DateTime objects to strings
        foreach ($row as $k => $v) {
            if ($v instanceof DateTime) {
                $row[$k] = $v->format('Y-m-d');
            }
        }
        $rows[] = $row;
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
    return $rows;
}

function queryOne($sql, $params = []) {
    $rows = queryRows($sql, $params);
    return $rows[0] ?? null;
}

function execute($sql, $params = []) {
    $conn = getConn();
    $stmt = $params ? sqlsrv_query($conn, $sql, $params) : sqlsrv_query($conn, $sql);
    $ok = ($stmt !== false);
    if (!$ok) {
        $e = sqlsrv_errors();
        sqlsrv_close($conn);
        return ['success' => false, 'error' => $e[0]['message']];
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
    return ['success' => true];
}
