<?php
require_once("oit/ui/dashboard.inc");

$base="/unified/".WEB_USER_INITIAL."/".WEB_USER;
$file_bnids=$base."/.conf/bnids.dat";
$file_restrictions=$base."/".SERVER_NAME."/.dashboard/.conf/restrictions.dat";
$file_users=$base."/.htpasswd";
$records=null;
$url_return=$_SERVER["REQUEST_URI"];

echo(XHTML_UI_TOP);
?>

<div id="breadcrumb">
    <dl>
        <dt>&gt; <a href="http://<?php echo(SERVER_NAME."/".WEB_SPACE."/.dashboard/"); ?>" title="home">home</a></dt>
        <dt>&gt; <a href="http://<?php echo(SERVER_NAME."/".WEB_SPACE."/.dashboard/access"); ?>" title="access control">access control</a></dt>
        <dt>&gt; add</a></dt>
        <dd>Breadcrumb</dd>
    </dl>
</div>
<div id="content">
    <h2>add</h2>
    <p>
    From these pages, define users and/or a list of bronco net ids to be used 
    with the access restrictions defined for the <?php echo(WEB_SPACE); ?> web 
    space.
    </p>
    <h3>users</h3>
    <p>
    This is a list of custom users that have been defined for use. 
    </p>
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
    <p>
        <form action="user.php" method="post">
            <input name="origin" type="hidden" value="<?php echo($url_return); ?>" />
            add a user: 
            <input name="user" type="text" /> 
            password: 
            <input name="pass" type="password" /> 
            <input name="add_user" type="submit" value=" + " />
        </form>
    </p>
    <h3>bronco netids</h3>
    <p>
    This is a list of bronco netids that have been used before. 
    </p>
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
    <p>
        <form action="bnid.php" method="post">
            <input name="origin" type="hidden" value="<?php echo($url_return); ?>" />
            add a bronco netid: 
            <input name="bnid" type="text" />
            <input name="add_bnid" type="submit" value=" + " />
        </form>
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
    <p>
        <form action="restriction.php" method="post">
            <input name="origin" type="hidden" value="<?php echo($url_return); ?>" />
            <input name="step" type="hidden" value="1" />
            add a restriction: 
            <input name="add_restriction" type="submit" value=" + " />
        </form>
    </p>
    <p>&nbsp;</p>
</div>

<?php
echo(XHTML_UI_BOTTOM);
?>
