<html>
    <head>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <title>Student Registration</title>
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
                        $statement = $pdo->prepare("INSERT INTO student (name,class,phone, registration_number, registered_at) VALUES (:name,:class,:phone,:reg,:time)");
                        $status = $statement->execute(['name' => $_POST['name'], 'class' => $_POST['class'], 'phone' => $_POST['phone'], 'reg' => $_POST['registrationNumber'], 'time' => date("Y-m-d H:i:s")]);
                    }
                    ?>

                    <?php if (isset($status) && $status): ?>
                        <div class="alert alert-success">Student Registration Successful!</div>
                    <?php endif ?>

                    <?php if (isset($status) && !$status): ?>
                        <div class="alert alert-danger">Student Registration Failed!</div>
                    <?php endif ?>


                    <div class="col-lg-8">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                Student Registration</div>
                            <div class="panel-body pan">
                                <form action="" method="post">
                                    <div class="form-body pal">

                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label id="lblName" for="inputName" class="control-label">
                                                        Name *</label>
                                                    <div class="input-icon right">
                                                        <i class="fa fa-user"></i>
                                                        <input id="inputName" name="name" type="text" placeholder="Minimum four characters long" class="form-control" required pattern="(.{4,}[a-zA-Z ]+)"/>
                                                    </div>
                                                    <div id="error"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="inputAdmission" class="control-label">
                                                        Registration Number *</label>
                                                    <div class="input-icon right">
                                                        <i class="fa fa-envelope"></i>
                                                        <input id="inputAdmission" name="registrationNumber" type="text" placeholder="0000/0000" required pattern="[0-9]{4}/[0-9]{4}" class="form-control"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label id="lblTelephone" for="inputPhone" class="control-label">
                                                        Telephone Number *</label>
                                                    <div class="input-icon right">
                                                        <i class="fa fa-user"></i>
                                                        <input id="inputPhone" type="tel" name="phone" placeholder="0000000000" class="form-control" required pattern="[0-9]{10}"/></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="inputClass" class="control-label">
                                                        Class *</label>
                                                    <div class="input-icon right">
                                                        <i class="fa fa-user"></i>
                                                        <input id="inputClass" type="text" name="class" placeholder="00L" class="form-control" required pattern="[0-9]{1,2}[a-zA-Z ]{1}" /></div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="form-actions text-right pal">
                                        <button type="submit" class="btn btn-default">
                                            Register
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-------------- end of page content ---------------------------->

    </body>
</html>