<html>
	<head>
		<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<title>Reservation</title>
	</head>

	<body>
		<!--------------------- tab headings --------------------->
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
			<li role="presentation">
				<a href="studentstatus.php"><strong>Student Status</strong></a>
			</li>
			<li role="presentation">
				<a href="bookstatus.php"><strong>Book Status</strong></a>
			</li>
			<li role="presentation">
				<a href="loan.php"><strong>Loans</strong></a>
			</li>
			<li role="presentation" class="active">
				<a href="reservation.php"><strong>Reservation</strong></a>
			</li>
			<li role="presentation">
				<a href="fines.php"><strong>Fines</strong></a>
			</li>
		</ul>
		<!-------------- end of tab headings --------------------->
		
		<!-------------- page content ---------------------------->
		
		<?php 
			require("framework/DB.php");
			$pdo=getDB();
			$statement=$pdo->prepare("SELECT id,registration_number FROM student");
			$statement->execute();
			$students=$statement->fetchAll();
		
			$statement=$pdo->prepare("SELECT id,title FROM book");
			$statement->execute();
			$books=$statement->fetchAll();
		?>
		
		<?php
			if(isset($_POST) && !empty($_POST)){
				$pdo=getDB();
				$statement=$pdo->prepare("INSERT INTO reservation (book_id,student_id,reserved_at) VALUES (:bookId,:studentId,:time)");
				$status=$statement->execute(['bookId'=>$_POST['bookId'],'studentId'=>$_POST['studentId'],'time'=>date("Y-m-d H:i:s")]);
			}
			?>
			
			<?php if(isset($status) && $status):?>
				<div class="alert alert-success">Reservation Successful!</div>
			<?php endif ?>
			
			<?php if(isset($status) && !$status):?>
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
                                                            Book ID *</label>
                                                        <div class="input-icon right">
                                                            <i class="fa fa-user"></i>
															
															<select name="bookId" class="form-control">
																<?php foreach($books as $book): ?>
																	<option value="<?php echo($book[0])?>"><?php echo($book[1])?></option>
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
																<?php foreach($students as $student): ?>
																	<option value="<?php echo($student[0])?>"><?php echo($student[1])?></option>
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
		<!-------------- end of page content --------------------->

	</body>
</html>