<?php
$con=mysqli_connect("localhost","root","root","ajax");
//create table and show all details from db
if(isset($_POST['readrecord']))
{
   $data='<table class="table table-bordered table-striped">
           <tr>
           <th>NO.</th>
           <th>Name</th>
           <th>Email</th>
           <th>Contact</th>
           <th>Edit Action</th>
           <th>Delete Action</th>
           </tr>';
    $query="SELECT * FROM `student` ";
    $res=mysqli_query($con,$query);
      while($row=mysqli_fetch_array($res)){
       $data .='<tr>
          <td>'.$row['id'].'</td>
          <td>'.$row['name'].'</td>
          <td>'.$row['email'].'</td>
          <td>'.$row['contact'].'</td>
          <td>
          <button onclick="GetDetails('.$row['id'].')"
          class="btn btn-warning">Edit</button>
          </td>
          <td>
          <button onclick="DelDetails('.$row['id'].')"
          class="btn btn-danger">Delete</button>
          </td>
        </tr>';
     }

    $data .='</table>';
    echo $data;
}
//extract value from modal and insert to table
extract($_POST);
if(isset($_POST['firstname'])&&isset($_POST['email'])&&
isset($_POST['contact']))
{
  $query="INSERT INTO `student` (`name`, `email`, `contact`) VALUES ('$firstname', '$email', '$contact')";
  mysqli_query($con,$query);
}

if(isset($_POST['deleteid']))
{
  $userid=$_POST['deleteid'];
  $query="DELETE FROM student WHERE id='$userid'";
  mysqli_query($con,$query);
}

//delete row by id
if(isset($_POST['id'])&& isset($_POST['id'])!="")
{
  $user_id=$_POST['id'];
  $query="SELECT * FROM student WHERE id='$user_id'";
  if(!$res=mysqli_query($con,$query)){
    exit(mysqli_eror());
  }
  $response=array();
  if(mysqli_num_rows($res)>0){
    while($row=mysqli_fetch_array($res)){
      $response=$row;
    }
  }
  //send status eror
  else {
    $response['status']=200;
    $response['message']="Data Not Found";
  }
  echo json_encode($response);
}else {
  $response['status']=200;
  $response['message']="Invalid request";
}
//update value by id
if(isset($_POST['hidden_user_id']))
{
  $hidden_user_id=$_POST['hidden_user_id'];
  $updname=$_POST['updname'];
  $updemail=$_POST['updemail'];
  $updcontact=$_POST['updcontact'];
  $query="UPDATE `student` SET `name`='$updname',`email`='$updemail',`contact`='$updcontact' WHERE `id`='$hidden_user_id'";
  mysqli_query($con,$query);

}
 ?>
