<?php
require_once("oit/ui/dashboard.inc");

$current=1;
$fields=null;
$file_htaccess="";
$guests=1;
$origin="";
$path="/".WEB_SPACE;
$steps=array();
$text_htaccess="";

if(isset($_POST["step"])) {
    $current=$_POST["step"];
    session_start();
    if(isset($_SESSION["steps"])) {
        if(is_array($_SESSION["steps"])) {
            $steps=$_SESSION["steps"];
        }
    }
    $fields=array();
    switch($current) {
    case 1:
        if(isset($_POST["origin"])) {
            $_SESSION["origin"]=$_POST["origin"];
        }
    case 2:
        if(isset($_POST["guests"])) {
            $fields["guests"]=$_POST["guests"];
        }
        if(isset($_POST["path"])) {
            $fields["path"]=$_POST["path"];
        }
        break;
    default:
    }
    $steps[$current]=$fields;
    $_SESSION["current"]=$current;
    $_SESSION["steps"]=$steps;
    session_write_close();
    header("Location: https://".SERVER_NAME."/".WEB_SPACE."/.dashboard/access/add/restriction.php");
    exit;
} else {
    session_start();
    echo("<pre>".print_r($_SESSION,true)."</pre>");
    if(isset($_SESSION["current"])) {
        $current=$_SESSION["current"];
    }
    if(isset($_SESSION["current"])) {
        switch($_SESSION["current"]) {
        case 1:
            echo("step one!<br />");
            if(isset($_SESSION["origin"])) {
                $origin=$_SESSION["origin"];
            }
            break;
        case 2:
            echo("step two!<br />");
            if(isset($_SESSION["steps"])) {
                $steps=$_SESSION["steps"];
                $guests=$steps[$current]["guests"];
                $path=$steps[$current]["path"];
            }
            if(isset($_SESSION["origin"])) {
                $origin=$_SESSION["origin"];
            }
            $file_htaccess=$path."/.htaccess";
            $text_htaccess="RewriteEngine On\n";
            $text_htaccess.="RewriteCond %{SERVER_PORT} 80\n";
            $text_htaccess.=" RewriteRule ^(.*)$ https://%{SERVER_NAME}%{REQUEST_URI} [redirect,last]\n";
            switch($guests) {
            case 1:
                break;
            case 2:
                break;
            default:
            }
/*
RewriteEngine On 
RewriteCond %{SERVER_PORT} 80 
RewriteRule ^(.*)$ https://%{SERVER_NAME}%{REQUEST_URI} [redirect,last]

AuthType Basic
AuthName "Your Bronco NetID (bnid) or 'guest' account"
AuthName "Your Bronco NetID (bnid)"
AuthBasicProvider file external
AuthBasicProvider external
AuthUserFile /unified/w/webadmin/x.htpasswd
AuthExternal auth-system
Require valid-user
Require user guest guest2 webadmin webstats
*/

            break;
        default:
        }
    }
    session_write_close();
}


$base="/unified/".WEB_USER_INITIAL."/".WEB_USER;
$exit_code=-1;
$dir_host=$base."/".SERVER_NAME;
$file_bnids=$base."/.conf/bnids.dat";
$file_restrictions=$dir_host."/.dashboard/.conf/restrictions.dat";
$file_users=$base."/.htpasswd";
$find="/usr/bin/find $dir_host/* -type d -print | /bin/egrep -v '/data($|/.*)'";
$handle_dir=null;
$handle_file=null;
$listing="";
$message_dirs="";
$message_file="";
$paths=array();

if(is_dir($dir_host)) {
    exec($find,$paths,$exit_code);
}


echo(XHTML_UI_TOP);
?>

<div id="breadcrumb">
    <dl>
        <dt>&gt; <a href="http://<?php echo(SERVER_NAME."/".WEB_SPACE."/.dashboard/"); ?>" title="home">home</a></dt>
        <dt>&gt; <a href="http://<?php echo(SERVER_NAME."/".WEB_SPACE."/.dashboard/access"); ?>" title="access control">access control</a></dt>
        <dt>&gt; add restriction</a></dt>
        <dd>Breadcrumb</dd>
    </dl>
</div>
<div id="content">
    <h2>add restriction</h2>
<form action="restriction.php" method="post" name="add_restriction">
    <input name="step" type="hidden" value="2" />
    select a path
    <br />
    <select name="path">
        <option value="<?php echo("/".WEB_SPACE); ?>"><?php echo("/".WEB_SPACE); ?></option>
<?php
foreach($paths as $listing) {
    $listing=str_replace($dir_host."/","",$listing);
    $listing="/".WEB_SPACE."/".$listing;
    $selected="";
    if(!strcmp($path,$listing)) {
        $selected="selected=\"selected\" ";
    }
?>
        <option <?php echo($selected); ?>value="<?php echo($listing); ?>"><?php echo($listing); ?></option>
<?php
}
?>
    </select>
    <br />
<?php
$checked="";
if($guests==1) {
    $checked="checked=\"checked\" ";
}
?>
    <input <?php echo($checked); ?>name="guests" onclick="javascript:toggleGuestList(this.value);" type="radio" value="1" /> &nbsp;any valid guest &nbsp;
<?php
$checked="";
if($guests==2) {
    $checked="checked=\"checked\" ";
}
?>
    <input <?php echo($checked); ?>name="guests" onclick="javascript:toggleGuestList(this.value);" type="radio" value="2" /> &nbsp;guest list
    <br />
    <div style="border:1px solid #666666;margin:5px;padding:5px;">
        <table border="1">
            <tr>
                <th colspan="6">guest list</th>
            </tr>
            <tr>
                <th colspan="3">bronco netids</th>
                <th colspan="3">users</th>
            </tr>
            <tr>
                <td>
<select disabled="disabled" id="bnids_removed" multiple="multiple" name="bnids_removed" size="10">
    <option value="none">(none)</option>
<?php
if(is_file($file_bnids)) {
    $records=file($file_bnids);
    if((is_array($records))&&(count($records))) {
        foreach($records as $record) {
?>
    <option value="<?php echo($record); ?>"><?php echo($record); ?></option>
<?php
        }
    } else {
?>
    <option></option>
<?php
    }
} else {
?>
    <option></option>
<?php
}
?>
</select>
                </td>
                <td>
                <input disabled="disabled" id="bnid_add" name="bnid_add" onclick="javascript:moveGuest(this.id);" type="button" value=" &gt; " />
                <br />
                <input disabled="disabled" id="bnid_remove" name="bnid_remove" onclick="javascript:moveGuest(this.id);" type="button" value=" &lt; " />
                </td>
                <td>
<select disabled="disabled" id="bnids_added" multiple="multiple" name="bnids_added" size="10">
    <option value="none">(none)</option>
</select>
                </td>
                <td>
<select disabled="disabled" id="users_removed" multiple="multiple" name="users_removed" size="10">
    <option value="none">(none)</option>
<?php
if(is_file($file_users)) {
    $records=file($file_users);
    if((is_array($records))&&(count($records))) {
        foreach($records as $record) {
            $record=substr($record,0,(strpos($record,":")));
?>
    <option value="<?php echo($record); ?>"><?php echo($record); ?></option>
<?php
        }
    } else {
?>
    <option></option>
<?php
    }
} else {
?>
    <option></option>
<?php
}
?>
                    </select>
                </td>
                <td>
                <input disabled="disabled" id="user_add" name="user_add" onclick="javascript:moveGuest(this.id);" type="button" value=" &gt; " />
                <br />
                <input disabled="disabled" id="user_remove" name="user_remove" onclick="javascript:moveGuest(this.id);" type="button" value=" &lt; " />
                </td>
                <td>
<select disabled="disabled" id="users_added" multiple="multiple" name="users_added" size="10">
    <option value="none">(none)</option>
</select>
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <input name="submit_restriction" type="submit" value=" add... " />
                </td>
            </tr>
        </table>
    </div>
</form>
    <p>&nbsp;</p>
</div>

<?php
echo(XHTML_UI_BOTTOM);
?>
