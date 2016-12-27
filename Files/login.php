<div class="admin-modal-content">
    <span class="close">&times;</span>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label>Username: </label>
        <input type="text" name="username" required>
        <label>Password: </label>
        <input type="text" name="password" required>
        <button id="submitadminbtn">Log in</button>
    </form>
</div>

<?php
  $name = $pass = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      
    $name = test_input($_POST["username"]);
    $pass = test_input($_POST["password"]);
  }

  function test_input($data) {
      
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }
?>