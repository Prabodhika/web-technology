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
                        <div class="col-lg-8">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    Book Reservation</div>
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
                </div>

                <div class="table-responsive">

                </div>


            </div>
        </div>

        <div class="container-fluid" style="margin-top:20px">
            <div id="page-content-wrapper" class="col-lg-10">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    Find Reserved Books by Title</div>
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
                                            
                                            <div class="form-actions text-right pal">
                                                <button type="submit" class="btn btn-default">
                                                    Search</button>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">

                </div>


            </div>
        </div>
       </div>
            
       <div class="row text-center">
                    <?php if (!empty($fines)): ?>
                        <table class="table table-hover table-striped table-bordered table-condensed text-center">
                            <tr>
                                <th>Student Registration Number</th>
                                <th>Total Amount</th>
                                <th>Paid Amount</th>
                                <th>Created At</th>
                                <th>Pay</th>

                            </tr>

                            <tbody>
                                <?php foreach ($fines as $fine): ?>

                                    <tr>
                                        <td><?php echo($fine['name']); ?></td>
                                        <td><?php echo($fine['total_amount']); ?></td>
                                        <td><?php echo($fine['paid_amount']); ?></td>
                                        <td><?php echo($fine['created_at']); ?></td>
                                        <td>
                                            <form action="" method="post">
                                                <input hidden value="<?php echo($fine['fine_id']); ?>" name="fineId">
                                                <input class="form-control" type="number" name="amount"
                                                       max="<?php echo($fine['total_amount'] - $fine['paid_amount']); ?>"
                                                       min="0" step="0.01">
                                                <button class="btn btn-success btn-sm" type="submit">Pay</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

                </div>

        <!-------------- end of page content --------------------->
    </body>
</html>