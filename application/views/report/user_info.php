<table class="table table-bordered">
    <tr style="background:#eeeeee">
        <td style="font-weight: bold;" width="2%">x</td>
        <td style="font-weight: bold;">First name</td>
        <td style="font-weight: bold;">Last name</td>
        <td style="font-weight: bold;">Company</td>
        <td style="font-weight: bold;">Email</td>
    </tr>
    <?php
    if (isset($arg_member)):
        $i = 1;
        foreach ($arg_member as $value) {
            echo "<tr>";
            echo "<td>" . $i . "</td>";
            echo "<td>" . $value["first_name"] . "</td>";
            echo "<td>" . $value["last_name"] . "</td>";
            echo "<td>" . $value["company_name"] . "</td>";
            echo "<td>" . $value["email"] . "</td>";
            echo "</tr>";
            $i++;
        }
        ?>
    <?php endif; ?>
</table>
<div class="text-right">
    <?php
    if (isset($total_page) && isset($paging)) {
        echo paging($total_page, $paging, 5, base_url("report/user_info") . "/", 20);
    }
    ?>
</div>
</div>
</body>
</html>