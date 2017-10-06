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

$list_child = $list;
if (isset($list) && $list != null) {
	$index = count($list);
	echo '<table class="table table-bordered">
	<tr style="background:#eeefff;font-weight:bold;">
	    <td colspan="5">User Info</td>
	    <td colspan="8">Business Profile Info</td>
	    <td colspan="14">Photo upload info</td>
	</tr>
	<tr style="background:#eeeeee;">
		<td>x</td>
	    <td>First name</td>
	    <td>Last name</td>
	    <td>Company</td>
	    <td>Email</td>
	    <td>Business Type</td>
	    <td>Business Description</td>
	    <td>Company phone</td>
	    <td>Company email</td>
	    <td>Website</td>
	    <td>City</td>
	    <td>State</td>
	    <td>Country</td>
	    <td>Date uploaded</td>
	    <td>Image file size</td>
	    <td>File type</td>
	    <td>Project or product</td>
	    <td>Image Title</td>
	    <td>Photo Credit</td>
	    <td>Indoor/outdoor/both</td>
	    <td>Style</td>
	    <td>Category</td>
	    <td>Location</td>
	    <td>Image description</td>
	    <td>Keywords</td>
	    <td>Locally/Nationally/Internationally</td>
	    <td>Certifications</td>
	  </tr>';

	    foreach ($list as $key => $value) {
	    	if (isset($value['photos'])) {
		        $list_child = $value['photos'];
		        echo '	<tr>
		        			<td>' . ($index--) . '</td>
		        			<td>' . $value['first_name'] . '</td>
		                    <td>' . $value['last_name'] . '</td>
		                    <td>' . $value['company_name'] . '</td>
		                    <td>' . $value['email'] . '</td>
		                    <td>' . $value['business_type'] . '</td>
		                    <td>' . $value['business_description'] . '</td>
		                    <td>' . $value['main_business_ph'] . '</td>
		                    <td>' . $value['contact_email'] . '</td>
		                    <td>' . $value['web_address'] . '</td>
		                    <td>' . $value['city'] . '</td>
		                    <td>' . $value['state'] . '</td>
		                    <td>' . $value['country'] . '</td>';
		        if (count($list_child) > 0) {
		        	$index_temp = 0;
		        	foreach ($list_child as $item_child) {
		        		$type = explode(".", $item_child["path_file"]);
	            		$type = $type[(count($type) - 1)];
	            		$filesize = formatSizeUnits($item_child["size"]);
		        		
		        		if ($index_temp++ > 0) {
		        			echo '<tr>
		        					<td></td>
		                            <td></td>
		                            <td></td>
		                            <td></td>
		                            <td></td>
		                            <td></td>
		                            <td></td>
		                            <td></td>
		                            <td></td>
		                            <td></td>
		                            <td></td>
		                        	<td></td>
		                            <td></td>';
		        		}
		        		
		        		echo '  <td>' . @$item_child['created_at'] . '</td>
		        				<td>' . $filesize . '</td>
		                        <td>' . $type . '</td>
		                        <td>' . $item_child['image_category'] . '</td>
		                        <td>' . $item_child['name'] . '</td>
		                        <td>' . $item_child['photo_credit'] . '</td>
		                        <td>' . implode(",",$item_child["indoor-outdoor-both"]) . '</td>
		                        <td>' . implode(",",$item_child["style"]) . '</td>
		                        <td>' . implode(",",$item_child["category"]) . '</td>
		                        <td>' . implode(",",$item_child["location"]). '</td>
		                    	<td>' . $item_child['description'] . '</td>
		                        <td>' . implode(",",$item_child["keyword"]) . '</td>
		                        <td>' . implode(",",$item_child["service"]) . '</td>
		                        <td>' . implode(",",$item_child["certifications"]) . '</td></tr>';
		        		
		        	}
		        } else {
		        	echo '  <td></td>
		        			<td></td>
		                    <td></td>
		                	<td></td>
		                    <td></td>
		                    <td></td>
		                    <td></td>
		                    <td></td>
		                    <td></td>
		                    <td></td>
		                    <td></td>
		                    <td></td>
		                    <td></td>
		                    <td></td></tr>';
		        }
	    	}
	    }
	    echo '</table>';
}
?>
</div>
</body>
</html>