<?php

function mysystem($command) {
    if (!($p=popen("($command)2>&1","r"))) { 
        return 126;
    }

    $out = "";
    while (!feof($p)) {
        $line=fgets($p,1000);
        $out .= $line;

    }
    pclose($p);
    return $out; 

}
