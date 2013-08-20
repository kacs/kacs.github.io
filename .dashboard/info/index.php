<?php
require_once("oit/ui/dashboard.inc");

echo(XHTML_UI_TOP);
?>

<div id="breadcrumb">
    <dl>
        <dt>&gt; <a href="http://<?php echo(SERVER_NAME."/".WEB_SPACE."/.dashboard/"); ?>" title="dashboard home">home</a></dt>
        <dt>&gt; php info</dt>
        <dd>Breadcrumb</dd>
    </dl>
</div>
<div id="content">
    <h2>php configuration and log</h2>
    <p>
        <a href="config-pretty.php" target="data">configuration (pretty)</a> | 
        <a href="config-raw.php" target="data">configuration (raw)</a> | 
        <a href="log.php" target="data">log</a>
    </p>
    <p>
        <iframe height="400" marginheight="0" marginwidth="0" name="data" src="config-pretty.php" style="margin:0;" width="99%"></iframe>
    </p>
    <p>&nbsp;</p>
</div>


<?php
echo(XHTML_UI_BOTTOM);
?>
