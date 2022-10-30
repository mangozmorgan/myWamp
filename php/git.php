<?php
$path = '../../Login_register';
chdir($path);
$your_command = `git status --pretty=%h`;
//exec("git add .");
//$res = exec("git status'");
exec("whoami");
exec($your_command.' 2>&1', $output, $return_var);
//var_dump($output);
nicePrint($return_var);
nicePrint($your_command);

echo "<h3 align = center> Succesfully commited all the files.</h3>";