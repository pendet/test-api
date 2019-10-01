# test-api Documentation
Untuk menjalankan aplikasi ini harap terlebih dahulu membuat database `testapi` pada `MySQL`.

Setelah itu jalan kan file `migration.php`, jika berhasil maka akan mengeluarkan pesan `Migration success`

```shell
user@ubuntu:/home/user/test-api$php migration.php
Migration success
```

Kemudian rubah isi file `config.php`

```php
<?php
define('DBHOST', 'isi dengan host anda');
define('DBUSER', 'isi dengan user database anda');
define('DBPASS', 'isi dengan password database anda');
define('DBNAME', 'testapi');
define('AUTHKEY', 'isi dengan auth key anda');
?>
```

Kemudian jalan kan file `disburs_send.php` untuk mengirim data, jika berhasil maka akan menampilkan pesan `data berhasil disimpan`

```shell
user@ubuntu:/home/user/test-api$php disburs_send.php
data berhasil disimpan
```

Untuk melakukan pengecekan status dan merubah status, jalan kan file `disburs_update.php`

```shell
user@ubuntu:/home/user/test-api$php disburs_update.php
Total data 3 
update id 9446771571 berhasil, status PENDING
update id 2687024962 berhasil, status SUCCESS
update id 9529835169 berhasil, status SUCCESS
total data terupdate 3
```