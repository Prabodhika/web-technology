<html>
    <head>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <title>Reservation</title>
    </head>

    <body>
        <?php require 'framework/header.php'; ?>

        <!-------------- page content ---------------------------->

        <?php
        require("framework/DB.php");
        $pdo = getDB();
        $statement = $pdo->prepare("SELECT id,registration_number FROM student");
        $statement->execute();
        $students = $statement->fetchAll();

        $statement = $pdo->prepare("SELECT id,title FROM book");
        $statement->execute();
        $books = $statement->fetchAll();
        ?>

        <?php
        if (isset($_POST) && !empty($_POST)) {
            $pdo = getDB();
            $statement = $pdo->prepare("INSERT INTO reservation (book_id,student_id,reserved_at) VALUES (:bookId,:studentId,:time)");
            $status = $statement->execute(['bookId' => $_POST['bookId'], 'studentId' => $_POST['studentId'], 'time' => date("Y-m-d H:i:s")]);
        }
        if (isset($_GET) && !empty($_GET)) {
            $pdo = getDB();
            $statement = $pdo->prepare("SELECT student.name,student.registration_number,reservation.reserved_at,reservation.id FROM reservation inner join student on student.id = reservation.student_id WHERE book_id=:id; ");
            $statement->execute(['id' => $_GET['bookId']]);
            $reservations = $statement->fetchAll();
        }
        ?>

        <?php if (isset($status) && $status): ?>
            <div class="alert alert-success">Reservation Successful!</div>
        <?php endif ?>

        <?php if (isset($status) && !$status): ?>
            <div class="alert alert-danger">Reservation Failed!</div>
        <?php endif ?>

        <div class="container-fluid" style="margin-top:20px">
            <div id="page-content-wrapper" class="col-lg-10">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    Make Book Reservation</div>
                                <div class="panel-body pan">
                                    <form action="" method="post">
                                        <div class="form-body pal">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label id="lblBookId" class="control-label">
                                                            Book Title *</label>
                                                        <div class="input-icon right">
                                                            <i class="fa fa-user"></i>

                                                            <select name="bookId" class="form-control">
                                                                <?php foreach ($books as $book): ?>
                                                                    <option value="<?php echo($book[0]) ?>"><?php echo($book[1]) ?></option>
                                                                <?php endforeach ?>
                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label id="lblstudentId" class="control-label">
                                                            Student Registration Number *</label>
                                                        <div class="input-icon right">

                                                            <select name="studentId" class="form-control">
                                                                <?php foreach ($students as $student): ?>
                                                                    <option value="<?php echo($student[0]) ?>"><?php echo($student[1]) ?></option>
                                                                <?php endforeach ?>
                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="form-actions text-right pal">
                                                <button type="submit" class="btn btn-default">
                                                    Reserve</button>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                Cancel Book Reservation
                            </div>
                            <div class="panel-body pan">

                                <form action="" method="get">
                                    <div class="form-group">
                                        <label id="lblBookTitle" for="inputBookTitle" 
                                               class="control-label col-md-12 text-left">
                                            Search by Book Title *
                                        </label>
                                        <div class="input-icon right col-md-12">
                                            <i class="fa fa-user"></i>

                                            <select name="bookId" class="form-control">
                                                <?php foreach ($books as $book): ?>
                                                    <option value="<?php echo($book[0]) ?>"><?php echo($book[1]) ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-actions text-right pal">
                                        <button type="submit" class="btn btn-default">
                                            Search
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                    
                <?php if (!empty($_GET) && !empty($_GET['state']) && $_GET['state'] == 2): ?>
                    <div class="alert alert-success">Reservation canceled Successfully!</div>
                <?php endif ?>

                <div class="row text-center">
                    <?php if (!empty($reservations)): ?>
                        <table class="table table-hover table-striped table-bordered table-condensed text-center">
                            <tr>
                                <th>Student Name</th>
                                <th>Student ID</th>
                                <th>Reserved At</th>
                                <th>Cancel Reservation</th>
                            </tr>

                            <tbody>
                                <?php foreach ($reservations as $reservation): ?>

                                    <tr>
                                        <td><?php echo($reservation['name']); ?></td>
                                        <td><?php echo($reservation['registration_number']); ?></td>
                                        <td><?php echo($reservation['reserved_at']); ?></td>
                                        <td>
                                        <a class="btn btn-danger btn-sm" 
                                           href="framework/cancelReservation.php?id=<?php echo($reservation['id']); ?>">
                                            Cancel
                                        </a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    <?php elseif (!empty($_GET)): ?>
                        <div class="alert alert-info">No reservation under this title!</div>
                    <?php endif ?>                    
                </div>

            </div>
        </div>
    </div>
    <!-------------- end of page content --------------------->
</body>
</html>