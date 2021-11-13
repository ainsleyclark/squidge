<?php

function analyse_attachment($id)
{

    // TODO Get all sizes from attachement in Wordpress and convert them.
    $attachment = get_attached_file($id); // Gets path to attachment

    convert_webp($attachment);
    error_log($attachment);
}

/**
 * @param string $path
 */
function convert_webp(string $path) {
    if (!command_exist("cwebp")) {
        error_log("AC Theme - cwebp is not installed");
        return;
    }
    exec("cwebp -q 80 ".$path." -o ".$path.".webp ");
}

function command_exist($cmd) {
    $return = shell_exec(sprintf("which %s", escapeshellarg($cmd)));
    return !empty($return);
}

add_action("add_attachment", 'analyse_attachment');
add_action("edit_attachment", 'analyse_attachment');



function delete_webp($id) {

    // Delete all sizes from attachment in wordpress
    $attachment = get_attached_file($id); // Gets path to attachment



    unlink($attachment.".webp");

}

add_action('delete_attachment', 'delete_webp');
//
//$output=null;
//$retval=null;
//exec('whoami', $output, $retval);
//echo "Returned with status $retval and output:\n";
//print_r($output);