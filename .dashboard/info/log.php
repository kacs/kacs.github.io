<?php
require_once("oit/ui/dashboard.inc");

$base="/unified/".WEB_USER_INITIAL."/".WEB_USER;
$contents=null;
$file_log=$base."/".SERVER_NAME."/data/php.log";
$log="";
if(is_file($file_log)) {
    $contents=array_reverse(file($file_log));
    foreach($contents as $number=>$line) {
        $log.=htmlentities($line);
    }
} else {
    $log="log file is empty";
}
?>

<html>
    <head>
        <title><?php echo(WEB_SPACE." php log file"); ?></title>
    </head>
    <body>
<pre style="font:normal 0.75em monospace;">
<?php echo(wordwrap($log,70)); ?>

</pre>
    </body>
</html>
