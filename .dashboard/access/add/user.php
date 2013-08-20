<?php
require_once("oit/ui/dashboard.inc");

$base="/unified/".WEB_USER_INITIAL."/".WEB_USER;
$file_users=$base."/.htpasswd";
$handle_file=null;
$message_dirs="";
$message_file="";
$url_return="/".WEB_SPACE."/.dashboard/access/";
if(isset($_POST["return"])) {
    $url_return=$_POST["return"];
}

if((isset($_POST["user"]))&&(isset($_POST["pass"]))) {
    $pass=$_POST["pass"];
    $user=$_POST["user"];
    if(is_file($file_users)) {
        $command="/usr/bin/htpasswd -bm $file_users $user $pass 2>&1";
        $exit_code=-1;
        $output=array();
        exec($command,$output,$exit_code);
        foreach($output as $line) {
            $message_dirs.=$line."\n";
        }
    } else {
        $command="/usr/bin/htpasswd -cbm $file_users $user $pass 2>&1";
        $exit_code=-1;
        $output=array();
        exec($command,$output,$exit_code);
        foreach($output as $line) {
            $message_dirs.=$line."\n";
        }
    }
} else {
    $message_dirs="Error: a valid user name was not supplied.";
}

echo(XHTML_UI_TOP);
?>

<div id="breadcrumb">
    <dl>
        <dt>&gt; <a href="http://<?php echo(SERVER_NAME."/".WEB_SPACE."/.dashboard/"); ?>" title="home">home</a></dt>
        <dt>&gt; <a href="http://<?php echo(SERVER_NAME."/".WEB_SPACE."/.dashboard/access"); ?>" title="access control">access control</a></dt>
        <dt>&gt; add user</a></dt>
        <dd>Breadcrumb</dd>
    </dl>
</div>
<div id="content">
    <h2>add user</h2>
<pre>
<?php echo($message_dirs); ?>
</pre>
    <p>
        <a href="<?php echo($url_return); ?>" title="return"> return </a>
    </p>
    <h3>user list</h3>
<pre>
<?php
if(is_file($file_users)) {
    $records=file($file_users);
    if((is_array($records))&&(count($records))) {
        foreach($records as $record) {
            echo(substr($record,0,(strpos($record,":")))."\n");
        }
    } else {
        echo("none are defined.");
    }
} else {
    echo("none are defined.");
}
?>
</pre>
    <p>&nbsp;</p>
</div>

<?php
echo(XHTML_UI_BOTTOM);
?>
