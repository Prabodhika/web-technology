<html>
    <head>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <title>Student Status</title>
    </head>

    <body>
        <?php require 'framework/header.php'; ?>

        <!-------------- page content ---------------------------->
        <div class="container-fluid" style="margin-top:20px">
            <div id="page-content-wrapper" class="col-lg-12">
                <div style="margin-left: 100px" class="container-fluid">

                    <?php
                    require("framework/DB.php");
                    $pdo = getDB();
                    $statement = $pdo->prepare("SELECT registration_number,id FROM student");
                    $statement->execute();
                    $results = $statement->fetchAll();

                    $loans = array();
                    //$reservations = array();
                    if (isset($_GET) && !empty($_GET)) {

                        $loansQuery = "SELECT student.*,copy.reference_number,book.title,loan.*,loan.id as loan_id 
                            from student inner join loan on student.id=loan.student_id inner join copy on copy.id=loan.copy_id inner join book on 
                        book.id=copy.book_id where student.id=:id and loan.returned=0";
                        $stmt = $pdo->prepare($loansQuery);
                        $stmt->execute(['id' => $_GET['studentId']]);
                        $loans = $stmt->fetchAll();
                    }
                    ?>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    Search Student Status by Registration Number
                                </div>
                                <div class="panel-body pan">
                                    <form action="" method="get">
                                        <div class="form-body pal">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label id="lblStudentId" class="control-label col-md-4">
                                                            Registration Number *</label>
                                                        <div class="col-md-5">
                                                            <div class="input-icon right">
                                                                <i class="fa fa-user"></i>

                                                                <select name="studentId" class="form-control">
                                                                    <?php foreach ($results as $result): ?>
                                                                        <option
                                                                            value="<?php echo($result[1]) ?>"><?php echo($result[0]) ?></option>
                                                                        <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button type="submit" class="btn btn-default">
                                                                Search
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>


                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>  

                <?php if (!empty($_GET) && !empty($_GET['state']) && $_GET['state'] == 1): ?>
                    <div class="alert alert-success">Reminder Sent Successfully!</div>
                <?php endif ?>

                <?php if (!empty($_GET) && !empty($_GET['state']) && $_GET['state'] == 2): ?>
                    <div class="alert alert-success">Book marked as returned!</div>
                <?php endif ?>

                <?php if (!empty($loans)): ?>

                    <table class="table table-hover table-striped table-bordered table-condensed">
                        <tr>
                            <th>Student Name</th>
                            <th>Class</th>
                            <th>Book</th>
                            <th>Reference No</th>
                            <th>Due Date</th>
                            <th>Reminders</th>
                            <th></th>
                        </tr>
                        <tbody>
                            <?php foreach ($loans as $loan): ?>
                                <?php
                                $statement = $pdo->prepare("SELECT * FROM reminder WHERE loan_id=:id");
                                $statement->execute(['id' => $loan['loan_id']]);
                                $reminders = $statement->fetchAll();
                                ?>
                                <tr>
                                    <td><?php echo($loan['name']); ?></td>
                                    <td><?php echo($loan['class']); ?></td>
                                    <td><?php echo($loan['title']); ?></td>
                                    <td><?php echo($loan['reference_number']); ?></td>
                                    <td><?php echo($loan['return_date']); ?></td>
                                    <td>
                                        <?php
                                        foreach ($reminders as $reminder) {
                                            echo $reminder['reminder_no'] . ' - ' . $reminder['sent_at'] . '<br>';
                                        }
                                        ?>                                   
                                    </td>

                                    <td>
                                        <a class="btn btn-success btn-sm" 
                                           href="framework/markAsReturned.php?id=<?php echo($loan['loan_id']); ?>">
                                            Mark as Returned
                                        </a>
                                        <?php if (count($reminders) < 3): ?>
                                            <a href="framework/sendReminder.php?loan_id=<?php echo($loan['loan_id']); ?>" class="btn btn-danger btn-sm">
                                                Send Reminder
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                <?php elseif (!empty($_GET)): ?>
                    <div class="alert alert-info">No copies borrowed from the library!</div>
                <?php endif ?>

            </div>
        </div>

        <!-------------- end of page content --------------------->
    </body>
</html>