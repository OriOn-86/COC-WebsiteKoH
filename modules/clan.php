<?php
// clan.php
// clan evo over 30 days
// clan distrib over leagues

// db connect
try {
        $db = new PDO($dsn, $user, $password);
} catch(PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
}
// latest data for display
$sql = "SELECT `daterecord`, `clanlevel`, `clanmembers`, `clanpoints` " 
	. "FROM `coc_dailyClanData` "
	. "ORDER BY `daterecord` DESC "
	. "LIMIT 1;";
$qry = $db->query($sql);
while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {
	$clanLevel = $row['clanlevel'];
	$nbMembers = $row['clanmembers'];
	$nbPoints = $row['clanpoints'];
	$daterecord = $row['daterecord'];
}
// distrib over leagues.
$Unranked = 0;
$Bronze = 0;
$Silver = 0;
$Gold = 0;
$Crystal = 0;
$Master = 0;
$Champion = 0;
$Titan = 0;
$Legend = 0;
$sql = "SELECT `league` "
	. "FROM `coc_dailyData` "
	. "WHERE `date`=$daterecord;";
$qry = $db->query($sql);
while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {
	$league = $row['league'];
	if ($pos = strpos($league, " ")) {
		$league = substr($league, 0, $pos);
	}
	switch ($league) {
		case "Unranked":
			$Unranked+=1;
			break;
		case "Bronze":
			$Bronze+=1;
			break;
		case "Silver":
			$Silver+=1;
			break;
		case "Gold":
			$Gold+=1;
			break;
		case "Crystal":
			$Crystal+=1;
			break;
		case "Master":
			$Master+=1;
			break;
		case "Champion":
			$Champion+=1;
			break;
		case "Titan":
			$Titan+=1;
			break;
		case "Legend":
			$Legend+=1;
			break;
	}
}
if ($Unranked > 0) {$data3[]="{name:Unranked, y:" . (int)($Unranked*100/$nbMembers) ."}";}
if ($Bronze > 0) {$data3[]="{name:Bronze, y:" . (int)($Bronze*100/$nbMembers) ."}";}
if ($Silver > 0) {$data3[]="{name:Silver, y:" . (int)($Silver*100/$nbMembers) ."}";}
if ($Gold > 0) {$data3[]="{name:Gold, y:" . (int)($Gold*100/$nbMembers) ."}";}
if ($Crystal > 0) {$data3[]="{name:Crystal, y:" . (int)($Crystal*100/$nbMembers) ."}";}
if ($Master > 0) {$data3[]="{name:Master, y:" . (int)($Master*100/$nbMembers) ."}";}
if ($Champion > 0) {$data3[]="{name:Champion, y:" . (int)($Champion*100/$nbMembers) ."}";}
if ($Titan > 0) {$data3[]="{name:Titan, y:" . (int)($Titan*100/$nbMembers) ."}";}
if ($Legend > 0) {$data3[]="{name:Legend, y:" . (int)($Legend*100/$nbMembers) ."}";}

// data for charts
// chart 1 for trophy evo.
// chart 2 for member evo.
$sql = "SELECT `daterecord`, `clanmembers`, `clanpoints` " 
	. "FROM `coc_dailyClanData` "
	. "ORDER BY `daterecord` DESC "
	. "LIMIT 30;";
$qry = $db->query($sql);
while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {
	$daterecord = $row['daterecord'];
	$timestamp = (strtotime($daterecord)+60*60) * 1000;
	$clanmembers = $row['clanmembers'];
	$clanpoints = $row['clanpoints'];
	$data1[] = "[$timestamp, $clanpoints]";
	$data2[] = "[$timestamp, $clanmembers]";
}

// echoing the webpage
echo "
<h2>Knights of Hell</h2>
</section>
<section>
<div class='clan_detail'>
<p>Au dernier relevé, le clan était niveau $clanLevel, nous étions $nbMembers et le clan avait <b>$nbPoints</b> </p><img src='images/trophies.png' />
</div>
</section>
<section>
<div id='GraphTrophy'></div>
</section>
<section>
<div id='GraphMember'></div>
</section>
<section>
<div id='Distribution'></div>
</section>

<script>
var chart1 = new Highcharts.Chart({
	title: {text: 'Evolution des points du clan'},
	chart: {renderTo: 'GraphTrophy'},
	xAxis: {type: 'datetime', tickInterval: 24 * 36e5},
	yAxis: {
		title: {text: 'Trophées'}, 
		min: 0
	},
	legend: {enabled: false},
	series: [{
		name: 'Trophies', 
		data: [", join($data1, ',') ,"]
	}]
});
var chart2 = new Highcharts.Chart({
	title: {text: 'Evolution du nombre de membres du clan'},
	chart: {renderTo: 'GraphMember'},
	xAxis: {type: 'datetime', tickInterval: 24 * 36e5},
	yAxis: {
		allowDecimals: false, 
		min: 0,
		max: 50,
		title: {text: 'Membres'}
	},
	legend: {enabled: false},
	series: [{
		name: 'Trophies', 
		data: [", join($data2, ',') ,"]
	}]
});
var chart3 = new Highcharts.Chart({
	title: {text: 'Distribution des joueurs par leagues'}, 
	chart: {
		plotBackgroundColor: null,
		plotBorderWidth: null,
		plotShadow: false,
		type: 'pie'
	},
	tooltip: {pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'},
	plotOptions: {
		pie: {
			allowPointSelect: true,
			cursor: 'pointer',
			dataLabels: {enabled: false},
			showInLegend: true
		}
	},
	series: [{
		name: 'Ligues',
		colorByPoint: true,
		data: [", join($data3, ','), "]
	}]
});
</script>";

var_dump($Unranked ,$Bronze ,$Silver ,$Gold ,$Crystal ,$Master ,$Champion ,$Titan ,$Legend, $data3);
?>
