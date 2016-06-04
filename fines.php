<html>
    <head>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <title>Fines</title>
    </head>

    <body>
        <?php require 'framework/header.php'; ?>

        <!-------------- page content ---------------------------->

        <?php
        require("framework/DB.php");
        $pdo = getDB();
        $statement = $pdo->prepare("SELECT registration_number,id FROM student");
        $statement->execute();
        $results = $statement->fetchAll();
        ?>

        <?php
        if (isset($_POST) && !empty($_POST) && isset($_POST['fineId'])) {
            $pdo = getDB();
            $statement = $pdo->prepare("UPDATE fine SET paid_amount=paid_amount+:amount,paid_at=:time where id=:id");
            $paid = $statement->execute([
                'id' => $_POST['fineId'],
                'amount' => $_POST['amount'],
                'time' => date('Y-m-d H:i:s')
            ]);
        } elseif (isset($_POST) && !empty($_POST)) {
            $pdo = getDB();
            $statement = $pdo->prepare("INSERT INTO fine (student_id,total_amount) VALUES(:id,:amount)");
            $status = $statement->execute(['id' => $_POST['registrationNumber'], 'amount' => $_POST['fines']]);
        }

        if (isset($_GET) && !empty($_GET)) {
            $pdo = getDB();
            $statement = $pdo->prepare("SELECT *,fine.id as fine_id FROM student INNER JOIN fine ON "
                    . "student.id=fine.student_id WHERE student_id=:id AND total_amount>paid_amount");
            $statement->execute(['id' => $_GET['registrationNumber']]);
            $fines = $statement->fetchAll();
        }
        ?>

        <?php if (isset($paid) && $paid): ?>
            <div class="alert alert-success">Fine Paid Successfully!</div>
        <?php endif ?>

        <?php if (isset($status) && $status): ?>
            <div class="alert alert-success">Entered Successfully!</div>
        <?php endif ?>

        <?php if (isset($status) && !$status): ?>
            <div class="alert alert-danger">Failed!</div>
        <?php endif ?>

        <div class="container-fluid" style="margin-top:20px">
            <div id="page-content-wrapper" class="col-lg-10">


                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                New Fine
                            </div>
                            <div class="panel-body">

                                <form action="" method="post" class="form-horizontal col-md-12">
                                    <div class="form-group text-left">
                                        <label id="lblTitleId" for="inputTitleId" 
                                               class="control-label col-md-12 text-left">
                                            Student Registration Number *
                                        </label>
                                        <div class="input-icon right col-md-12">
                                            <i class="fa fa-user"></i>

                                            <select name="registrationNumber" class="form-control">
                                                <?php foreach ($results as $result): ?>
                                                    <option value="<?php echo($result[1]) ?>">
                                                        <?php echo($result[0]) ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group text-left">
                                        <label id="lblFines" for="inputFines" class="control-label col-md-12 text-left">
                                            Amount *</label>
                                        <div class="input-icon right col-md-12">
                                            <input id="inputFines" name="fines" type="number" step="0.01" Min="0" placeholder="Amount in numbers" class="form-control" required/></div>
                                    </div>

                                    <div class="form-actions text-right pal">
                                        <button type="submit" class="btn btn-default">
                                            Submit
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                Search Fines 
                            </div>
                            <div class="panel-body">

                                <form action="" method="get" class="form-horizontal col-md-12">
                                    <div class="form-group text-left">
                                        <label id="lblTitleId" for="inputTitleId" 
                                               class="control-label col-md-12 text-left">
                                            Search by Student Registration Number *
                                        </label>
                                        <div class="input-icon right col-md-12">
                                            <i class="fa fa-user"></i>

                                            <select name="registrationNumber" class="form-control">
                                                <?php foreach ($results as $result): ?>
                                                    <option value="<?php echo($result[1]) ?>">
                                                        <?php echo($result[0]) ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-actions text-right pal">
                                        <button type="submit" class="btn btn-default">
                                            Submit
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row text-center">
                    <?php if (!empty($fines)): ?>
                        <table class="table table-hover table-striped table-bordered table-condensed text-center">
                            <tr>
                                <th>Student Name</th>
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
            </div>
        </div>
        <!-------------- end of page content --------------------->

    </body>
</html>