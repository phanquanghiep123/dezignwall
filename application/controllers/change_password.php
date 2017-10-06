<div style="width:400px; margin:0 auto;">
<?php

if (isset($user) && $user != null) {
    echo '<p>Full name: '. $user["first_name"] .' '. $user["last_name"].'</p>'; 
    echo '<p>Email: '. $user["email"] .'</p>'; 
    echo '<p>Company name: '. $user["company_name"] .'</p>';      
}
?>
<form method="post">
    <p>New password : <input type="text" name="password"/></p>
    <p><button type="submit">Save</button></p>
</form>
</div>
</body>
</html>