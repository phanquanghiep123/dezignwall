<table class="table table-bordered">
        <tr style="background:#eeeeee">
            <td style="font-weight: bold;" width="2%">x</td>
            <td style="font-weight: bold;" width="10%">Company name</td>
            <td style="font-weight: bold;" width="12%">Created at</td>
            <td style="font-weight: bold;" width="12%">Upgrade Code</td>
            <td style="font-weight: bold;" width="12%">Upgraded on date</td>
            <td style="font-weight: bold;" width="15%">Business type</td>
            <td style="font-weight: bold;" width="20%">Business description</td>
            <td style="font-weight: bold;" width="13%">Main business ph</td>
            <td style="font-weight: bold;" width="20%">Contact email</td>
      </tr>
    <?php
    if (isset($list)):
        $total = count($list);
                foreach ($list as $key => $value) {
                    $business_description = $value['business_description'];
                    $business_description = str_replace(";", "", $business_description);
                    $business_description = rtrim(trim($business_description), ",");
                    echo '<tr>
                      <td>' . ($total--) . '</td>
                        <td>' . $value['company_name'] . '</td>
                        <td>' . $value['created_at'] . '</td>
                        <td>' . $value['code'] . '</td>
                        <td>' . $value['updated_code'] . '</td>
                        <td>' . ucfirst($value['business_type']) . '</td>
                        <td>' . $business_description . '</td>
                        <td>' . $value['main_business_ph'] . '</td>
                        <td>' . $value['contact_email'] . '</td>
                    </tr>';
                }
        ?>
    <?php endif; ?>
</table>
</div>
</body>
</html>