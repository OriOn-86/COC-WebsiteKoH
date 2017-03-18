<?php
	$qry = $db->query('SELECT `date`, `log` FROM `coc_logs` order by `id` desc limit 0,20');
	echo "
	<table id='logs'>
		<tr><th colspan='2'>Logs</th></tr>";
	while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {
		echo "
		<tr>
			<td width='100px'>" . $row['date'] . "</td>
			<td width='200px'>";
		if ($row['log']=="Daily record from API.") {
			echo "<a href='index.php?op=daily&day=" . $row['date'] . "'>" . $row['log'] . "</a></td>";
		} else {
			echo "<a href='index.php?op=weekly&day=" . $row['date'] . "'>" . $row['log'] . "</a></td>";
		}
		echo "
		</tr>";
	}
	echo "
	</table>";
?>