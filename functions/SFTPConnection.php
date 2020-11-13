<?php
$conn = ssh2_connect('uakbenin.org', 22);
ssh2_auth_password($conn, 'uakbe442530', 'DF6gAWVs');
$sftp = ssh2_sftp($conn);
// send a file
ssh2_scp_send($conn, '../maintenance.jpg', 'inscription/maintenance.jpg', 0644);
