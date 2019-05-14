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
            $path = "";
            foreach ($subExplode as $curDir) {

                if ($path !== "") {
                    $path .= "/";
                }
                $path .= $curDir;

                if ($allItems == $currentItem) {
                    echo "<li class=\"breadcrumb-item active\" aria-current=\"page\">$curDir</li>";
                } else {
                    echo "<li class=\"breadcrumb-item\"><a href=\"index.php?sub=$path\">$curDir</a></li>";
                }
                $currentItem++;
            }

        }

        ?>

    </ol>
</nav>


<div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar">
    <div class="btn-group mr-2" role="group" aria-label="Group">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#fileUploadModal"><i class="fas fa-file-upload"></i> Upload File</button>
        <button type="button" class="btn btn-secondary" id="btn-new-folder-modal-open" data-toggle="modal" data-target="#newFolderModal"><i class="fas fa-folder"></i> New Folder</button>
    </div>
</div>


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

    if (!isset($subdir)) {
        $dir = home_directory_root . $_SESSION['user_name'] . "/";
        $subdir = "";
    } else {
        $dir = home_directory_root . $_SESSION['user_name'] . "/{$subdir}/";
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
                            echo "<a href=\"download.php?file=$subdir$file\" class=\"list-group-item d-flex justify-content-between align-items-center list-group-item-action list-group-file\"><div><i class='fas $fileicon fa-fw'></i> <span class='filename'>$file</span></div>";

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

<div class="dropdown-menu dropdown-menu-sm" id="context-menu">
    <a class="dropdown-item" href="#" id="contextMenuDeleteFile"><i class="fas fa-trash fa-fw"></i> Delete</a>
    <a class="dropdown-item" href="#" id="contextMenuShareFile"><i class="fas fa-share fa-fw"></i> Share</a>
</div>


<div class="modal fade" id="fileUploadModal" tabindex="-1" role="dialog" aria-labelledby="fileUploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fileUploadModalLabel">Upload File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="file" id="file" class="mb-3" multiple>

                <div class="progress">
                    <div class="progress-bar" id="progress-bar-upload" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="btn-upload-file" class="btn btn-primary">Upload</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="newFolderModal" tabindex="-1" role="dialog" aria-labelledby="newFolderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newFolderModalLabel">New Folder</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="newFolderInput">Folder name</label>
                    <input type="text" class="form-control" id="newFolderInput" placeholder="New Folder">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="btn-new-folder" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</div>