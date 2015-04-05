#!/usr/local/bin/php
<?php
/**
 * Generates a backup of the database and sends it in an email
 *
 * @author Elijah Lofgren < elijahlofgren [at] elijahlofgren.com>
 * @version $Id: backup-database-cron.php 2135 2005-08-07 13:43:29Z elijahlofgren $
 */
require_once dirname(__FILE__).'/../../../config.php';
echo 'Coucou ! ';
/**
$output = 'Creating Database backup.';
$email = 'contact@agi-webconseil.fr';
$output .= backup($config, $email);
echo $output;
// $output .= $Page->showFooter();
// echo $output;

    /* Database Backup Utility 1.0 By Eric Rosebrock, http://www.phpfreaks.com
    Written: July 7th, 2002 12:59 AM

    If running from shell, put this above the <?php  "#! /usr/bin/php -q"  without the quotes!!!

    This script is dedicated to "Salk". You know who you are :)

    This script runs a backup of your database that you define below. It then gzips the .sql file
    and emails it to you or ftp's the file to a location of your choice.

    It is highly recommended that you leave gzip on to reduce the file size.

    You must chown the directory this script resides in to the same user or group your webserver runs
    in, or CHMOD it to writable. I do not recommend chmod 777 but it's a quick solution. If you can setup
    a cron, you can probably chown your directory!

    IMPORTANT!!! I recommend that you run this outside of your
    web directory, unless you manually want to run this script. If you do upload it inside your web
    directory source Tree($settings), I would at least apply Apache access control on that directory. You don't
    want people downloading your raw databases!

    This script is meant to be setup on a crontab and run on a weekly basis
    You will have to contact your system administrator to setup a cron tab for this script
    Here's an example crontab:

    0 0-23 * * * php /path/to/thisdirectory/dbsender.php > /dev/null

    
    function backup($config, $email)
    {
        // Optional Options You May Optionally Configure

        $use_gzip = TRUE;  // Set to FALSE if you don't want the files sent in .gz format
        $remove_sql_file = TRUE; // Set this to TRUE if you want to remove the .sql file after gzipping. Yes is recommended.
        $remove_gzip_file = TRUE; // Set this to TRUE if you want to delete the gzip file also. I recommend leaving it to "no"

        // Full path to the backup directory. Do not use trailing slash!
        $savepath = dirname(__FILE__);
        $send_email = TRUE;  // Do you want this database backup sent to your email? Fill out the next 2 lines

        // $senddate = date("j F Y");
        $senddate = date('Y-m-d-Hi');

        // Subject in the email to be sent.
        $subject = 'MySQL DB Mairie Fouesnant : '.$config['db_name'].' Backup - '.$senddate;
        $message = 'Your MySQL database has been backed up and is attached to this email'; // Brief Message.

/*
        $use_ftp = "no"; // Do you want this database backup uploaded to an ftp server? Fill out the next 4 lines
        $ftp_server = ""; // FTP hostname
        $ftp_user_name = ""; // FTP username
        $ftp_user_pass = ""; // FTP password
        $ftp_path = "/public_html/backups/"; // This is the path to upload on your ftp server!

        // Do not Modify below this line! It will void your warranty!

        $date = date('Y-m-d-Hi');
        $filename = $savepath.'/'.$config['db_name'].'-'.$date.'.sql';
        // passthru("mysqldump --opt -h$dbhost -u$dbuser -p$dbpass $dbname >$filename");
        // passthru("mysqldump --opt -h$dbhost -u$dbuser -p$dbpass $dbname >$filename");
        // $passthru = "mysqldump -h $server -u $username -p$password --add-drop-table --all --quick --lock-tables --disable-keys --extended-insert -d $database >$filename";
        $passthru = 'mysqldump --opt'
                             .' -h '.$config['db_hostname']
                             .' -u '.$config['db_username']
                      // There must not be a space between -p and the password
                             .' -p'.$config['db_password']
                      // There MUST be a space between the password and DB name
                             .' '.$config['db_name'].' > '.$filename;
                             // echo $passthru;
        //  $passthru = "mysqldump -h $server -u $username -p$password --opt --tables -d $database >$filename";
        // echo $passthru;
        passthru($passthru);

        if (FALSE != $use_gzip) {
            $real_path = realpath($savepath);
            // echo '<br />df '.$real_path.'</br>';
            $zipline = "tar -czf ".$real_path.'/'.$config['db_name'].'-'.$date.'_sql.tar.gz '.$real_path.'/'.$config['db_name'].'-'.$date.'.sql';
            // $zipline = "tar -czf --directory=".$real_path.'  '.$database."-".$date."_sql.tar.gz "."$database-$date.sql";
            //   echo '<br />'.$zipline.'<br />';
            shell_exec($zipline);
        }
        // Remove the SQL file if needed
        if (FALSE != $remove_sql_file) {
            exec('rm -r -f '.$filename);
        }
        // If supposed to gzip the file
        if (FALSE != $use_gzip) {
            $filename2 = $savepath.'/'.$config['db_name'].'-'.$date.'_sql.tar.gz';
        } else {
            $filename2 = $savepath.'/'.$config['db_name'].'-'.$date.'.sql';
        }
        // If backing up to email address
        if (FALSE != $send_email) {
            $fileatt_type = filetype($filename2);
            //  echo $filename2;
            $fileatt_name = "".$config['db_name']."-".$date."_sql.tar.gz";
            $headers = 'From: '.$email;
            // Read the file to be attached ('rb' = read binary)
            $file = fopen($filename2, 'rb');
            $data = fread($file, filesize($filename2));
            fclose($file);

            // Generate a boundary string
            $semi_rand = md5(time());
            $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

            // Add the headers for a file attachment
            $headers .= "\nMIME-Version: 1.0\n" ."Content-Type: multipart/mixed;\n" ." boundary=\"{$mime_boundary}\"";

            // Add a multipart boundary above the plain message
            $message = "This is a multi-part message in MIME format.\n\n" ."--{$mime_boundary}\n" ."Content-Type: text/plain; charset=\"iso-8859-1\"\n" ."Content-Transfer-Encoding: 7bit\n\n" .
            $message . "\n\n";

            // Base64 encode the file data
            $data = chunk_split(base64_encode($data));

            // Add file attachment to the message
            $message .= "--{$mime_boundary}\n" ."Content-Type: {$fileatt_type};\n" ." name=\"{$fileatt_name}\"\n" ."Content-Disposition: attachment;\n" ." filename=\"{$fileatt_name}\"\n" ."Content-Transfer-Encoding: base64\n\n" .
            $data . "\n\n" ."--{$mime_boundary}--\n";

            // Send the message
            $ok = mail($email, $subject, $message, $headers);
            if (FALSE != $ok) {
                $output  = '<p>Database backup created and sent! ';
                $output .= 'File name '.$filename2.'</p>';
            } else {
                $output = '<p>Mail could not be sent. Sorry!</p>';
            }
        }
        /*
        if($use_ftp == "yes"){
            $ftpconnect = "ncftpput -u $ftp_user_name -p $ftp_user_pass -d debsender_ftplog.log -e dbsender_ftplog2.log -a -E -V $ftp_server $ftp_path $filename2";
            shell_exec($ftpconnect);
            echo "<h4><center>$filename2 Was created and uploaded to your FTP server!</center></h4>";

        }
        
        if ('yes' == $remove_gzip_file) {
            exec("rm -r -f $filename2");
        }
        return $output;
    }
*/
?>
