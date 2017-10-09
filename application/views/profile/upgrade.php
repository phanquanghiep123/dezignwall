<?php 
	$value = $package[0];
	$post = null;
	if ($this->session->userdata('info_credit')) {
		$info_credit = $this->session->userdata('info_credit');
		$post = $info_credit['fields'];
	}
?>
<section class="section box-wapper-show-image box-wapper-secondary">
	<div class="container">
		<p class="h2 text-center"><strong>Secure Upgrade...</strong>Put your brand top of mind!</p>
	</div>
</section>
	
<section class="section box-wapper-show-image">
	<div class="container">
		<?php if ($post != null) : ?>
		<div class="alert alert-danger">
			<strong>Payment fail</strong> sorry your payment failed. Please try again.
		</div>
		<?php else : ?>
			<?php if ($this->session->flashdata('message')) : ?>
		        <div class="alert alert-success"><?php echo $this->session->flashdata('message'); ?></div>
		    <?php endif; ?>
		<?php endif; ?>
		<div class="upgrade-panel panel-shadow">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="row">
						<div class="col-sm-6 border-right-sm">
							<div class="media">
								<div class="media-left">
									<span class="mo-num"><?php echo $value['name']; ?></span>
								</div>
								<div class="media-body  media-middle">
									<span class="mo-text">Month<br>plan</span>
								</div>
							</div>
						</div>
						<div class="col-sm-6 text-center-sm">
							<span class="wrap">
								<?php echo $value['summary']; ?>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="upgrade-panel none-style">
			<p><img class="align-bottom" src="<?php echo skin_url('images/icon-lock.png') ?>"><big> Enter secure payment details</big></p>
		</div>
		<form class="form-horizontal form-gray" action="<?php echo base_url("/checkout/payment"); ?>" method="POST" id="form-purchase">
			<div class="upgrade-panel">
				<div class="custom">
					<div class="checkbox check-yelow checkbox-circle">
	                    <input id="payment_paypal" name="payment_paypal" class="" type="checkbox" value="<?php echo $value['id']; ?>">
	                    <label for="designwall_newlettter">Pay with <img src="<?php echo skin_url('images/logo-paypal.png') ?>"></label>
	                </div>
	            </div>
			</div>
			<div class="space-10"></div>
			<div class="upgrade-panel remove-margin">
				<div class="custom">
					<div class="checkbox check-yelow checkbox-circle">
	                    <input id="payment_credit" checked="checked" name="payment_credit" class="" type="checkbox" value="1">
	                    <label for="designwall_newlettter">Pay with a credit card</label>
	                </div>
	            </div>
			</div>
			<div class="upgrade-panel remove-border-top">
				<div class="payment-logos text-center">
					<img src="<?php echo skin_url('images/logo-payment-visa.png')?>" alt="Visa">
					<img src="<?php echo skin_url('images/logo-payment-paypal.png')?>" alt="Paypal">
					<img src="<?php echo skin_url('images/logo-payment-ae.png')?>" alt="American Express">
					<img src="<?php echo skin_url('images/logo-payment-discover.png')?>" alt="Discover">
					<img src="<?php echo skin_url('images/logo-payment-master.png')?>" alt="Master Card">
				</div>
				<div class="form-group">
	    			<label for="inputEmail3" class="col-sm-4 control-label"></label>
		    		<div class="col-sm-8">
		      			<div class="alert alert-danger error-client" style="display:none;">
							
						</div>
		    		</div>
	  			</div>
	  			<div class="form-group">
	    			<label for="inputEmail3" class="col-sm-4 control-label">First Name:</label>
		    		<div class="col-sm-8">
		      			<input type="text" class="form-control" title="First Name" data-valid="true" maxlength="50" id="first_name" name="first_name">
		    		</div>
	  			</div>
	  			<div class="form-group">
	    			<label for="inputEmail3" class="col-sm-4 control-label">Last Name:</label>
		    		<div class="col-sm-8">
		      			<input type="text" class="form-control" title="Last Name" data-valid="true" maxlength="50" id="last_name" name="last_name">
		    		</div>
	  			</div>
	  			<div class="form-group">
	    			<label for="inputEmail3" class="col-sm-4 control-label">Address 1:</label>
		    		<div class="col-sm-8">
		      			<input type="text" class="form-control" title="Address 1" data-valid="true" maxlength="200" id="address1" name="address1">
		    		</div>
	  			</div>
	  			<div class="form-group">
	    			<label for="inputEmail3" class="col-sm-4 control-label">Address 2 (option):</label>
		    		<div class="col-sm-8">
		      			<input type="text" class="form-control" title="Address 2" maxlength="200" id="address2" name="address2">
		    		</div>
	  			</div>
	  			<div class="form-group">
	    			<label for="inputEmail3" class="col-sm-4 control-label">City/Zip:</label>
		    		<div class="col-sm-4">
		      			<input type="text" class="form-control" title="City" data-valid="true" maxlength="50" id="city" name="city" placeholder="City">
		    		</div>
		    		<div class="col-sm-4">
		      			<input type="number" class="form-control format-number" title="Zip Code" maxlength="10" id="zipcode" name="zipcode" placeholder="Zip">
		    		</div>
		    	</div>
	  			<div class="form-group">
	    			<label for="inputEmail3" class="col-sm-4 control-label">State/Country:</label>
		    		<div class="col-sm-4">
		      			<input type="text" class="form-control" data-valid="true" title="State" maxlength="20" id="state" name="state" placeholder="State">
		    		</div>
		    		<div class="col-sm-4">
		      			<select name="country" class="form-control" title="Country" style="width:100%;" id="country" required="required">
                        		<option value="GB">United Kingdom</option>
                        		<option value="US" selected="selected">United States</option>
                        		<option value="AF">Afghanistan</option>
                        		<option value="AL">Albania</option>
                        		<option value="DZ">Algeria</option>
                        		<option value="AS">American Samoa</option>
                        		<option value="AD">Andorra</option>
                        		<option value="AO">Angola</option>
                        		<option value="AI">Anguilla</option>
                        		<option value="AQ">Antarctica</option>
                        		<option value="AG">Antigua And Barbuda</option>
                        		<option value="AR">Argentina</option>
                        		<option value="AM">Armenia</option>
                        		<option value="AW">Aruba</option>
                        		<option value="AU">Australia</option>
                        		<option value="AT">Austria</option>
                        		<option value="AZ">Azerbaijan</option>
                        		<option value="BS">Bahamas</option>
                        		<option value="BD">Bangladesh</option>
                        		<option value="BB">Barbados</option>
                        		<option value="BY">Belarus</option>
                        		<option value="BE">Belgium</option>
                        		<option value="BZ">Belize</option>
                        		<option value="BJ">Benin</option>
                        		<option value="BM">Bermuda</option>
                        		<option value="BT">Bhutan</option>
                        		<option value="BO">Bolivia</option>
                        		<option value="BA">Bosnia And Herzegowina</option>
                        		<option value="BW">Botswana</option>
                        		<option value="BV">Bouvet Island</option>
                        		<option value="BR">Brazil</option>
                        		<option value="IO">British Indian Ocean Territory</option>
                        		<option value="BN">Brunei Darussalam</option>
                        		<option value="BG">Bulgaria</option>
                        		<option value="BF">Burkina Faso</option>
                        		<option value="BI">Burundi</option>
                        		<option value="KH">Cambodia</option>
                        		<option value="CM">Cameroon</option>
                        		<option value="CA">Canada</option>
                        		<option value="CV">Cape Verde</option>
                        		<option value="KY">Cayman Islands</option>
                        		<option value="CF">Central African Republic</option>
                        		<option value="TD">Chad</option>
                        		<option value="CL">Chile</option>
                        		<option value="CN">China</option>
                        		<option value="CX">Christmas Island</option>
                        		<option value="CC">Cocos (Keeling) Islands</option>
                        		<option value="CO">Colombia</option>
                        		<option value="KM">Comoros</option>
                        		<option value="CG">Congo</option>
                        		<option value="CD">Congo, The Democratic Republic Of The</option>
                        		<option value="CK">Cook Islands</option>
                        		<option value="CR">Costa Rica</option>
                        		<option value="CI">Cote D'Ivoire</option>
                        		<option value="HR">Croatia (Local Name: Hrvatska)</option>
                        		<option value="CU">Cuba</option>
                        		<option value="CY">Cyprus</option>
                        		<option value="CZ">Czech Republic</option>
                        		<option value="DK">Denmark</option>
                        		<option value="DJ">Djibouti</option>
                        		<option value="DM">Dominica</option>
                        		<option value="DO">Dominican Republic</option>
                        		<option value="TP">East Timor</option>
                        		<option value="EC">Ecuador</option>
                        		<option value="EG">Egypt</option>
                        		<option value="SV">El Salvador</option>
                        		<option value="GQ">Equatorial Guinea</option>
                        		<option value="ER">Eritrea</option>
                        		<option value="EE">Estonia</option>
                        		<option value="ET">Ethiopia</option>
                        		<option value="FK">Falkland Islands (Malvinas)</option>
                        		<option value="FO">Faroe Islands</option>
                        		<option value="FJ">Fiji</option>
                        		<option value="FI">Finland</option>
                        		<option value="FR">France</option>
                        		<option value="FX">France, Metropolitan</option>
                        		<option value="GF">French Guiana</option>
                        		<option value="PF">French Polynesia</option>
                        		<option value="TF">French Southern Territories</option>
                        		<option value="GA">Gabon</option>
                        		<option value="GM">Gambia</option>
                        		<option value="GE">Georgia</option>
                        		<option value="DE">Germany</option>
                        		<option value="GH">Ghana</option>
                        		<option value="GI">Gibraltar</option>
                        		<option value="GR">Greece</option>
                        		<option value="GL">Greenland</option>
                        		<option value="GD">Grenada</option>
                        		<option value="GP">Guadeloupe</option>
                        		<option value="GU">Guam</option>
                        		<option value="GT">Guatemala</option>
                        		<option value="GN">Guinea</option>
                        		<option value="GW">Guinea-Bissau</option>
                        		<option value="GY">Guyana</option>
                        		<option value="HT">Haiti</option>
                        		<option value="HM">Heard And Mc Donald Islands</option>
                        		<option value="VA">Holy See (Vatican City State)</option>
                        		<option value="HN">Honduras</option>
                        		<option value="HK">Hong Kong</option>
                        		<option value="HU">Hungary</option>
                        		<option value="IS">Iceland</option>
                        		<option value="IN">India</option>
                        		<option value="ID">Indonesia</option>
                        		<option value="IR">Iran (Islamic Republic Of)</option>
                        		<option value="IQ">Iraq</option>
                        		<option value="IE">Ireland</option>
                        		<option value="IL">Israel</option>
                        		<option value="IT">Italy</option>
                        		<option value="JM">Jamaica</option>
                        		<option value="JP">Japan</option>
                        		<option value="JO">Jordan</option>
                        		<option value="KZ">Kazakhstan</option>
                        		<option value="KE">Kenya</option>
                        		<option value="KI">Kiribati</option>
                        		<option value="KP">Korea, Democratic People's Republic Of</option>
                        		<option value="KR">Korea, Republic Of</option>
                        		<option value="KW">Kuwait</option>
                        		<option value="KG">Kyrgyzstan</option>
                        		<option value="LA">Lao People's Democratic Republic</option>
                        		<option value="LV">Latvia</option>
                        		<option value="LB">Lebanon</option>
                        		<option value="LS">Lesotho</option>
                        		<option value="LR">Liberia</option>
                        		<option value="LY">Libyan Arab Jamahiriya</option>
                        		<option value="LI">Liechtenstein</option>
                        		<option value="LT">Lithuania</option>
                        		<option value="LU">Luxembourg</option>
                        		<option value="MO">Macau</option>
                        		<option value="MK">Macedonia, Former Yugoslav Republic Of</option>
                        		<option value="MG">Madagascar</option>
                        		<option value="MW">Malawi</option>
                        		<option value="MY">Malaysia</option>
                        		<option value="MV">Maldives</option>
                        		<option value="ML">Mali</option>
                        		<option value="MT">Malta</option>
                        		<option value="MH">Marshall Islands</option>
                        		<option value="MQ">Martinique</option>
                        		<option value="MR">Mauritania</option>
                        		<option value="MU">Mauritius</option>
                        		<option value="YT">Mayotte</option>
                        		<option value="MX">Mexico</option>
                        		<option value="FM">Micronesia</option>
                        		<option value="MD">Moldova, Republic Of</option>
                        		<option value="MC">Monaco</option>
                        		<option value="MN">Mongolia</option>
                        		<option value="MS">Montserrat</option>
                        		<option value="MA">Morocco</option>
                        		<option value="MZ">Mozambique</option>
                        		<option value="MM">Myanmar</option>
                        		<option value="NA">Namibia</option>
                        		<option value="NR">Nauru</option>
                        		<option value="NP">Nepal</option>
                        		<option value="NL">Netherlands</option>
                        		<option value="AN">Netherlands Antilles</option>
                        		<option value="NC">New Caledonia</option>
                        		<option value="NZ">New Zealand</option>
                        		<option value="NI">Nicaragua</option>
                        		<option value="NE">Niger</option>
                        		<option value="NG">Nigeria</option>
                        		<option value="NU">Niue</option>
                        		<option value="NF">Norfolk Island</option>
                        		<option value="MP">Northern Mariana Islands</option>
                        		<option value="NO">Norway</option>
                        		<option value="OM">Oman</option>
                        		<option value="PK">Pakistan</option>
                        		<option value="PW">Palau</option>
                        		<option value="PA">Panama</option>
                        		<option value="PG">Papua New Guinea</option>
                        		<option value="PY">Paraguay</option>
                        		<option value="PE">Peru</option>
                        		<option value="PH">Philippines</option>
                        		<option value="PN">Pitcairn</option>
                        		<option value="PL">Poland</option>
                        		<option value="PT">Portugal</option>
                        		<option value="PR">Puerto Rico</option>
                        		<option value="QA">Qatar</option>
                        		<option value="RE">Reunion</option>
                        		<option value="RO">Romania</option>
                        		<option value="RU">Russian Federation</option>
                        		<option value="RW">Rwanda</option>
                        		<option value="KN">Saint Kitts And Nevis</option>
                        		<option value="LC">Saint Lucia</option>
                        		<option value="VC">Saint Vincent And The Grenadines</option>
                        		<option value="WS">Samoa</option>
                        		<option value="SM">San Marino</option>
                        		<option value="ST">Sao Tome And Principe</option>
                        		<option value="SA">Saudi Arabia</option>
                        		<option value="SN">Senegal</option>
                        		<option value="SC">Seychelles</option>
                        		<option value="SL">Sierra Leone</option>
                        		<option value="SG">Singapore</option>
                        		<option value="SK">Slovakia (Slovak Republic)</option>
                        		<option value="SI">Slovenia</option>
                        		<option value="SB">Solomon Islands</option>
                        		<option value="SO">Somalia</option>
                        		<option value="ZA">South Africa</option>
                        		<option value="GS">South Georgia, South Sandwich Islands</option>
                        		<option value="ES">Spain</option>
                        		<option value="LK">Sri Lanka</option>
                        		<option value="SH">St. Helena</option>
                        		<option value="PM">St. Pierre And Miquelon</option>
                        		<option value="SD">Sudan</option>
                        		<option value="SR">Suriname</option>
                        		<option value="SJ">Svalbard And Jan Mayen Islands</option>
                        		<option value="SZ">Swaziland</option>
                        		<option value="SE">Sweden</option>
                        		<option value="CH">Switzerland</option>
                        		<option value="SY">Syrian Arab Republic</option>
                        		<option value="TW">Taiwan</option>
                        		<option value="TJ">Tajikistan</option>
                        		<option value="TZ">Tanzania, United Republic Of</option>
                        		<option value="TH">Thailand</option>
                        		<option value="TG">Togo</option>
                        		<option value="TK">Tokelau</option>
                        		<option value="TO">Tonga</option>
                        		<option value="TT">Trinidad And Tobago</option>
                        		<option value="TN">Tunisia</option>
                        		<option value="TR">Turkey</option>
                        		<option value="TM">Turkmenistan</option>
                        		<option value="TC">Turks And Caicos Islands</option>
                        		<option value="TV">Tuvalu</option>
                        		<option value="UG">Uganda</option>
                        		<option value="UA">Ukraine</option>
                        		<option value="AE">United Arab Emirates</option>
                        		<option value="UM">United States Minor Outlying Islands</option>
                        		<option value="UY">Uruguay</option>
                        		<option value="UZ">Uzbekistan</option>
                        		<option value="VU">Vanuatu</option>
                        		<option value="VE">Venezuela</option>
                        		<option value="VN">Viet Nam</option>
                        		<option value="VG">Virgin Islands (British)</option>
                        		<option value="VI">Virgin Islands (U.S.)</option>
                        		<option value="WF">Wallis And Futuna Islands</option>
                        		<option value="EH">Western Sahara</option>
                        		<option value="YE">Yemen</option>
                        		<option value="YU">Yugoslavia</option>
                        		<option value="ZM">Zambia</option>
                        		<option value="ZW">Zimbabwe</option>
                        </select>
		    		</div>
	  			</div>
	  			
	  			<div class="form-group">
	    			<label for="inputEmail3" class="col-sm-4 control-label">Credit Card Number:</label>
		    		<div class="col-sm-8">
		      			<input type="number" class="form-control" title="Credit Card" maxlength="20" id="card_number" name="card_number">
		    		</div>
	  			</div>
	  			<div class="form-group">
	    			<label for="inputEmail3" class="col-sm-4 control-label">Security Code:</label>
		    		<div class="col-sm-4">
		      			<input type="text" class="form-control" title="Security Code" maxlength="6" data-valid="true" data-valid="true" id="security_code" name="security_code">
		    		</div>
		    		<div class="col-sm-4">
		    			<a class="form-icon-help" href="#" data-toggle="modal" data-target="#intro-security-code"><img src="<?php echo skin_url('images/icon-help.png')?>"></a>
		    		</div>
	  			</div>
	  			<div class="form-group">
        	    			<label for="inputEmail3" class="col-sm-4 control-label">Expiration Date:</label>
        		    		<div class="col-sm-4">
        		      			<input type="number" class="form-control format-number-advance" title="Month" min="1" max="12" maxlength="2" id="month" name="month" placeholder="Month">
        		    		</div>
        		    		<div class="col-sm-4">
        		      			<input type="number" class="form-control format-number-advance" title="Year" min="2016" max="3000" maxlength="4" id="year" name="year" placeholder="Year">
        		      			<input type="hidden" name="package_id" id="package_id" value="<?php echo $value['id']; ?>" />
        		      			<input type="hidden" name="card_type" id="card_type" value="" />
        		    		</div>
	  			</div>
	  			<button class="btn btn-lg btn-primary pull-right remove-margin submit-purchase">Complete Purchase</button>
	  			<div class="row"></div>
		  		<div class="space-20"></div>
		  		<p class="text-center">I agree with the Terms and Conditions and understand that this upgrade is non-refundable</p>
		  		<div class="space-10"></div>
			</div>
			<p class="text-center">Your credit card will be charge when you click Complete Purchase. A copy of your subscription details
will be sent to you via email for your records. To manage your account, visit the advanced settings in
Profile Page. At the end of your current upgrade, Dezignwall will automatically continue your subscription
for the same period and amount as your current upgrade. Upgrade today and start promotion your brand.</p>
		</form>
	</div>
</section>

<div class="modal modal-no-radius fade" id="intro-security-code" tabindex="-1" role="dialog" aria-labelledby="Intro Security Code">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content text-center">
    		<div class="modal-body">
	    		<h3>What’s the security code (or CVV Code)?</h3>
	    		<div class="space-20"></div>
	    		<p>The security code is the 3 digit value printed on the signature panel
	located on the back of your card. It is the last 3 numbers in that area.</p>
				<div class="space-20"></div>
				<div class="space-10"></div>
				<img src="<?php echo skin_url('images/img-intro-sercurity-code.png')?>">
				<div class="space-20"></div>
				<div class="space-10"></div>
				<p>American Express Cards: the security code is the  digit value printed
	(not-embossed) above your account number on the front of your card.</p>
				<div class="text-right">
					<button class="btn btn-primary" type="button" data-dismiss="modal" aria-label="Close">Close</button>
				</div>
			</div>
    	</div>
    </div>
</div>

<script src="<?php echo skin_url(); ?>/js/jquery.creditCardValidator.js"></script>
<script type="text/javascript">
	$("#payment_paypal").click(function () {
		var id = $(this).val();
		$("#payment_credit").removeAttr("checked");
		document.location.href = "<?php echo base_url('/checkout/process'); ?>/" + id;
	});
	
	var valid_card = false;
	var card_type = 'unknown';
	$(function() {
		<?php 
			if ($post != null) :
				foreach ($post as $key => $val) :
					echo '$("#'.$key.'").val("' . $val . '");';
				endforeach;
			endif;
		?>
		
		$("#payment_paypal").removeAttr("checked");
        $('#card_number').validateCreditCard(function(result) {
            valid_card = result.valid;
            card_type = (result.card_type == null ? 'unknown' : result.card_type.name);
            $('#card_type').val(card_type);
            if (result.valid) {
            	$(this).removeClass('warning');
            } else {
            	if ($(this).val().length > 0) {
            		$(this).addClass('warning');
            	}
            }
        });
    });
    $(".submit-purchase").click(function () {
    	$(this).attr('disabled','disabled');
    	var valid = valid_form($('#form-purchase'), "warning", false);
    	if (valid == true) {
    		if ($.trim($('#month').val()) == '') {
    			$('#month').addClass('warning');
    			$(".error-client").html("Please enter required field Month");
    			$(".error-client").show();
				$(this).removeAttr('disabled');
				return false;
    		}
    		if (!valid_card) {
    			$(".error-client").html("Invalid card number.");
    			$(".error-client").show();
				$(this).removeAttr('disabled');
				return false;
			}
			$(".error-client").html("");
    		$(".error-client").hide();
			$('#form-purchase').submit();
			return true;
    	}
    	$(".error-client").html(valid);
    	$(".error-client").show();
    	$(this).removeAttr('disabled');
		return false;
	});
</script>