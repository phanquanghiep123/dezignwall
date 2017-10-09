<table class="table table-bordered">
     <tr style="background:#eeeeee">
        <td style="font-weight: bold;">Business Type</td>
        <td style="font-weight: bold;">Business type date of entry</td>
        <td style="font-weight: bold;">Business Description</td>
        <td style="font-weight: bold;">Business description date of entry</td>
        <td style="font-weight: bold;">Company phone</td>
        <td style="font-weight: bold;" >Company email</td>
        <td style="font-weight: bold;">Website</td>
        <td style="font-weight: bold;">City,State,country</td>
    </tr>
    <?php
    if (isset($arg_member)):
        $i = 1;
        foreach ($arg_member as $value) {
            echo "<tr>";
            echo "<td>" . $value["business_type"] . "</td>";
            echo "<td>" . $value["update_date"] . "</td>";
            echo "<td>" . $value["business_description"] . "</td>";
            echo "<td>" . $value["created_at"] . "</td>";
            echo "<td>" . $value["company_800_number"] . "</td>";
            echo "<td>" . $value["contact_email"] . "</td>";
            echo "<td>" . $value["web_address"] . "</td>";
            echo "<td>" . $value["city"] . ",".$value["country"].",".$value["state"]."</td>";
            echo "</tr>";
            $i++;
        }
        ?>
    <?php endif; ?>
</table>
<div class="text-right">
    <?php
    if (isset($total_page) && isset($paging)) {
        echo paging($total_page, $paging, 5, base_url("report/created_profile") . "/", 20);
    }
    ?>
</div>
</div>
</body>
</html>