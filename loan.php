<html>
	<head>
		<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<title>Loans</title>
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
			<li role="presentation" class="active">
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
        <div id="page-content-wrapper" class="col-lg-10">
            <div class="container-fluid">
			
			<?php 
			require("framework/DB.php");
			$pdo=getDB();
			$statement=$pdo->prepare("SELECT registration_number,id FROM student");
			$statement->execute();
			$students=$statement->fetchAll();
			
			$statement=$pdo->prepare("SELECT reference_number,id FROM copy where availability=1");
			$statement->execute();
			$copies=$statement->fetchAll();
		?>
		
		<?php
			if(isset($_POST) && !empty($_POST)){
				$pdo=getDB();
				
				$statement=$pdo->prepare("SELECT count(*) FROM copy WHERE id=:id AND availability=1");
				$statement->execute(['id'=>$_POST['copyId']]);
				$availability=$statement->fetchAll();
				
				$statement=$pdo->prepare("SELECT count(*) FROM loan WHERE student_id=:id AND returned=0");
				$statement->execute(['id'=>$_POST['studentId']]);
				$loanCount=$statement->fetchAll();
				
				$error=null;
				if($availability[0][0]==0){
					$error="Book Unavailable !";
				}
				elseif($loanCount[0][0]>=8){
					$error="Student has 8 loans already";
				}
				else{
					$pdo->beginTransaction();
					try{					
						$statement=$pdo->prepare("INSERT INTO loan (copy_id,student_id,borrow_date,return_date) VALUES (:copyId,:studentId,:borrowDate,:returnDate)");
						$insert=$statement->execute(['copyId'=>$_POST['copyId'],'studentId'=>$_POST['studentId'],
						'borrowDate'=>$_POST['borrowDate'],'returnDate'=>$_POST['returnDate']]);
					
						$statement=$pdo->prepare("UPDATE copy SET availability=0 WHERE id=:id");
						$update=$statement->execute(['id'=>$_POST['copyId']]);
					}
					catch(\Exception $e){
						$pdo->rollback();
						$status=false;
					}
					$pdo->commit();
					$status=$insert && $update;
				}	
			}
			?>
			
			<?php if(isset($error)):?>
				<div class="alert alert-danger"><?php echo($error); ?></div>
			<?php endif ?>
			
			<?php if(isset($status) && $status):?>
				<div class="alert alert-success">Entered Successfully!</div>
			<?php endif ?>
			
			<?php if(isset($status) && !$status):?>
				<div class="alert alert-danger">Failed!</div>
			<?php endif ?>
			<!------------------------------------------------- error -------------------------------------------------------------------------------------->
			<?php if(isset($availability) && $availability[0]==0):?>
				<div class="alert alert-danger">Copy Unavailable!</div>
			<?php endif ?>

                <div class="row">
                    <div class="col-lg-8">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    Book Loans</div>
                                <div class="panel-body pan">
                                    <form action="" method="post">
                                        <div class="form-body pal">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label id="lblCopyId" class="control-label">
                                                            Reference Number *</label>
                                                        <div class="input-icon right">
                                                            <i class="fa fa-user"></i>
                                                            
															<select name="copyId" class="form-control">
																<?php foreach($copies as $copy): ?>
																	<option value="<?php echo($copy[1])?>"><?php echo($copy[0])?></option>
																<?php endforeach ?>
															</select>
															
                                                    </div>
                                                </div>
                                            </div>
										</div>


                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label id="lblStudentId" class="control-label">
                                                            Student Registration Number *</label>
                                                        <div class="input-icon right">
														
														<select name="studentId" class="form-control">
																<?php foreach($students as $student): ?>
																	<option value="<?php echo($student[1])?>"><?php echo($student[0])?></option>
																<?php endforeach ?>
															</select>
                                                            
                                                    </div>
                                                </div>
                                            </div>
										</div>
											

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label id="lblBorrow" for="inputBorrow" class="control-label">
                                                            Borrow Date *</label>
                                                        <div class="input-icon right">
                                                            <input id="inputBorrow" name="borrowDate" readonly value="<?php echo date("Y-m-d") ?>" type="date" class="form-control" required /></div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label id="lblReturn" for="inputReturn" class="control-label">
                                                             Return Date *</label>
                                                        <div class="input-icon right">
                                                            <i class="fa fa-user"></i>
                                                            <input id="inputReturn" name="returnDate" min="<?php echo date("Y-m-d","+1") ?>" type="date" class="form-control" required /></div>
                                                    </div>
                                                </div>
                                            </div>
											
                                        <div class="form-actions text-right pal">
                                            <button type="submit" class="btn btn-default">
                                                Submit</button>
                                        </div>
                                    </form>
                        </div>
                    </div>
                </div>
            </div>
		<!-------------- end of page content --------------------->

</body>
</html>