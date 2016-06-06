<html>
    <head>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <title>Book Registration</title>
    </head>

    <body>
        <?php require 'framework/header.php'; ?>

        <!-------------- page content ---------------------------->
        <div class="container-fluid" style="margin-top:20px">
            <div id="page-content-wrapper" class="col-lg-10">
                <div class="container-fluid">

                    <?php
                    if (isset($_POST) && !empty($_POST)) {
                        require('framework/DB.php');

                        $pdo = getDB();
                        $statement = $pdo->prepare("INSERT INTO book (title,author, description) VALUES (:title,:author,:details)");
                        $status = $statement->execute(['title' => $_POST['title'], 'author' => $_POST['author'], 'details' => $_POST['details']]);
                    }
                    ?>

                    <?php if (isset($status) && $status): ?>
                        <div class="alert alert-success">Book Registration Successful!</div>
                    <?php endif ?>

                    <?php if (isset($status) && !$status): ?>
                        <div class="alert alert-danger">Book Registration Failed!</div>
                    <?php endif ?>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    Book Registration</div>
                                <div class="panel-body pan">
                                    <form action="" method="post">
                                        <div class="form-body pal">


                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label id="lblTitle" for="inputTitle" class="control-label">
                                                            Book Title *</label>
                                                        <div class="input-icon right">
                                                            <input id="inputTitle" name="title" type="text" placeholder="Enter book title" class="form-control" required /></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label id="lblAuthor" for="inputAuthor" class="control-label">
                                                            Author *</label>
                                                        <div class="input-icon right">
                                                            <input id="inputAuthor" name="author" type="text" placeholder="Author's name" class="form-control" required/></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label id="lblDetails" for="inputDetails" class="control-label">
                                                            Book Details</label>
                                                        <div class="input-icon right">
                                                            <i class="fa fa-user"></i>
                                                            <input id="inputDetails" name="details" type="text" placeholder="" class="form-control" /></div>
                                                    </div>
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
                <!-------------- end of page content ---------------------------->
                </body>
                </html>