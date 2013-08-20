<?php
require_once("oit/ui/dashboard.inc");

$base="/unified/".WEB_USER_INITIAL."/".WEB_USER;
$file_bnids=$base."/.conf/bnids.dat";
$handle_file=null;
$message_dirs="";
$message_file="";

if(isset($_POST["bnid"])) {
    $attributes=array("uid");
    $bind_dn="uid=vflags,ou=special,ou=people,o=wmich.edu,dc=wmich,dc=edu";
    $bind_pass="6Flags/Michigan";
    $bind_user="vflags";
    $bnid=$_POST["bnid"];
    $filter="uid=".$bnid;
    $search_base="ou=people,o=wmich.edu,dc=wmich,dc=edu";
    $server="dir.wmich.edu";

    $connection=ldap_connect($server);
    $bind=ldap_bind($connection,$bind_dn,$bind_pass);
    if($bind) {
        $result=ldap_search($connection,$search_base,$filter,$attributes);
        if(is_resource($result)) {
            $entries=ldap_get_entries($connection,$result);
            if($entries["count"]==0) {
                $message_dirs="Could not find $bnid in the list of bronco netids.";
            } else {
                $message_dirs="Found bronco net id $bnid.";
                exec("/bin/grep $bnid $file_bnids",$output,$exit_code);
                if($exit_code==1) {
                    $handle_file=fopen($file_bnids,"a");
                    if(is_resource($handle_file)) {
                        if(fwrite($handle_file,$bnid."\n")===false) {
                            $message_file="Error: could not write to the bronco netid data file for ".WEB_SPACE.".";
                        } else {
                            $message_file="The bronco netid was added to ".WEB_SPACE."'s list.";
                        }
                        fclose($handle_file);
                    } else {
                        $message_file="Error: could not open the bronco netid data file for ".WEB_SPACE.".";
                    }
                } else {
                    $message_file="The bronco netid $bnid is already in the list for ".WEB_SPACE."; skipping.";
                }
            }
        } else {
            $message_dirs="Error: ldap search failed.";
        }
    } else {
        $message_dirs="Error: could not bind to ldap server.";
    }
} else {
    $message_dirs="Error: a valid bronco netid was not supplied.";
}


echo(XHTML_UI_TOP);
?>

<div id="breadcrumb">
    <dl>
        <dt>&gt; <a href="http://<?php echo(SERVER_NAME."/".WEB_SPACE."/.dashboard/"); ?>" title="home">home</a></dt>
        <dt>&gt; <a href="http://<?php echo(SERVER_NAME."/".WEB_SPACE."/.dashboard/access"); ?>" title="access control">access control</a></dt>
        <dt>&gt; add bronco netid</a></dt>
        <dd>Breadcrumb</dd>
    </dl>
</div>
<div id="content">
    <h2>add bronco netid</h2>
<pre>
<?php echo($message_dirs); ?>

<?php echo($message_file); ?>
</pre>
<h3>bronco netid list</h3>
<pre>
<?php
if(is_file($file_bnids)) {
    $records=file($file_bnids);
    if((is_array($records))&&(count($records))) {
        print_r($records);
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
