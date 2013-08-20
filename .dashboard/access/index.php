<?php
require_once("oit/ui/dashboard.inc");

$base="/unified/".WEB_USER_INITIAL."/".WEB_USER;
$file_bnids=$base."/.conf/bnids.dat";
$file_restrictions=$base."/".SERVER_NAME."/.dashboard/.conf/restrictions.dat";
$file_users=$base."/.htpasswd";
$records=null;

echo(XHTML_UI_TOP);
?>

<div id="breadcrumb">
    <dl>
        <dt>&gt; <a href="http://<?php echo(SERVER_NAME."/".WEB_SPACE."/.dashboard/"); ?>" title="home">home</a></dt>
        <dt>&gt; access control</dt>
        <dd>Breadcrumb</dd>
    </dl>
</div>
<div id="content">
    <h2>access control</h2>
    <p>
    From these pages, define, modify and delete access restrictions for directories 
    within the <?php echo(WEB_SPACE); ?> web space.
    </p>
    <h3>restrictions</h3>
<pre>
<?php
if(is_file($file_restrictions)) {
    $records=file($file_restrictions);
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
    <h3>bronco netids</h3>
<pre>
<?php
if(is_file($file_bnids)) {
    $records=file($file_bnids);
    if((is_array($records))&&(count($records))) {
        foreach($records as $record) {
            echo($record);
        }
    } else {
        echo("none are defined.");
    }
} else {
    echo("none are defined.");
}
?>
</pre>
    <h3>users</h3>
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
