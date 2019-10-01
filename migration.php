<?php
require 'database.php';

$sql = <<<SQL
CREATE TABLE disburstment (
    dis_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    dis_bank_code VARCHAR(15) NOT NULL,
    dis_acc_number VARCHAR(15) NOT NULL,
    dis_amount FLOAT(16,2) NOT NULL,
    dis_remark TEXT,
    dis_send_id BIGINT,
    dis_send_status VARCHAR(10),
    dis_send_receipt TEXT,
    dis_send_beneficiary_name TEXT,
    dis_send_time_served DATETIME,
    dis_send_fee FLOAT(16,2),
    dis_created_at DATETIME,
    dis_updated_at DATETIME
) ENGINE InnoBD;
SQL;

$db = new Database();

if ($db->getConnection()->query($sql)) {
    echo 'Migration success';
} else {
    echo 'Error: ' . $sql . "\n" . $db->getConnection()->error;
}