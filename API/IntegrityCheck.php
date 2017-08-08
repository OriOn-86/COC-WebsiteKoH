<?php
/**
 * check if not more than 1 CW is "in progress"
 * check that daily data has properly been recorded.
 */

// configuraiton and classes
require ("../include/conf.db.php");
require ("../include/conf.mail.php");
require ("../include/class.phpmailer.php");
require ("../include/class.smtp.php");
// db connect
try {
	$db = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
	exit ();
}

$Yesterday = (new DateTime())->sub(new DateInterval('P1D'));
$report='';
$activeWars = [];

$sql = "SELECT `state` FROM `coc_wars` WHERE `state` <> 'warEnded'";
$qry = $db->query($sql);
while ($data = $qry->fetch(PDO::FETCH_ASSOC)) {
	$activeWars[] = $data["state"];
}

if (count($activeWars) > 1) {
	$report = "warClosure";
}

$sql = "SELECT `date` FROM `coc_dailydata` ORDER BY `date` DESC LIMIT 1";
$qry = $db->query($sql);
$data = $qry->fetch(PDO::FETCH_ASSOC);
if ($data["date"] != $Yesterday->format("Y-m-d")) {
	$report .= " memberData";
}

$sql = "SELECT `daterecord` FROM `coc_dailyclandata` ORDER BY `daterecord` DESC LIMIT 1";
$qry = $db->query($sql);
$data = $qry->fetch(PDO::FETCH_ASSOC);
if ($data["daterecord"] != $Yesterday->format("Y-m-d")) {
	$report .= " clanData";
}

if ($report !=='') {
	// define message
	$MailMessage = "<!DOCTYPE HTML>
	<html>
		<head>
			<meta content='text/html;charset=utf-8' http-equiv='Content-Type'></meta>
			<title>Integrity check failed</title>
		</head>
		<body>
			<p style='font-size: 1.3em'>Dear " . $MailToName . ", </p>
			<p>Some database inconsistensies have been found during today's check.</p>
			<p>Please <strong>maunally</strong> inspect the content of the following items:</p>
			<ul>";
			$Items = explode(" ", $report);
			foreach ($Items as $Item) {
				$MailMessage .= "
				<li>" . $Item . "</li>";
			}
			$MailMessage .= "
			</ul>
			<p><span>NOTE:</span> detailed war info are limited in time within the game, if requested here please take immediate actions.</p>
			<br/>
			<p>Kind regards, </p>
			<p><a href='http://87.214.76.230/'>Knights of Hell</a></p>
		</body>
	</html>" ;
	// prepare and send mail to admin
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->Host = $MailHost;
	$mail->Port = $MailPort;
	$mail->SMTPSecure = 'ssl';
	$mail->SMTPAuth = true;
	$mail->Username = $MailUserName;
	$mail->Password = $MailPassword;
	$mail->setFrom($MailFromAddress, $MailFromName);
	$mail->addAddress($MailToAddress, $MailToName);
	$mail->Subject = "Database content verification needed.";
	$mail->msgHTML($MailMessage);
	if(!$mail->send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	}
}
?>
