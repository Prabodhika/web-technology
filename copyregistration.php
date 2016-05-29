<html>
    <head>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <title>Copy Registration</title>
    </head>

    <body>
        <?php require 'framework/header.php'; ?>

        <!-------------- page content ---------------------------->

        <?php
        require("framework/DB.php");
        $pdo = getDB();
        $statement = $pdo->prepare("SELECT id,title FROM book");
        $statement->execute();
        $results = $statement->fetchAll();
        ?>

        <div class="container-fluid" style="margin-top:20px">
            <div id="page-content-wrapper" class="col-lg-10">
                <div class="container-fluid">

                    <?php
                    if (isset($_POST) && !empty($_POST)) {
                        $pdo = getDB();
                        $pdo->beginTransaction();
                        try {
                            $statement = $pdo->prepare("INSERT INTO copy (reference_number,book_id,received_at) VALUES (:referenceNumber,:bookID,:time)");
                            $insert = $statement->execute(['referenceNumber' => $_POST['referenceNo'], 'bookID' => $_POST['bookID'], 'time' => date("Y-m-d H:i:s")]);

                            $statement = $pdo->prepare("UPDATE book SET copies=copies+1 WHERE id=:id");
                            $copies = $statement->execute(['id' => $_POST['bookID']]);
                        } catch (\Exception $e) {
                            $pdo->rollback();
                        }
                        $status = $insert && $copies;
                        if ($status) {
                            $pdo->commit();
                        }
                    }
                    ?>

                    <?php if (isset($status) && $status): ?>
                        <div class="alert alert-success">Book Copy Registration Successful!</div>
                    <?php endif ?>

                    <?php if (isset($status) && !$status): ?>
                        <div class="alert alert-danger">Book Copy Registration Failed!</div>
                    <?php endif ?>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    Book Copy Registration</div>
                                <div class="panel-body pan">
                                    <form action="" method="post">
                                        <div class="form-body pal">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label id="lblBookID" class="control-label">
                                                            Book Title *</label>
                                                        <div class="input-icon right">
                                                            <i class="fa fa-user"></i>

                                                            <select name="bookID" class="form-control">
                                                                <?php foreach ($results as $result): ?>
                                                                    <option value="<?php echo($result[0]) ?>"><?php echo($result[1]) ?></option>
                                                                <?php endforeach ?>
                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label id="lblReferenceNo" for="inputReferenceNo" class="control-label">
                                                            Reference Number *</label>
                                                        <div class="input-icon right">
                                                            <i class="fa fa-user"></i>
                                                            <input id="inputReferenceNo" name="referenceNo" type="text" placeholder="TT0000" class="form-control" required pattern="[A-Za-z]{2}[0-9]{4}"/></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions text-right pal">
                                                <button type="submit" class="btn btn-default">
                                                    Register</button>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>