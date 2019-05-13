<?php
/**
 * Created by PhpStorm.
 * User: aryx
 * Date: 2019.05.13.
 * Time: 17:22
 */

?>

<h1>My Files</h1>
<nav class="breadcrumbs" aria-label="breadcrumb">
    <ol class="breadcrumb">

        <?php

        if (!isset($_GET['sub'])) {

            echo "<li class=\"breadcrumb-item active\" aria-current=\"page\"><i class='fas fa-home'></i> Home</li>";

        } else {

            echo "<li class=\"breadcrumb-item\"><a href=\"index.php\"><i class='fas fa-home'></i> Home</a></li>";

            $subdir = trim(filter_input(INPUT_GET, 'sub', FILTER_SANITIZE_STRING));

            $blockedGetKeywords = array(
                ".",
                "..",
                "../"
            );

            if (in_array($subdir, $blockedGetKeywords) || substr($subdir, 0, 1) == "/" || substr($subdir, 0, 1) == "\\" || $subdir == "") {
                exit;
            }

            $subExplode = explode("/", $subdir);
            $allItems = sizeof($subExplode);
            $currentItem = 1;
            foreach ($subExplode as $curDir) {
                if ($allItems == $currentItem) {
                    echo "<li class=\"breadcrumb-item active\" aria-current=\"page\">$curDir</li>";
                } else {
                    echo "<li class=\"breadcrumb-item\"><a href=\"index.php?sub=$curDir\">$curDir</a></li>";
                }
                $currentItem++;
            }

        }

        ?>

    </ol>
</nav>

<?php

$blockedThings = array(
    ".",
    "..",
    "index.php",
    "css",
    "images",
    "site",
    "subpages",
    ".idea",
    "approval"
);

echo "<div class=\"list-group\">";

    $user = "aryx"; // TODO: debug only, add user login stuff

    if (!isset($subdir)) {
        $dir = home_directory_root . $user . "/";
        $subdir = "";
    } else {
        $dir = home_directory_root . $user . "/{$subdir}/";
        $subdir .= "/";
    }

    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {

                    if (!in_array($file, $blockedThings)) {

                        if (filetype($dir . $file) == "dir") {
                            echo "<a href=\"index.php?sub=$subdir$file\" class=\"list-group-item d-flex justify-content-between align-items-center list-group-item-action\"><div><i class='fas fa-folder fa-fw'></i> $file</div>";
                            $dirb = $dir . $file;
                            $count = 0;
                            if (is_dir($dirb)) {
                                if ($dhb = opendir($dirb)) {
                                    while (($fileb = readdir($dhb)) !== false) {

                                        if (!in_array($fileb, $blockedThings)) {
                                            $count++;
                                        }

                                    }
                                    closedir($dhb);
                                }
                            }
                            // aztán kiírjuk badge-be
                            echo "<span class=\"badge badge-primary my-2 my-lg-0\">$count item(s)</span>";
                        } else {
                            $fileicon = generateFaIcon($subdir . $file);
                            echo "<a href=\"download.php?file=$subdir$file\" class=\"list-group-item d-flex justify-content-between align-items-center list-group-item-action\"><div><i class='fas $fileicon fa-fw'></i> $file</div>";
                            echo "<span class=\"badge badge-secondary\">".round(filesize($dir . $file)/1024/1024,2)." MB</span>";
                        }

                        echo "</a>";

                    }

            }
            closedir($dh);
        }
    }



echo "</div>";

?>
