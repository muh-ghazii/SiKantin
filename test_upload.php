<?php
echo "upload_tmp_dir: " . ini_get("upload_tmp_dir") . "\n";
echo "is_writable: " . (is_writable(ini_get("upload_tmp_dir") ?: sys_get_temp_dir()) ? "true" : "false") . "\n";
echo "sys_get_temp_dir: " . sys_get_temp_dir() . "\n";
echo "upload_max_filesize: " . ini_get("upload_max_filesize") . "\n";
echo "post_max_size: " . ini_get("post_max_size") . "\n";
