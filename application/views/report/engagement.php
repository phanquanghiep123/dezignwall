<table class="table table-bordered">
    <tr style="background:#eeeeee">
        <td style="font-weight: bold;" width="2%">x</td>
        <td style="font-weight: bold;">Number of photos</td>
        <td style="font-weight: bold;">About Statement</td>
        <td style="font-weight: bold;">Certifications</td>
        <td style="font-weight: bold;">Service areas</td>
        <td style="font-weight: bold;">Upload Logo</td>
        <td style="font-weight: bold;">Upload Banner</td>
        <td style="font-weight: bold;">Upload avatar</td>
        <td style="font-weight: bold; min-width: 170px;">Latest update</td>
    </tr>
    <?php
    if (isset($arg_member)):
        $i = 1;
        foreach ($arg_member as $value) {
            $certifications = json_decode($value["certifications"], true);
            $logo = ($value["logo"] != "") ? "yes" : "no";
            $banner = ($value["banner"] != "") ? "yes" : "no";
            $avatar = ($value["avatar"] != "") ? "yes" : "no";
            echo "<tr>";
            echo "<td>" . $i . "</td>";
            echo "<td>" . $value["number_upload_photo"] . "</td>";
            echo "<td>" . $value["company_about"] . "</td>";
            echo "<td>" . @$certifications["text"] . "</td>";
            echo "<td>" . $value["service_area"] . "</td>";
            echo "<td>" . $logo . "</td>";
            echo "<td>" . $banner . "</td>";
            echo "<td>" . $avatar . "</td>";
            echo "<td>" . $value["update_date"] . "</td>";
            echo "</tr>";
            $i++;
        }
        ?>
    <?php endif; ?>
</table>
<div class="text-right">
    <?php
    if (isset($total_page) && isset($paging)) {
        echo paging($total_page, $paging, 5, base_url("report/engagement") . "/", 20);
    }
    ?>
</div>
</div>
</body>
</html>