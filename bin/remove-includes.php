<?php


# grab all files
$opts = getopt("d:");

if(empty($opts["d"]))
	exit(1);

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($opts["d"]));

$files = iterator_to_array($iterator);
$files = array_filter($files, function(SplFileInfo $file) {
	return preg_match("/.php$/", $file->getFileName());
});


# now we have these files, proceed through them and 
foreach($files as $file)
{
	$contents = file_get_contents($file->getPathName());
	
	foreach([ "require_once" ] as $operator)
	{
		$contents = preg_replace_callback('@(?<!\Q//\E\s)'.preg_quote($operator).'\\s+\'(Zend.*?)\';@', function($matches) {
			return "// ".$matches[0];
		}, $contents);
		
		$contents = preg_replace_callback('@(?<!\Q//\E\s)'.preg_quote($operator).'\\s+"(Zend.*?)";@', function($matches) {
			return "// ".$matches[0];
		}, $contents);
	}
	
	file_put_contents($file->getPathName(), $contents);
	
	echo "Processed ".$file->getPathName().PHP_EOL;
}