<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
<!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

   <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
    <meta name="viewport" content="width=2965, maximum-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="/css/nav.css" />
    <link rel="stylesheet" type="text/css" href="/css/Employee/view.css" />

    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
  </head>
  <script type="text/javascript">
            
            function popUpSuccess(title){
                 alertify.set('notifier', 'position', 'top-center');
                 alertify.success(title);        
              };
    </script>

    <script type="text/javascript">
            
            function popUpError(title){
                 alertify.set('notifier', 'position', 'top-center');
                 alertify.error(title);        
              };
    </script>

    <script type="text/javascript">
            function confirm(user_id) {
              alertify.confirm("Are you sure you want to delete the employee?",
                function(input) {
                  if (input) {
                    window.location.href = '/User/remove/' + user_id;
                  } else {
                    alertify.error('Cancel');
                  }
                });
            };
    </script>
  <body>

      <div class='navbar'> 
          <a  href ="/Item/indexAdmin">
              <i class="fa-solid fa-boxes-stacked"></i>
              <span>Items</span>
          </a>

          <a  href ="/Category/index">
              <span><i class="fa-solid fa-bookmark"></i></span>
              <span>Category</span>
          </a>

          <a  href ="/Employee/index">
              <span><i class="fa-solid fa-users"></i></span>
              <span>Employees</span>
          </a>

        <img class="logo" src="/images/logo.png" alt="Logo" />

          <a  href ="/Profile/edit">
              <i class="fa fa-user"></i>
              <span>Profile</span>
          </a>
          
          <a  href ="">
            <span><i class="fa fa-bell"></i></span>
            <span>Notification</span>
          </a>

          <a  href ="/User/logout">
              <span><i class="fa fa-power-off"></i></span>
              <span>Logout</span>
          </a>
        </div> 

  <div class='lightBackground'>
    <div class='title' >
      <h1>Employees</h1> 
      <a id='addButton' href='/Employee/add' class='btn btn-success'>Add Employee</a>
    </div>  
    
    <hr class='line'>

    <table>
      <thead>
        <tr><th>USERNAME</th><th>FIRST NAME</th><th>LAST NAME</th><th>HOME ADDRESS</th><th></th></tr>
      </thead>
      
      <tbody>
        <?php
          foreach($data['employee'] as $item)
          { echo" 
                <tr><td>$item->username</td><td>$item->first_name</td><td>$item->last_name</td><td>$item->address</td><td>
                <button onclick='confirm($item->user_id)' class='btn btn-danger' id='deleteBut'>Delete</button></td></tr>
              ";
          }
        ?>
      </tbody>
    </table>
    <hr class='line2'>
  </div>
  </body>
</html>
      <?php
        if(isset($_GET['message'])){
          echo"<script>popUpSuccess('$_GET[message]');</script>";
        }
      ?>

      <?php
        if(isset($_GET['error'])){
          echo"<script>popUpError('$_GET[error]');</script>";
        }
      ?>
