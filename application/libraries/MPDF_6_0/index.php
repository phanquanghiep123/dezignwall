<?php

include ('mpdf.php');
$mpdf = new mPDF('','A4');
$mpdf->WriteHTML('
<style>@page {
 	margin: 20px;
}
p{font-size:13px; color:#000;}
table{padding-left:30px;}
img{max-width:100%}
</style>
<div style="background-color: rgba(0, 0, 0, 0.49);height: 51px;z-index:2;position: relative;padding: 10px;">
  <div style="width:50px; height:50px;float:left">
      <img style="border-radius: 100%;width: 50px;height: 50px;float: left;" src="http://dev.dezignwall.kindusa.org/uploads/company/055e1a2ecdac6b37ec1ae8650aec08f6_56a0718a977a1.png"> 
  </div>
  <div style="float:left;margin-left: 20px;">
    <p style="display:block;margin: 0;padding: 0;color: #fff;line-height: 1.5;font-size: 20px;font-weight: bold;">Photo title</p>
    <p style="display:block;margin: 0;padding: 0;color: #fff;font-size: 18px;">Photo tessr newwqewq</p>
  </div>
</div>
<div style="z-index:99999;position:relative;text-align:right;margin-top:-70px; margin-right:3px;"><img style="width:100px;height:100px;border:1px solid #000;" src="http://dev.dezignwall.kindusa.org/photos/genenator_qr/1283223"></div>
<div style="position:relative;margin-top: -105px; z-index: -1; float: left; width: 100%; text-align: center;">
  <img style="max-height:970px;" src="https://st.hzcdn.com/simgs/32a1e1e20fb6b388_9-3715/eclectic-kitchen.jpg">
</div>

<div style="float: left;width: 100%;">
    <p style="text-align: right;">Photo by: phtographer Credit</p>
</div>
<div style="float: left;width: 100%;">
  <h4 style="font-size: 18px;margin-bottom: 0;">Company name | Business type</h4>
  <p style="margin: 5px 0;">Business Desription</p>
</div>
<h4 style="border: 1px solid #ccc"></h4>
<div style="width: 47%;float: left;border-right: 2px solid #ccc; padding-right:3%">
  <p><strong>Photo info</strong></p>
  <table>
    <tr>
      <td>
        Project
      </td>
      <td>
        Product
      </td>
    </tr>
  </table>
  <div>
    <table>
     	<tr>
     		<td style="text-align:right">This is for:</td>
     		<td>wdwqewqeqwe</td>
     	</tr>
     	<tr>
     		<td style="text-align:right">Style:</td>
     		<td>wdwqewqeqwe</td>
     	</tr>
     	<tr>
     		<td style="text-align:right">Category:</td>
     		<td>wdwqewqeqwe</td>
     	</tr>
     	<tr>
     		<td style="text-align:right">Location:</td>
     		<td>wdwqewqeqwe</td>
     	</tr>
    </table>
  </div>
  <h4 style="border: 1px solid #ccc"></h4>
  <p><strong>Desription: </strong></p>
  <p>The #maverick #planter is a strikingly #modern take on the #traditional #container shown here in #bronze • #design #hospitality #indoor #landsca</p>
  <h4 style="border: 1px solid #ccc"></h4>
  <p><strong>Product info: </strong></p>
  <div>
    <table>
     	<tr>
     		<td style="text-align:right">Avalible in:</td>
     		<td>wdwqewqeqwe</td>
     	</tr>
     	<tr>
     		<td style="text-align:right">Sample Qty:</td>
     		<td>wdwqewqeqwe</td>
     	</tr>
     	<tr>
     		<td style="text-align:right">Sample Price:</td>
     		<td>wdwqewqeqwe</td>
     	</tr>
   
    </table>
  </div>
  <p><strong>Ceritifcations: </strong></p>
  <p>sdfsdfdsfagf f dsfsadf</p>
</div>
<div style="width: 46% ;float: left; padding-left:3%">
	<p><strong>Company info: </strong></p>
	 <table>
     	<tr>
     		<td style="text-align:right">Toll free:</td>
     		<td>wdwqewqeqwe</td>
     	</tr>
     	<tr>
     		<td style="text-align:right">Local phone:</td>
     		<td>wdwqewqeqwe</td>
     	</tr>
     	<tr>
     		<td style="text-align:right">Email:</td>
     		<td>wdwqewqeqwe</td>
     	</tr>
   		<tr>
     		<td style="text-align:right">Website:</td>
     		<td>wdwqewqeqwe</td>
     	</tr>
     	<tr>
     		<td style="text-align:right">Address:</td>
     		<td>wdwqewqeqwe</td>
     	</tr>
     	<tr>
     		<td style="text-align:right">City, State:</td>
     		<td>wdwqewqeqwe</td>
     	</tr>
     	<tr>
     		<td style="text-align:right">Zipcode:</td>
     		<td>wdwqewqeqwe</td>
     	</tr>
     	<tr>
     		<td style="text-align:right">Country:</td>
     		<td>wdwqewqeqwe</td>
     	</tr>
     	<tr>
     		<td style="text-align:right">Profile URL:</td>
     		<td>wdwqewqeqwe</td>
     	</tr>
    </table>
    <p style="text-align:center;"><a style="color:#37a7a7 ;width:100%;text-decoration: none;" href ="sfdfdsfsdfsd">Click to find a local rep</a></p>
    <h4 style="border: 1px solid #ccc"></h4>
    <p><strong>About: </strong></p>
    <p>sererewrwerwrewrwerwrwerwrewrewrwerwerewrewrwer wewrwerwer wer wer <a href ="sfdfdsfsdfsd" style="color:#37a7a7;text-decoration: none;">...MORE</a></p>
    <h4 style="border: 1px solid #ccc"></h4>
    <p><strong>Service Area: </strong></p>
    <p>sdfds, f sdfsd fdsf ds, sd fsd fsd ds, f dsfs</p>
</div>
<div style="width:100%; float:left ;margin-top:30px;">
	<div style="width:33.3%;float:left; text-align:center">
		<a href="http://stackoverflow.com/questions/16538109/change-top-margin-of-second-page-using-mpdf" style="text-align:center; font-size:18px;text-decoration: none;"><img src="http://localhost:8888/MPDF_6_0/this-view-image.png"></a>
	</div>
	<div style="width:33.3%;float:left;text-align:center">
		<a href="http://stackoverflow.com/questions/16538109/change-top-margin-of-second-page-using-mpdf" style="text-align:center text-decoration: none;"><img src ="http://localhost:8888/MPDF_6_0/this-view-catalog.png"></a>
	</div>
	<div style="width:33.3%;float:left;text-align:center">
		<a href="http://stackoverflow.com/questions/16538109/change-top-margin-of-second-page-using-mpdf" style="text-align:center;text-decoration: none;"><img src ="http://localhost:8888/MPDF_6_0/request-a-quote.png"></a>
	</div>
</div>
<div style="width:100%; float:left ;margin-top:30px; font-size:12px;">
	<div style="width:20%; float:left ;text-align:left;">&copy; Dezignwall Inc.</div>
	<div style="width:25%; float:left ;text-align:center;">2014 All Right Reserved</div>
	<div style="width:25%; float:left ;text-align:center;">WWW.Dezignwall.com</div>
	<div style="width:15%; float:left ;text-align:center;">&copy; Dezignwall</div>
	<div style="width:15%; float:left;text-align:right">#Dezignwall</div>
</div>
');
$mpdf->Output();
exit();