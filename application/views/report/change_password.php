<div style="width:600px; margin:0 auto; padding:20px; margin-top:30px;border:1px solid #ccc; font-size:18px;
">
<p style="text-align:center"><?php echo @$error;?></p>
<?php

if (isset($user) && $user != null) {
    echo '<p>Full name: '. $user["first_name"] .' '. $user["last_name"].'</p>'; 
    echo '<p>Email: '. $user["email"] .'</p>'; 
    echo '<p>Company name: '. $user["company_name"] .'</p>';      
}
?>
<form method="post">
    <p>New password : <input type="text" name="password" min="6" required /></p>
    <p><button type="submit">Save</button></p>
</form>
</div>
</body>
</html>