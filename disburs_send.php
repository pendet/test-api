<?php
require 'database.php';
require 'api.php';

$bankCodeArr = ['BNI', 'BCA', 'BRI', 'MANDIRI', 'CIMB', 'MEGA'];
$bankCodeRandom = array_rand($bankCodeArr);
$api = new Api();
$api->method = 'POST';
$api->url = 'https://nextar.flip.id/disburse';
$api->data = [
    'bank_code' => $bankCodeArr[$bankCodeRandom], // dapatkan code bank secara random
    'account_number' => mt_rand(000000, 999999), // random nomor rekening maksimal 6 digit
    'amount' => mt_rand(0000000, 9999999), // random nominal maksimal 7 digit
    'remark' => 'fdsafdsa'
];
$data = $api->getCurl();
if ($data->status != 401) {
    $db = new Database();
    $db->table = 'disburstment';
    $db->fieldsData = [
        'dis_send_id' => $data->id,
        'dis_amount' => $data->amount,
        'dis_send_status' => $data->status,
        'dis_bank_code' => $data->bank_code,
        'dis_acc_number' => $data->account_number,
        'dis_send_beneficiary_name' => $data->beneficiary_name,
        'dis_remark' => $data->remark,
        'dis_send_fee' => $data->fee
    ];
    $db->insertDb();
} else {
    echo $data->message . "\n";
}

?>