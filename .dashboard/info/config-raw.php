<?php
require_once("oit/ui/dashboard.inc");

$base="/unified/".WEB_USER_INITIAL."/".WEB_USER;
$contents=null;
$file_ini=$base."/".SERVER_NAME."/data/php.ini";
$ini="";
if(is_file($file_ini)) {
    $contents=file($file_ini);
    foreach($contents as $number=>$line) {
        $ini.=htmlentities($line);
    }
} else {
    $ini="ERROR: php.ini could not be found!";
}
?>

<html>
    <head>
        <title><?php echo(WEB_SPACE." php ini file"); ?></title>
    </head>
    <body>
<pre style="font:normal 0.75em monospace;">
<?php echo($ini); ?>

</pre>
    </body>
</html>
