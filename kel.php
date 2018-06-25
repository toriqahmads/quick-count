<?php

$c = curl_init();

curl_setopt($c, CURLOPT_URL, "http://www.organisasi.org/1970/01/daftar-nama-kecamatan-kelurahan-desa-kodepos-di-kota-kabupaten-demak-jawa-tengah-jateng.html");
curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($c, CURLOPT_HEADER, 0);

$response = curl_exec($c);

preg_match_all('#Kecamatan (.*)</strong>#', $response, $kec);

preg_match_all("#- Kelurahan\/Desa (.*)\s#", $response, $kel);

for($i=0; $i<count($kel[1]); $i++)
{
	preg_match_all("/(?:([a-zA-Z]{1,}\s[a-zA-Z]{1,})|([a-zA-Z]{1,}))/", $kel[1][$i], $kels[$i]);
}

for($i=0; $i<count($kel[1]); $i++)
{
	preg_match_all("#[0-9]{1,}#", $kel[1][$i], $kkod[$i]);
}

for($j=0; $j<count($kels); $j++)
	{
		$res['kec'][] = $kels[$j][0][0];
	}

for($j=0; $j<count($kels); $j++)
	{
		$res['kod'][] = $kkod[$j][0][0];
	}

for($i=0; $i<count($res['kec']); $i++)
{
	$result['bonang']['kel'][] = $res['kec'][$i];
	$result['bonang']['kod'][] = $res['kod'][$i];

	if($res['kec'][$i] == "Wonosari")
	{
		break;
	}
}

for($i=21; $i<count($res['kec']); $i++)
{
	$result['demak']['kel'][] = $res['kec'][$i];
	$result['demak']['kod'][] = $res['kod'][$i];

	if($res['kec'][$i] == "Turirejo")
	{
		break;
	}
}

for($i=40; $i<count($res['kec']); $i++)
{
	$result['dempet']['kel'][] = $res['kec'][$i];
	$result['dempet']['kod'][] = $res['kod'][$i];

	if($res['kec'][$i] == "Sidomulyo")
	{
		break;
	}
}

for($i=56; $i<count($res['kec']); $i++)
{
	$result['gajah']['kel'][] = $res['kec'][$i];
	$result['gajah']['kod'][] = $res['kod'][$i];

	if($res['kec'][$i] == "Wilalung")
	{
		break;
	}
}

for($i=74; $i<count($res['kec']); $i++)
{
	$result['guntur']['kel'][] = $res['kec'][$i];
	$result['guntur']['kod'][] = $res['kod'][$i];

	if($res['kec'][$i] == "Wonorejo")
	{
		break;
	}
}

for($i=94; $i<count($res['kec']); $i++)
{
	$result['karang_tengah']['kel'][] = $res['kec'][$i];
	$result['karang_tengah']['kod'][] = $res['kod'][$i];

	if($res['kec'][$i] == "Wonowoso")
	{
		break;
	}
}

for($i=111; $i<count($res['kec']); $i++)
{
	$result['karanganyar']['kel'][] = $res['kec'][$i];
	$result['karanganyar']['kod'][] = $res['kod'][$i];

	if($res['kec'][$i] == "Wonorejo")
	{
		break;
	}
}

for($i=128; $i<count($res['kec']); $i++)
{
	$result['karangawen']['kel'][] = $res['kec'][$i];
	$result['karangawen']['kod'][] = $res['kod'][$i];

	if($res['kec'][$i] == "Wonosekar")
	{
		break;
	}
}

for($i=141; $i<count($res['kec']); $i++)
{
	$result['Kebonagung']['kel'][] = $res['kec'][$i];
	$result['Kebonagung']['kod'][] = $res['kod'][$i];

	if($res['kec'][$i] == "Werdoyo")
	{
		break;
	}
}

for($i=154; $i<count($res['kec']); $i++)
{
	$result['Mijen']['kel'][] = $res['kec'][$i];
	$result['Mijen']['kod'][] = $res['kod'][$i];

	if($res['kec'][$i] == "Tanggul")
	{
		break;
	}
}
for($i=169; $i<count($res['kec']); $i++)
{
	$result['Mranggen']['kel'][] = $res['kec'][$i];
	$result['Mranggen']['kod'][] = $res['kod'][$i];

	if($res['kec'][$i] == "Wringin Jajar")
	{
		break;
	}
}

for($i=188; $i<count($res['kec']); $i++)
{
	$result['Sayung']['kel'][] = $res['kec'][$i];
	$result['Sayung']['kod'][] = $res['kod'][$i];

	if($res['kec'][$i] == "Tugu")
	{
		break;
	}
}

for($i=208; $i<count($res['kec']); $i++)
{
	$result['Wedung']['kel'][] = $res['kec'][$i];
	$result['Wedung']['kod'][] = $res['kod'][$i];

	if($res['kec'][$i] == "Wedung")
	{
		break;
	}
}

for($i=228; $i<count($res['kec']); $i++)
{
	$result['Wonosalam']['kel'][] = $res['kec'][$i];
	$result['Wonosalam']['kod'][] = $res['kod'][$i];

	if($res['kec'][$i] == "Wonosalam")
	{
		break;
	}
}

// echo '<pre>';
// print_r($result['demak']['kel']).PHP_EOL;
// echo '</pre>';

/*$conn = mysqli_connect('localhost','root','','qcount') or die('gagal');

for($i=0; $i<count($result['demak']['kel']); $i++)
{
	$sql = "INSERT INTO kel (kel, pos, id_kec, id_kab, id_prov) VALUES('".$result['demak']['kel'][$i]."', '".$result['demak']['kod'][$i]."', 1, 1, 1)";

	if (mysqli_query($conn, $sql)) {
		echo 'berhasil'."<br>";
	}
}

for($i=0; $i<count($result['dempet']['kel']); $i++)
{
	$sql = "INSERT INTO kel (kel, pos, id_kec, id_kab, id_prov) VALUES('".$result['dempet']['kel'][$i]."', '".$result['dempet']['kod'][$i]."', 2, 1, 1)";

	if (mysqli_query($conn, $sql)) {
		echo 'berhasil'."<br>";
	}
}

for($i=0; $i<count($result['Kebonagung']['kel']); $i++)
{
	$sql = "INSERT INTO kel (kel, pos, id_kec, id_kab, id_prov) VALUES('".$result['Kebonagung']['kel'][$i]."', '".$result['Kebonagung']['kod'][$i]."', 3, 1, 1)";

	if (mysqli_query($conn, $sql)) {
		echo 'berhasil'."<br>";
	}
}

for($i=0; $i<count($result['Wonosalam']['kel']); $i++)
{
	$sql = "INSERT INTO kel (kel, pos, id_kec, id_kab, id_prov) VALUES('".$result['Wonosalam']['kel'][$i]."', '".$result['Wonosalam']['kod'][$i]."', 4, 1, 1)";

	if (mysqli_query($conn, $sql)) {
		echo 'berhasil'."<br>";
	}
}

for($i=0; $i<count($result['bonang']['kel']); $i++)
{
	$sql = "INSERT INTO kel (kel, pos, id_kec, id_kab, id_prov) VALUES('".$result['bonang']['kel'][$i]."', '".$result['bonang']['kod'][$i]."', 5, 1, 1)";

	if (mysqli_query($conn, $sql)) {
		echo 'berhasil'."<br>";
	}
}

for($i=0; $i<count($result['Wedung']['kel']); $i++)
{
	$sql = "INSERT INTO kel (kel, pos, id_kec, id_kab, id_prov) VALUES('".$result['Wedung']['kel'][$i]."', '".$result['Wedung']['kod'][$i]."', 6, 1, 1)";

	if (mysqli_query($conn, $sql)) {
		echo 'berhasil'."<br>";
	}
}

for($i=0; $i<count($result['gajah']['kel']); $i++)
{
	$sql = "INSERT INTO kel (kel, pos, id_kec, id_kab, id_prov) VALUES('".$result['gajah']['kel'][$i]."', '".$result['gajah']['kod'][$i]."', 7, 1, 1)";

	if (mysqli_query($conn, $sql)) {
		echo 'berhasil'."<br>";
	}
}

for($i=0; $i<count($result['karanganyar']['kel']); $i++)
{
	$sql = "INSERT INTO kel (kel, pos, id_kec, id_kab, id_prov) VALUES('".$result['karanganyar']['kel'][$i]."', '".$result['karanganyar']['kod'][$i]."', 8, 1, 1)";

	if (mysqli_query($conn, $sql)) {
		echo 'berhasil'."<br>";
	}
}

for($i=0; $i<count($result['Mijen']['kel']); $i++)
{
	$sql = "INSERT INTO kel (kel, pos, id_kec, id_kab, id_prov) VALUES('".$result['Mijen']['kel'][$i]."', '".$result['Mijen']['kod'][$i]."', 9, 1, 1)";

	if (mysqli_query($conn, $sql)) {
		echo 'berhasil'."<br>";
	}
}

for($i=0; $i<count($result['karangawen']['kel']); $i++)
{
	$sql = "INSERT INTO kel (kel, pos, id_kec, id_kab, id_prov) VALUES('".$result['karangawen']['kel'][$i]."', '".$result['karangawen']['kod'][$i]."', 10, 1, 1)";

	if (mysqli_query($conn, $sql)) {
		echo 'berhasil'."<br>";
	}
}

for($i=0; $i<count($result['Mranggen']['kel']); $i++)
{
	$sql = "INSERT INTO kel (kel, pos, id_kec, id_kab, id_prov) VALUES('".$result['Mranggen']['kel'][$i]."', '".$result['Mranggen']['kod'][$i]."', 11, 1, 1)";

	if (mysqli_query($conn, $sql)) {
		echo 'berhasil'."<br>";
	}
}

for($i=0; $i<count($result['guntur']['kel']); $i++)
{
	$sql = "INSERT INTO kel (kel, pos, id_kec, id_kab, id_prov) VALUES('".$result['guntur']['kel'][$i]."', '".$result['guntur']['kod'][$i]."', 12, 1, 1)";

	if (mysqli_query($conn, $sql)) {
		echo 'berhasil'."<br>";
	}
}

for($i=0; $i<count($result['karang_tengah']['kel']); $i++)
{
	$sql = "INSERT INTO kel (kel, pos, id_kec, id_kab, id_prov) VALUES('".$result['karang_tengah']['kel'][$i]."', '".$result['karang_tengah']['kod'][$i]."', 13, 1, 1)";

	if (mysqli_query($conn, $sql)) {
		echo 'berhasil'."<br>";
	}
}

for($i=0; $i<count($result['Sayung']['kel']); $i++)
{
	$sql = "INSERT INTO kel (kel, pos, id_kec, id_kab, id_prov) VALUES('".$result['Sayung']['kel'][$i]."', '".$result['Sayung']['kod'][$i]."', 14, 1, 1)";

	if (mysqli_query($conn, $sql)) {
		echo 'berhasil'."<br>";
	}
}*/
?>