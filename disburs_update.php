<?php
require 'database.php';
require 'api.php';

// cek status disburs
$sql = <<<SQL
SELECT dis_send_id 
FROM disburstment 
WHERE dis_send_status = 'PENDING' OR dis_send_receipt IS null OR dis_send_time_served IS null
ORDER BY dis_created_at asc;
SQL;

$db = new Database();
$conn = $db->getConnection();
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $totalUpdate = 0;
    echo "Total data $result->num_rows \n";
    while ($row = $result->fetch_assoc()) {
        // cek status terbaru
        $api = new Api();
        $api->method = 'GET';
        $api->url = 'https://nextar.flip.id/disburse/' . $row['dis_send_id'];
        $data = $api->getCurl();
        
        // update data
        $dbUpdate = new Database();
        $dbUpdate->table = 'disburstment';
        $dbUpdate->condition = 'dis_send_id='. $row['dis_send_id'];
        $dbUpdate->fieldsData = [
            'dis_send_receipt' => $data->receipt,
            'dis_send_status' => $data->status,
            'dis_send_time_served' => $data->time_served
        ];
        $upd = $dbUpdate->updateDb();
        if (!$upd) {
            break;
        } else {
            echo 'update id ' . $row['dis_send_id'] . ' berhasil, status ' . $data->status . "\n";
            $totalUpdate++;
        }
    }
    echo "total data terupdate $totalUpdate \n";
}

$conn->close();
?>