<?php
$files = glob('database/seeds/*.php');
foreach($files as $file) {
    $content = file_get_contents($file);
    if(strpos($content, "DB::table(") !== false && strpos($content, "truncate()") !== false) {
        $content = preg_replace("/(DB::table\('[a-zA-Z0-9_]+'\)->truncate\(\);)/", "DB::statement('SET FOREIGN_KEY_CHECKS=0;');\n        $1\n        DB::statement('SET FOREIGN_KEY_CHECKS=1;');", $content);
        // Clean up double applications
        $content = preg_replace("/DB::statement\('SET FOREIGN_KEY_CHECKS=0;'\);\s*DB::statement\('SET FOREIGN_KEY_CHECKS=0;'\);/s", "DB::statement('SET FOREIGN_KEY_CHECKS=0;');", $content);
        $content = preg_replace("/DB::statement\('SET FOREIGN_KEY_CHECKS=1;'\);\s*DB::statement\('SET FOREIGN_KEY_CHECKS=1;'\);/s", "DB::statement('SET FOREIGN_KEY_CHECKS=1;');", $content);
        file_put_contents($file, $content);
    }
}
echo "Fixed seeders.\n";
