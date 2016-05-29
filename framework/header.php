<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (!session_id()) {
    session_start();
}
?>

<!-------------------- tab headings --------------------->
<ul class="nav nav-tabs nav-justified">
    <li role="presentation" <?php if (strpos($_SERVER['REQUEST_URI'], "index") != false): ?> class="active" <?php endif; ?>>
        <a href="index.php"><strong>Home</strong></a>
    </li>
    <li role="presentation" <?php if (strpos($_SERVER['REQUEST_URI'], "studentregistration") != false): ?> class="active" <?php endif; ?>>
        <a href="studentregistration.php"><strong>New Student</strong></a>
    </li>
    <li role="presentation" <?php if (strpos($_SERVER['REQUEST_URI'], "bokregistration") != false): ?> class="active" <?php endif; ?>>
        <a href="bookregistration.php"><strong>New Book</strong></a>
    </li>
    <li role="presentation" <?php if (strpos($_SERVER['REQUEST_URI'], "copyregistration") != false): ?> class="active" <?php endif; ?>>
        <a href="copyregistration.php"><strong>New Copy</strong></a>
    </li>
    <li role="presentation" <?php if (strpos($_SERVER['REQUEST_URI'], "studentstatus") != false): ?> class="active" <?php endif; ?>>
        <a href="studentstatus.php"><strong>Students</strong></a>
    </li>
    <li role="presentation" <?php if (strpos($_SERVER['REQUEST_URI'], "bookstatus") != false): ?> class="active" <?php endif; ?>>
        <a href="bookstatus.php"><strong>Books</strong></a>
    </li>
    <li role="presentation" <?php if (strpos($_SERVER['REQUEST_URI'], "loan") != false): ?> class="active" <?php endif; ?>>
        <a href="loan.php"><strong>New Loan</strong></a>
    </li>
    <li role="presentation"<?php if (strpos($_SERVER['REQUEST_URI'], "reservation") != false): ?> class="active" <?php endif; ?>>
        <a href="reservation.php"><strong>Reservation</strong></a>
    </li>
    <li role="presentation"<?php if (strpos($_SERVER['REQUEST_URI'], "fines") != false): ?> class="active" <?php endif; ?>>
        <a href="fines.php"><strong>Fines</strong></a>
    </li>
</ul>
<!-------------- end of tab headings --------------------->
