<?php
$a="helloword";
$password=password_hash($a,PASSWORD_BCRYPT);
echo $password;
if (password_verify('helloword', $password)) {
    echo '密码是有效的';
} else {
    echo '无效密码';
}
?>