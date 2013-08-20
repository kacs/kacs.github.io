<?php
require_once("oit/ui/dashboard.inc");


$command="quota -v";
$exit_code=-1;
$output=array();

exec($command,$output,$exit_code);

// extract values from output
$lines=array();
foreach($output as $item) {
    $line=array();
    // create and array out of the elements of each line 
    // delimited by a space.
    $fields=explode(" ",$item);
    foreach($fields as $field) {
        // rebuild the line, minus blanks
        if(strcmp("",$field)) {
            array_push($line,$field);
        }
    }
    // reassemble output
    array_push($lines,$line);
}

// cut off the first two lines of output
$lines=array_slice($lines,2);

// strip off the hostname of the nfs server for lines that 
// define mount name/path
foreach($lines as $number=>$line) {
    if(preg_match('/webctrl.it.wmich.edu:/',$line[0])) {
        $position_colon=strpos($line[0],":");
        if($position_colon!==false) {
            $lines[$number]=substr($line[0],($position_colon+1));
        }
    }
}

$volume="";
$quotas=array();
// create an array where each element index is the mount name, 
// and the value of each element is a comma-delimited list of 
// quota values.
foreach($lines as $number=>$line) {
    if(is_array($lines[$number])) {
        // data field line
        $delimited_fields="";
        for($field=0;$field<count($lines[$number]);$field++) {
            $delimiter=",";
            if(preg_match('/\*/',$lines[$number][$field])) {
                // quota has been exceeded, grab grace value
                // usage
                if($field==0) {
                    $delimited_fields.=substr($lines[$number][$field],0,-1);
                } else {
                    $delimited_fields.=$delimiter.substr($lines[$number][$field],0,-1);
                }
                // quota
                $delimited_fields.=$delimiter.$lines[$number][++$field];
                // limit
                $delimited_fields.=$delimiter.$lines[$number][++$field];
                // grace
                if((preg_match('/[0-9]days/',$lines[$number][($field+1)]))||
                   (preg_match('/[0-9]:[0-9]/',$lines[$number][($field+1)]))) {
                    // in grace period
                    $delimited_fields.=$delimiter.$lines[$number][++$field];
                } else {
                    // grace period expired
                    $delimited_fields.=$delimiter."-2";
                }
            } else {
                // quota is in limits, set grace value to -1
                // usage
                if($field==0) {
                    $delimited_fields.=$lines[$number][$field];
                } else {
                    $delimited_fields.=$delimiter.$lines[$number][$field];
                }
                // quota
                $delimited_fields.=$delimiter.$lines[$number][++$field];
                // limit
                $delimited_fields.=$delimiter.$lines[$number][++$field];
                // grace
                $delimited_fields.=$delimiter."-1";
            }
        }
        // assign values to volume element
        switch(ENVIRONMENT_NAME) {
        case "development":
            if(!strcmp($volume,"/SAN/data/special")) {
                $quotas[$volume]=$delimited_fields;
            }
            break;
        case "testing":
            if(!strcmp($volume,"/SAN/data/dept")) {
                $quotas[$volume]=$delimited_fields;
            }
            break;
        case "production":
            if(!strcmp($volume,"/SAN/data/www")) {
                $quotas[$volume]=$delimited_fields;
            }
            break;
        }
    } else {
        // volume name/path line
        $volume=$lines[$number];
    }
}

echo(XHTML_UI_TOP);
?>

<div id="breadcrumb">
    <dl>
        <dt>&gt; <a href="http://<?php echo(SERVER_NAME."/".WEB_SPACE."/.dashboard/"); ?>" title="dashboard home">home</a></dt>
        <dt>&gt; quota</dt>
        <dd>Breadcrumb</dd>
    </dl>
</div>
<div id="content">
    <h2>quota</h2>
<?php
foreach($quotas as $volume=>$data) {
    list(
        $block_usage,$block_quota,$block_limit,$block_grace,
        $inode_usage,$inode_quota,$inode_limit,$inode_grace
        )=explode(",",$data);

    $percent_block=(($block_usage/$block_quota)*100);
    $percent_inode=(($inode_usage/$inode_quota)*100);

    if($percent_block>=100) {
        $style_block="class=\"slide_full\" style=\"width:100%\"";
    } else {
        if($percent_block>=75) {
            $style_block="class=\"slide_more\" style=\"width:".round($percent_block,1)."%\"";
        } else {
            if($percent_block>=50) {
                $style_block="class=\"slide_less\" style=\"width:".round($percent_block,1)."%\"";
            } else {
                if($percent_block>1) {
                    $style_block="class=\"slide_empty\" style=\"width:".round($percent_block,1)."%\"";
                } else {
                    $style_block="class=\"slide_empty\" style=\"width:1%\"";
                }
            }
        }
    }

    if($percent_inode>=100) {
        $style_inode="class=\"slide_full\" style=\"width:100%\"";
    } else {
        if($percent_inode>=75) {
            $style_inode="class=\"slide_more\" style=\"width:".round($percent_inode)."%\"";
        } else {
            if($percent_inode>=50) {
                $style_inode="class=\"slide_less\" style=\"width:".round($percent_inode)."%\"";
            } else {
                if($percent_inode>1) {
                    $style_inode="class=\"slide_empty\" style=\"width:".round($percent_inode)."%\"";
                } else {
                    $style_inode="class=\"slide_empty\" style=\"width:1%\"";
                }
            }
        }
    }

    if(!strcmp(WEB_SPACE,"")) {
        $quota_title=SERVER_NAME."/";
    } else {
        $quota_title=SERVER_NAME."/".WEB_SPACE."/";
    }
    if(!strcmp($volume,"/SAN/data/unified")) {
        $quota_title="\"".WEB_USER."\" account's unified storage";
    }
?>
    <div class="quota">
        <div class="label">
        <?php echo($quota_title); ?>

        </div>
        <div class="info">
        <?php echo(round($block_usage/1000,1)."/".round($block_quota/1000,1)); ?>M disk used
        (<?php echo(round($percent_block,1)); ?>%)
        </div>
        <div class="slider">
            <div <?php echo($style_block); ?>>
            </div>
        </div>
<?php
    if($percent_block>=100) {
        $buffer_total=round(($block_limit-$block_quota)/1000,1);
        $buffer_usage=round(($block_usage-$block_quota)/1000,1);
        $percent_buffer=(($buffer_usage/$buffer_total)*100);
        if($percent_buffer>=100) {
            $style_buffer="class=\"slide_buffer\" style=\"width:100%\"";
        } else {
            $style_buffer="class=\"slide_buffer\" style=\"width:".round($percent_buffer,1)."%\"";
        }
        if(strcmp("",$block_grace)) {
            if(preg_match("/(days|hours)/",$block_grace)) {
                $block_grace=preg_replace("/(\d+)(\w+)/","$1 $2",$block_grace);
            }
            if(preg_match("/49709/",$block_grace)) {
                $block_grace="EXPIRED";
            }
        }
        if(!strcmp($block_grace,"EXPIRED")) {
?>
        <div class="error_label">
            disk quota is exceeded, and the 7 day time limit has expired. &nbsp;file write access for the 
            <?php echo(WEB_USER); ?> account, in the <?php echo(ENVIRONMENT_NAME); ?> environment, has 
            been suspended.
        </div>
<?php
        } elseif($percent_buffer>=100) {
?>
        <div class="error_label">
            disk quota is exceeded, as well as the disk limit. &nbsp;file write access for the 
            <?php echo(WEB_USER); ?> account, in the <?php echo(ENVIRONMENT_NAME); ?> environment, has 
            been suspended.
        </div>
<?php
        } else {
?>
        <div class="error_label">
            disk quota is exceeded; file write access ends in <?php echo($block_grace); ?>.
        </div>
        <div class="error_info">
            this account currently has an overflow limit of <?php echo(round($block_limit/1000,1)); ?>M. 
            that leaves a buffer of <?php echo($buffer_total); ?>M. this account is currently using 
            <?php echo($buffer_usage); ?>M of that buffer.  once the disk usage reaches the limit, 
            or after the next <?php echo($block_grace); ?> is passed, file uploads will no longer be 
            allowed and scripts will not be able to write to files in this account's disk space.
        </div>
<?php
        }
?>
        <div class="error_info">
            buffer usage: <?php echo($buffer_usage."/".$buffer_total."M") ?>
            (<?php echo(round($percent_buffer,1)); ?>%)
        </div>
        <div class="error_slider">
            <div <?php echo($style_buffer); ?>>
            </div>
        </div>
<?php
    }
?>
        <div class="info">
        <?php echo($inode_usage."/".$inode_quota); ?> files allowed 
        (<?php echo(round($percent_inode,1)); ?>%)
        </div>
        <div class="slider">
            <div <?php echo($style_inode); ?>>
            </div>
        </div>
<?php
    if($percent_inode>=100) {
        $buffer_total=$inode_limit-$inode_quota;
        $buffer_usage=$inode_usage-$inode_quota;
        $percent_buffer=(($buffer_usage/$buffer_total)*100);
        if($percent_buffer>=100) {
            $style_buffer="class=\"slide_buffer\" style=\"width:100%\"";
        } else {
            $style_buffer="class=\"slide_buffer\" style=\"width:".round($percent_buffer,1)."%\"";
        }
        if(strcmp("",$inode_grace)) {
            if(preg_match("/(days|hours)/",$inode_grace)) {
                $inode_grace=preg_replace("/(\d+)(\w+)/","$1 $2",$inode_grace);
            }
            if(preg_match("/49709/",$inode_grace)) {
                $inode_grace="EXPIRED";
            }
        }
        if(!strcmp($inode_grace,"EXPIRED")) {
?>
        <div class="error_label">
            file quota is exceeded, and the 7 day time limit has expired. &nbsp;file write access for the 
            <?php echo(WEB_USER); ?> account, in the <?php echo(ENVIRONMENT_NAME); ?> environment, has 
            been suspended.
        </div>
<?php
        } elseif($percent_buffer>=100) {
?>
        <div class="error_label">
            file quota is exceeded, as well as the file limit. &nbsp;file write access for the 
            <?php echo(WEB_USER); ?> account, in the <?php echo(ENVIRONMENT_NAME); ?> environment, has 
            been suspended.
        </div>
<?php
        } else {
?>
        <div class="error_label">
            file quota is exceeded; file write access ends in <?php echo($inode_grace); ?>.
        </div>
        <div class="error_info">
            this account currently has an overflow limit of <?php echo($inode_limit); ?> files. 
            that leaves a buffer of <?php echo($buffer_total); ?> files. this account is currently using 
            <?php echo($buffer_usage); ?> files of that buffer.  once the file usage reaches the limit, 
            or after the next <?php echo($inode_grace); ?> has passed, file uploads will no longer be 
            allowed and scripts will not be able to write to or create files in this account's disk 
            space.
        </div>
<?php
        }
?>
        <div class="error_info">
            buffer usage: <?php echo($buffer_usage."/".$buffer_total." files") ?>
            (<?php echo(round($percent_buffer,1)); ?>%)
        </div>
        <div class="error_slider">
            <div <?php echo($style_buffer); ?>>
            </div>
        </div>
<?php
    }
?>
    </div>
<?php
}
?>
    <p>&nbsp;</p>
</div>

<?php
echo(XHTML_UI_BOTTOM);
?>
