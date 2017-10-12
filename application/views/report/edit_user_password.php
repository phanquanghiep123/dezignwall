
<?php
if (isset($list) && $list != null) {
        echo '<table class="table table-bordered">';
        echo '<tr style="background:#eeeeee;">
                <td>x</td>
                <td>First name</td>
                <td>Last name</td>
                <td>Company</td>
                <td>Email</td>
                <td>Action</td>
            </tr>';
		$i = count($list);
        foreach ($list as $key => $value) {
            $certifications = json_decode($value['certifications'], true);
            echo'<tr>
                    <td>' . ($i--) . '</td>
                    <td>' . $value['first_name'] . '</td>
                    <td>' . $value['last_name'] . '</td>
                    <td>' . $value['company_name'] . '</td>
                    <td>' . $value['email'] . '</td>
                    <td><a href="'.base_url("report/change_password/".$value['id']).'">Change password</a> | <a href="'.base_url("report/change_email/".$value['id']).'">Change email</a></td>
            </tr>';
        }

        echo '</table>';
    }

?>

</div>
</body>
</html>