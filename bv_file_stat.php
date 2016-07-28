<?php
/* This file is used to get file stat during migration/restore */
global $bvRespArray;
$bvRespArray = array("signature" => "blogVault API");
$_REQUEST = array_merge($_GET, $_POST);
define('ABSPATH', dirname(__FILE__) . '/');
function bvStatusAdd($key, $value) {
	global $bvRespArray;
	$bvRespArray[$key] = $value;
}

function bvStatusAddArray($key, $value) {
	global $bvRespArray;
	if (!isset($bvRespArray[$key])) {
		$bvRespArray[$key] = array();
	}
	$bvRespArray[$key][] = $value;
}

$fhash = array();
$files = $_REQUEST['files'];
foreach($files as $file) {
	$relfile = base64_decode($file);
	$absfile = ABSPATH.$relfile;
	while (strlen($relfile) > 2 && $relfile != "./") {
		$stats = @stat($absfile);
		if ($stats) {
			$fdata = array();
			foreach(preg_grep('#size|uid|gid|mode|mtime#i', array_keys($stats)) as $key ) {
				$fdata[$key] = $stats[$key];
			}
			$fdata["filename"] = $relfile;
			$fhash[$relfile] = $fdata;
		}
		$relfile = dirname($relfile)."/";
		$absfile = ABSPATH.$relfile;
	}
}
foreach($fhash as $key => $file) {
	bvStatusAddArray("files", $file);
}
bvStatusAdd("signature", "Blogvault API");
die("bvbvbvbvbv".serialize($bvRespArray)."bvbvbvbvbv");
?>