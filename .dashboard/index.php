<?php
require_once("oit/ui/dashboard.inc");

echo(XHTML_UI_TOP);
?>

<div id="breadcrumb">
    <dl>
        <dt>&gt; home</dt>
        <dd>Breadcrumb</dd>
    </dl>
</div>
<div id="content">
    <h2>web space information and tools</h2>
    <p>
        Welcome to the dashboard for the &quot;<?php echo(WEB_SPACE); ?>&quot; web 
        space. &nbsp;From here you can review:
        <ul>
            <li>Details of the php configuration</li>
            <li>The amounts of allocated and used disk space</li>
        </ul>
    </p>
    <p>&nbsp;</p>
</div>

<?php
echo(XHTML_UI_BOTTOM);
?>
