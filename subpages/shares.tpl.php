<?php
/**
 * Created by PhpStorm.
 * User: aryx
 * Date: 2019.05.13.
 * Time: 17:22
 */

?>

<h1>Shares</h1>

<ul class="list-group">

    <?php




    $userid = $_SESSION["user_id"];
    $conn = connectDB();

    $stmt=$conn->prepare("SELECT filepath, share_code FROM shares WHERE user_id = ?");
    $stmt->bind_param("i", $userid);
    $stmt->bind_result($filepath, $share_code);
    $stmt->execute();

    while ($stmt->fetch()) {
        echo "<li class=\"list-group-item d-flex justify-content-between align-items-center\">
                            <div>$filepath</div>
                            <div class=\"list-group-link\">
                                <a href=\"#\" class='disable-share' data-id='$share_code'><i class=\"fas fa-trash\"></i> Disable Share</a>
                                &middot;
                                <a href=\"#\" class='copy-link' data-id='$share_code'><i class=\"fas fa-copy\"></i> Copy Link</a>
                            </div>
                        </li>";
    }

    $stmt->close();
    $conn->close();

    ?>


</ul>