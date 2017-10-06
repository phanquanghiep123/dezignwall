<?php
function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824)
    {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif ($bytes >= 1048576)
    {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    }
    elseif ($bytes >= 1024)
    {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    }
    elseif ($bytes > 1)
    {
        $bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1)
    {
        $bytes = $bytes . ' byte';
    }
    else
    {
        $bytes = '0 bytes';
    }

    return $bytes;
}
?>

<table class="table table-bordered">
    <tr style="background:#eeeeee">
        <td style="font-weight: bold;">Priority display</td>
        <td style="font-weight: bold; min-width: 170px;">Date uploaded</td>
        <td style="font-weight: bold;">Image</td>
        <td style="font-weight: bold;">File Size</td>
        <td style="font-weight: bold;">File type</td>
        <td style="font-weight: bold;">Project or product</td>
        <td style="font-weight: bold;">Image Title</td>
        <td style="font-weight: bold;">Photo Credit</td>
        <td style="font-weight: bold;">Indoor/outdoor/both</td>
        <td style="font-weight: bold;">Style</td>
        <td style="font-weight: bold;">Category</td>
        <td style="font-weight: bold;">Location</td>
        <td style="font-weight: bold;">Image description</td>
        <td style="font-weight: bold;">Keywords</td>
        <td style="font-weight: bold;">Locally/Nationally/Internationally</td> 
        <td style="font-weight: bold;">Certifications</td>

    </tr>
    <?php
    if (isset($arg_member)):
        $i = 1;
        foreach ($arg_member as $value) {
            $filesize = formatSizeUnits($value["size"]);
            $type = explode(".", $value["path_file"]);
            $type = $type[(count($type) - 1)];
            echo "<tr>";
            echo "<td><a href='". base_url("report/priority") . "/" . $value["photo_id"] ."/?page=".$curpage."'>" . ucfirst($value["priority_display"]) . "</a></td>";
            echo "<td>" . $value["created_at"] . "</td>";
            echo "<td><a href='" . base_url($value["path_file"]) . "' target='_blank'><img src='" . $value["thumb"] . "' width='100px' /></a></td>";
            echo "<td>" . $filesize . "</td>";
            echo "<td>" . $type . "</td>";
            echo "<td>" . $value["image_category"] . "</td>";
            echo "<td>" . $value["name"] . "</td>";
            echo "<td>" . $value["photo_credit"] . "</td>";
            echo "<td>" . implode(",",$value["indoor-outdoor-both"]) . "</td>";
            echo "<td>" . implode(",",$value["style"]) . "</td>";
            echo "<td>" . implode(",",$value["category"]) . "</td>";
            echo "<td>" . implode(",",$value["location"]) . "</td>";
            echo "<td>" . $value["description"] . "</td>";
            echo "<td>" . implode(",",$value["keyword"]) . "</td>";
            echo "<td>" . implode(",",$value["service"]) . "</td>";
            echo "<td>" . implode(",",$value["certifications"]) . "</td>";
            echo "</tr>";
            $i++;
        }
        ?>
    <?php endif; ?>
</table>
<div class="text-right">
    <?php
    if (isset($total_page) && isset($paging)) {
        echo paging($total_page, $paging, 5, base_url("report/photo_upload_info") . "/", 20);
    }
    ?>
</div>
</div>
</body>
</html>