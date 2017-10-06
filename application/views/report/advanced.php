<table class="table table-bordered">
    <tr style="background:#eeeeee">
        <td style="font-weight: bold;" width="2%">x</td>
        <td style="font-weight: bold;">Country</td>
        <td style="font-weight: bold;">Newsletter</td>
        <td style="font-weight: bold;">General updates</td>
        <td style="font-weight: bold;">Promotions</td>
        <td style="font-weight: bold;">Research emails</td>
        <td style="font-weight: bold;">Image comments</td>
        <td style="font-weight: bold;">Image likes</td>
        <td style="font-weight: bold;">Dezignwall image comments</td>
        <td style="font-weight: bold;">Dezignwall inage likes</td>
        <td style="font-weight: bold;">Dezignwall folder comments</td>
        <td style="font-weight: bold;">Dezignwall folder likes</td>
    </tr>
    <?php
    if (isset($arg_member)):
        $i = 1;
        foreach ($arg_member as $value) {
            echo "<tr>";
            echo "<td>" . $i . "</td>";
            echo "<td>" . $value["country"] . "</td>";
            echo "<td>" . $value["newslettter"] . "</td>";
            echo "<td>" . $value["general_updates"] . "</td>";
            echo "<td>" . $value["promotions"] . "</td>";
            echo "<td>" . $value["research_emails"] . "</td>";
            echo "<td>" . $value["image_comment"] . "</td>";
            echo "<td>" . $value["image_like"] . "</td>";
            echo "<td>" . $value["dezignwall_comment"] . "</td>";
            echo "<td>" . $value["dezignwall_like"] . "</td>";
            echo "<td>" . $value["dezignwall_folder_comment"] . "</td>";
            echo "<td>" . $value["dezignwall_folder_like"] . "</td>";
            echo "</tr>";
            $i++;
        }
        ?>
    <?php endif; ?>
</table>
<div class="text-right">
    <?php
    if (isset($total_page) && isset($paging)) {
        echo paging($total_page, $paging, 5, base_url("report/advanced") . "/", 20);
    }
    ?>
</div>
</div>
</body>
</html>