<html>
	<head>
		<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<title>Fines</title>
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
			<li role="presentation">
				<a href="reservation.php"><strong>Reservation</strong></a>
			</li>
			<li role="presentation" class="active">
				<a href="fines.php"><strong>Fines</strong></a>
			</li>
		</ul>
		<!-------------- end of tab headings --------------------->
		
		<!-------------- page content ---------------------------->
		
		<?php 
			require("framework/DB.php");
			$pdo=getDB();
			$statement=$pdo->prepare("SELECT registration_number FROM student");
			$statement->execute();
			$results=$statement->fetchAll();
		?>
		
		<?php
			if(isset($_POST) && !empty($_POST)){
				$pdo=getDB();
				$statement=$pdo->prepare("UPDATE student SET fines=fines+:fines WHERE registration_number=:registrationNumber");
				$status=$statement->execute(['registrationNumber'=>$_POST['registrationNumber'],'fines'=>$_POST['fines']]);
				
			}
			?>
			
			<?php if(isset($status) && $status):?>
				<div class="alert alert-success">Entered Successfully!</div>
			<?php endif ?>
			
			<?php if(isset($status) && !$status):?>
				<div class="alert alert-danger">Failed!</div>
			<?php endif ?>
		
		<div class="container-fluid" style="margin-top:20px">
        <div id="page-content-wrapper" class="col-lg-10">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-8">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    Fines</div>
                                <div class="panel-body pan">
                                    <form action="" method="post">
                                        <div class="form-body pal">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label id="lblTitleId" for="inputTitleId" class="control-label">
                                                            Student Registration Number *</label>
                                                        <div class="input-icon right">
                                                            <i class="fa fa-user"></i>
															
															<select name="registrationNumber" class="form-control">
																<?php foreach($results as $result): ?>
																	<option><?php echo($result[0])?></option>
																<?php endforeach ?>
															</select>
													
													</div>
                                                </div>
                                            </div>
										</div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label id="lblFines" for="inputFines" class="control-label">
                                                            Amount *</label>
                                                        <div class="input-icon right">
                                                            <input id="inputFines" name="fines" type="number" step="0.01" Min="0" placeholder="Amount in numbers" class="form-control" required/></div>
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
            </div>
		<!-------------- end of page content --------------------->

</body>
</html>