<?php
    $connection = ssh2_connect('sftp://@ 41.86.227.225', 22, array('hostkey'=>'UAC_KETOU_UP'));
	    // Notification à l'utilisateur si le serveur termine la connexion
    /* function ma_deconnexion_ssh($raison, $message, $language) {
        printf("Serveur deconnecte avec l'erreur code [%d] et le message: %s\n",
             $raison, $message);
    }
    $callbacks = array('disconnect' => 'ma_deconnexion_ssh');
     
    $connection = ssh2_connect('sftp://@ 41.86.227.225', 22, array('hostkey'=>'ssh-dss'), $callbacks); */
    if (!$connection) die('Echec de la connexion');
	
	echo ssh2_fingerprint($connection, SSH2_FINGERPRINT_MD5 | SSH2_FINGERPRINT_HEX);
	if (!ssh2_auth_pubkey_file($connection, 'ECO_UAK',
                          '/home/ECO_UAK/.ssh/id_dsa.pub',
                          '/home/ECO_UAK/.ssh/id_dsa', 'passphrase_de_la_cle_privee'))
    die("<br>Erreur lors de l'authentification par cle publique");

?>