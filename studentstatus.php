<html>
	<head>
		<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<title>Student Status</title>
	</head>

	<body>
		<!-------------------- tab headings --------------------->
		<ul class="nav nav-tabs nav-justified">
			<li role="presentation">
				<a href="index.html"><strong>Home</strong></a>
			</li>
			<li role="presentation">
				<a href="studentregistration.php"><strong>Student Registration</strong></a>
			</li>
			<li role="presentation">
				<a href="bookregistration.php"><strong>Book Registration</strong></a>
			</li>
			<li role="presentation">
				<a href="copyregistration.php"><strong>Copy Registration</strong></a>
			</li>
			<li role="presentation" class="active">
				<a href="studentstatus.php"><strong>Student Status</strong></a>
			</li>
			<li role="presentation">
				<a href="bookstatus.php"><strong>Book Status</strong></a>
			</li>
			<li role="presentation">
				<a href="loan.php"><strong>Loans</strong></a>
			</li>
			<li role="presentation">
			<a href="reservation.php"><strong>Reservation</strong></a>
		</li>
		<li role="presentation">
			<a href="fines.php"><strong>Fines</strong></a>
		</li>
		</ul>
		<!-------------- end of tab headings --------------------->
		
		<!-------------- page content ---------------------------->
		<div class="container-fluid" style="margin-top:20px">
		<div id="page-content-wrapper" class="col-lg-12">
            <div style="margin-left: 100px" class="container-fluid">
			
			<?php 
			require("framework/DB.php");
			$pdo=getDB();
			$statement=$pdo->prepare("SELECT registration_number,id FROM student");
			$statement->execute();
			$results=$statement->fetchAll();
			
			$loans = array();
            //$reservations = array();
            if (isset($_POST) && !empty($_POST)) {
                $statement = $pdo->prepare("SELECT * FROM loan where student_id=:id");
                $statement->execute(['id' => $_POST['studentId']]);
                $loans = $statement->fetchAll();

                /*$stmt = $pdo->prepare("SELECT * FROM reservation INNER JOIN student ON reservation.student_id=student.id WHERE reservation.book_id=:id");
                $stmt->execute(['id' => $_POST['bookId']]);
                $reservations = $stmt->fetchAll();*/
			?>
			
			<div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Search Student Status by Registration Number
                        </div>
                        <div class="panel-body pan">
                            <form action="" method="post">
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
		
		<?php if (!empty($loans)): ?>
                <table class="table table-hover table-striped table-bordered table-condensed text-center">
                    <thead>
                    <tr>
                        <th class="text-center">Reference No</th>
                        <th class="text-center">Due Date</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($copies as $copy): ?>
                        <tr>
                            <td><?php echo($copy['copy_id']); ?></td>
							<td><?php echo($copy['return_date']); ?></td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            <?php elseif (!empty($_POST)): ?>
                <div class="alert alert-info">No copies borrowed from the library!</div>
            <?php endif ?>
		
       </div>
	</div>
	
		<!-------------- end of page content --------------------->
</body>
</html>