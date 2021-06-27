<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<title>Crud Example</title>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	</head>
	 <body style="background:#66339954;">
    	<br><br>
		<h1 style="font-size: 40px; text-align: center;">CRUD EXAMPLE</h1>
        <br>
		<!-- Button to Open the Modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float:center; font-size:25px;">
        Open modal to insert user
        </button>
        <br><br><br>
        <div id="read_co">

        </div>
     <!-- The Modal -->
    <div class="modal" id="myModal">
       <div class="modal-dialog">
          <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Modal Heading</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-group">
        	<label>name</label>
			<input type="text" name="" id="firstname" class="form-control" placeholder="Enter Name">
        </div>
		<div class="form-group">
        	<label>email</label>
			<input type="email" name="" id="email" class="form-control" placeholder="Enter email">
        </div>
		<div class="form-group">
        	<label>contact</label>
			<input type="text" name="" id="contact" class="form-control" placeholder="Enter contact">
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
		<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="addRecord()">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
     </div>
  </div>
</div>

<!-- The Modal Update -->
<div class="modal" id="myModal1">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Modal Heading Update</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-group">
        	<label>upd_name</label>
			<input type="text" name="" id="upd_firstname" class="form-control" placeholder="Enter Name">
        </div>
		<div class="form-group">
        	<label>upd_email</label>
			<input type="email" name="" id="upd_email" class="form-control" placeholder="Enter email">
        </div>
		<div class="form-group">
        	<label>upd_contact</label>
			<input type="text" name="" id="upd_contact" class="form-control" placeholder="Enter contact">
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
		<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="updateuserdetail()">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		<input type="hidden" name="" id="hidden_user_id">
      </div>
    </div>
  </div>
</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			readRecords();
		});
		//load table with details from db
		function readRecords(){
			var readrecord="readrecord";
			$.ajax({
				url:"backend1.php",
				type:"post",
				data:{readrecord:readrecord},
				success:function(data,status){
					$('#read_co').html(data);
				}
			});
		}
		//take value from modal and send to backend1.php
			function addRecord(){
				var firstname=$('#firstname').val();
				var email=$('#email').val();
				var contact=$('#contact').val();

				$.ajax({
					url:"backend1.php",
					method:"post",
					data:{firstname:firstname,
					email:email,
					contact:contact},
					success:function(data,status){
						readRecords();
					}
				});
			}
			//delete row by id
			function DelDetails(deleteid){
				var conf=confirm("Are you Sure?");
				if(conf==true){
					$.ajax({
						url:"backend1.php",
						method:"post",
						data:{deleteid:deleteid},
						success:function(data,status){
							readRecords();
						}
					});
				}
			}
			//get details from row by id and put them in update modal and show him
			function GetDetails(id){
				$('#hidden_user_id').val(id);
				$.post("backend1.php",{id:id},function(data,status){
					var user=JSON.parse(data);
					$('#upd_firstname').val(user.name);
					$('#upd_email').val(user.email);
					$('#upd_contact').val(user.contact);
				});
				$('#myModal1').modal("show");
			}
			//Update value
			function updateuserdetail(){
				var updname =	$('#upd_firstname').val();
				var updemail =	$('#upd_email').val();
				var updcontact =	$('#upd_contact').val();

				var hidden_user_id =$('#hidden_user_id').val();

				$.post("backend1.php",{
					hidden_user_id:hidden_user_id,
					updname:updname,
					updemail:updemail,
					updcontact:updcontact
				},
				function(data,status){
					$('#myModal1').modal("hide");
					readRecords();
				}
			  );
			}

		</script>
	</body>
</html>
