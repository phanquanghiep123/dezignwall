
<?php
if (isset($list) && $list != null) {
                echo '<table class="table table-bordered">';
                echo '<tr style="background:#eeefff;font-weight:bold;">
                <td colspan="6">Initial sign up</td>
                <td>Return user</td>
                <td colspan="9">Created Profile</td>
                <td colspan="8">Engagement</td>
                <td colspan="10">Advanced Settings</td>
              </tr>';
                echo '<tr style="background:#eeeeee;">
                <td>x</td>
                <td>First name</td>
                <td>Last name</td>
                <td>Company</td>
                <td>Email</td>
                <td>First record date</td>
                <td>Number of times logged in</td>
                <td>Business Type</td>
                <td>Business Description</td>
                <td>Company phone</td>
                <td>Company email</td>
                <td>Website</td>
                <td>City</td>
                <td>State</td>
                <td>Country</td>
                <td>Number of photos</td>
                <td>Number of images uploaded</td>
                <td>About Statement</td>
                <td>Certifications</td>
                <td>Service areas</td>
                <td>Upload Logo</td>
                <td>Upload Banner</td>
                <td>Upload avatar</td>
                <td>Latest update</td>
                <td>Country</td>
                <td>Newsletter</td>
                <td>General updates</td>
                <td>Promotions</td>
                <td>Research emails</td>
                <td>Image comments</td>
                <td>Image likes</td>
                <td>Dezignwall image comments</td>
                <td>Dezignwall inage likes</td>
                <td>Dezignwall folder comments</td>
                <td>Dezignwall folder likes</td>
              </tr>';
				$i = count($list);
                foreach ($list as $key => $value) {
                    $certifications = json_decode($value['certifications'], true);

                    echo
                    '<tr>
                <td>' . ($i--) . '</td>
                <td>' . $value['first_name'] . '</td>
                <td>' . $value['last_name'] . '</td>
                <td>' . $value['company_name'] . '</td>
                <td>' . $value['email'] . '</td>
                <td>' . $value['registration_date'] . '</td>
                <td>' . $value['number_logged'] . '</td>
                <td>' . $value['business_type'] . '</td>
                <td>' . $value['business_description'] . '</td>
                <td>' . $value['main_business_ph'] . '</td>
                <td>' . $value['contact_email'] . '</td>
                <td>' . $value['web_address'] . '</td>
                <td>' . $value['city'] . '</td>
                <td>' . $value['state'] . '</td>
                <td>' . $value['country'] . '</td>
                <td>' . $value['number_photos'] . '</td>
                <td>' . $value['number_upload'] . '</td>
                <td>' . $value['company_about'] . '</td>
                <td>' . $certifications['text'] . '</td>
                <td>' . $value['service_area'] . '</td>
                <td>' . ($value['logo'] != '' ? "Yes" : "No") . '</td>
                <td>' . ($value['banner'] != '' ? "Yes" : "No") . '</td>
                <td>' . ($value['avatar'] != '' ? "Yes" : "No") . '</td>
                <td>' . $value['update_date'] . '</td>
                <td>' . $value['country'] . '</td>
                <td>' . $value['newslettter'] . '</td>
                <td>' . $value['general_updates'] . '</td>
                <td>' . $value['promotions'] . '</td>
                <td>' . $value['research_emails'] . '</td>
                <td>' . $value['image_comment'] . '</td>
                <td>' . $value['image_like'] . '</td>
                <td>' . $value['dezignwall_comment'] . '</td>
                <td>' . $value['dezignwall_like'] . '</td>
                <td>' . $value['dezignwall_folder_comment'] . '</td>
                <td>' . $value['dezignwall_folder_like'] . '</td>
              </tr>';
                }

                echo '</table>';
            }

?>

</div>
</body>
</html>