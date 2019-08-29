<?php

include 'omdb.class.php';

function
info (string $msg): void
{
	echo $msg . "\n";
}

info ('Version: ' . omdb::getVersion() );

info ('Creating omdb object...');
$o = new omdb();
info ('Done');

info ('Querying by id...');
$imdb_id = 'tt1285016';
try{
	$res = $o -> queryById ($imdb_id);
	print_r ($res);
} catch (Exception $e) {
	info ('Exception raised: ' . $e -> getMessage());
}
info ('url: ' . $o -> getUrl() );

?>
