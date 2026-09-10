<?php
	$pageType = 'sub';
	include $_SERVER['DOCUMENT_ROOT'] . '/include/onsite/include.init.php';

	$feeList = $_ONSITE['fee_eng'];
	$gubun2List = $_ONSITE['gubun2_eng'];
	$payMethodList = $_ONSITE['pay_method_eng'];
	$countryList = isset($_Flag['country']) ? $_Flag['country'] : array();

	$countryPhoneMap = array();
	foreach ($countryList as $iso => $cinfo) {
		if ($iso == 'KR') {
			continue;
		}
		$countryPhoneMap[$iso] = isset($cinfo['cnum']) ? $cinfo['cnum'] : '';
	}

	include $_SERVER['DOCUMENT_ROOT'] . '/include/onsite/include.header.php';
?>
<div class="sub-conbox inner-layer">
	<div class="sub-tit-wrap minus">
		<h3 class="sub-tit">Personal Information</h3>
	</div>
	<div class="write-form-wrap">
		<form action="/onsite/post.php" method="post" id="onsiteForm" name="onsiteForm">
			<input type="hidden" name="reg_type" value="F">
			<input type="hidden" name="phone_prefix" id="phone_prefix" value="">
			<fieldset>
				<legend class="hide">Registration</legend>
				<ul class="write-wrap">
					<li>
						<div class="form-tit">E-mail <strong class="required">*</strong></div>
						<div class="form-con">
							<div class="form-group has-btn">
								<input type="text" name="email" id="email" class="form-item js-no-space" maxlength="255" autocomplete="off">
								<button type="button" class="btn btn-type1 color-type-gra1 js-email-check" data-lang="eng">Check</button>
							</div>
						</div>
					</li>
					<li>
						<div class="form-tit">Country <strong class="required">*</strong></div>
						<div class="form-con">
							<select name="nation_code" id="nation_code" class="form-item">
								<option value="">Select</option>
								<?php
									foreach ($countryList as $iso => $cinfo):
										if ($iso == 'KR') {
											continue;
										}
										$cn = isset($cinfo['cn']) ? $cinfo['cn'] : '';
								?>
									<option value="<?=$iso?>"><?=$cn?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</li>
					<li>
						<div class="form-tit">First Name (Given Name) <strong class="required">*</strong></div>
						<div class="form-con">
							<input type="text" name="first_name" id="first_name" class="form-item js-eng-only" maxlength="50" autocomplete="off">
						</div>
					</li>
					<li>
						<div class="form-tit">Last Name (Family Name) <strong class="required">*</strong></div>
						<div class="form-con">
							<input type="text" name="last_name" id="last_name" class="form-item js-eng-only" maxlength="50" autocomplete="off">
						</div>
					</li>
					<li>
						<div class="form-tit">Affiliation <strong class="required">*</strong></div>
						<div class="form-con">
							<input type="text" name="aff_eng" id="aff_eng" class="form-item" maxlength="255">
							<div class="help-text mt-10">
								* If you are a foreign resident in Korea, please provide your Korean institutional affiliation.
							</div>
						</div>
					</li>
					<li>
						<div class="form-tit">Department</div>
						<div class="form-con">
							<input type="text" name="depart_eng" id="depart_eng" class="form-item" maxlength="255">
						</div>
					</li>
					<li>
						<div class="form-tit">Phone Number <strong class="required">*</strong></div>
						<div class="form-con">
							<div class="form-group form-group-text">
								<span class="text" id="phonePrefixText" style="display:none;"></span>
								<input type="text" name="cell" id="cell" class="form-item js-digit-only" maxlength="30" inputmode="numeric" autocomplete="off">
							</div>
						</div>
					</li>
					<li>
						<div class="form-tit">Specialty</div>
						<div class="form-con">
							<div class="radio-wrap cst">
								<?php foreach ($gubun2List as $gKey => $gLabel): ?>
									<label for="gubun2_<?=$gKey?>" class="radio-group">
										<input type="radio" name="gubun2" id="gubun2_<?=$gKey?>" value="<?=$gKey?>">
										<?=$gLabel?>
									</label>
								<?php endforeach; ?>
							</div>
						</div>
					</li>
				</ul>
				<div class="sub-tit-wrap">
					<h3 class="sub-tit">Registration Fee</h3>
				</div>
				<div class="table-wrap">
					<table class="cst-table">
						<caption class="hide">Registration Fee</caption>
						<colgroup>
							<col>
							<col>
						</colgroup>
						<thead>
							<tr>
								<th scope="col">Category</th>
								<th scope="col">Registration Fees (Onsite)<br>(2026-09-09 ~ 2026-09-11)</th>
							</tr>
						</thead>
						<tbody>
							<?php
								foreach ($feeList as $feeKey => $feeRow):
									$feeTitle = $feeRow['title'];
									$feePrice = (int)$feeRow['price'];
							?>
								<tr>
									<td>
										<div class="checkbox-wrap cst">
											<label for="fee_<?=$feeKey?>" class="checkbox-group">
												<input type="radio" name="fee_code" id="fee_<?=$feeKey?>" value="<?=$feeKey?>" class="js-fee" data-title="<?=$feeTitle?>" data-price="<?=$feePrice?>">
												<?=$feeTitle?>
											</label>
										</div>
									</td>
									<td>$ <?=number_format($feePrice)?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<div class="bg-box mt-30">
					* If you are not currently an IASGO member, you may first register for IASGO Full Membership and then register for the congress under the IASGO Member category to receive the discounted registration fee. <a href="https://iasgo.net/member-app.html" target="_blank" class="link">Go to IASGO Membership</a> <br>
					* Registrants in the Medical Student category may be asked to provide supporting documents, such as a certificate of enrollment or a student ID card, to verify their student status.
				</div>
				<div class="sub-tit-wrap">
					<h3 class="sub-tit">Payment</h3>
				</div>
				<ul class="write-wrap">
					<li>
						<div class="form-tit">Amount of payment</div>
						<div class="form-con">
							<span id="payTotalText">$ 0</span>
						</div>
					</li>
					<li>
						<div class="form-tit">Payment Method</div>
						<div class="form-con">
							<div class="radio-wrap cst">
								<?php foreach ($payMethodList as $pKey => $pLabel): ?>
									<label for="pay_<?=$pKey?>" class="radio-group">
										<input type="radio" name="pay_method" id="pay_<?=$pKey?>" value="<?=$pKey?>">
										<?=$pLabel?>
									</label>
								<?php endforeach; ?>
							</div>
						</div>
					</li>
				</ul>
				<div class="btn-wrap text-center">
					<button type="submit" class="btn btn-type1 btn-round color-type-gra2">Registration</button>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<script type="text/javascript">
	(function ($) {
		const Onsite = window.OnsiteForm;
		const countryPhoneMap = <?=json_encode($countryPhoneMap)?>;

		function updatePayInfo() {
			let $fee = $('.js-fee:checked');
			if ($fee.length) {
				$('#payTotalText').text(Onsite.formatUsd($fee.data('price')));
			} else {
				$('#payTotalText').text(Onsite.formatUsd(0));
			}
		}

		function updatePhonePrefix() {
			let iso = $('#nation_code').val();
			let cnum = countryPhoneMap[iso] || '';
			if (iso && cnum) {
				$('#phonePrefixText').text('+' + cnum + ' - ').show();
				$('#phone_prefix').val('+' + cnum);
			} else {
				$('#phonePrefixText').text('').hide();
				$('#phone_prefix').val('');
			}
		}

		$(document).on('change', '.js-fee', updatePayInfo);
		$(document).on('change', '#nation_code', updatePhonePrefix);
		$(document).on('click', '.js-email-check', function () {
			Onsite.checkEmailDuplicate($(this).data('lang') || 'eng');
		});
		$(document).on('input', '#email', function () {
			$(this).data('email-checked', '');
		});

		$('#onsiteForm').on('submit', function () {
			let email = $.trim($('#email').val()).replace(/\s+/g, '');
			$('#email').val(email);
			if (!email) {
				alert('Please enter your E-mail.');
				$('#email').focus();
				return false;
			}
			if (!Onsite.isValidEmail(email)) {
				alert('Please enter a valid E-mail address.');
				$('#email').focus();
				return false;
			}
			if (!Onsite.isEmailChecked(email)) {
				alert('Please check your E-mail for duplicates.');
				$('#email').focus();
				return false;
			}
			if (!$('#nation_code').val() || $('#nation_code').val() == 'KR') {
				alert('Please select your Country.');
				$('#nation_code').focus();
				return false;
			}
			let firstName = Onsite.normalizeEngName($('#first_name').val());
			$('#first_name').val(firstName);
			if (!firstName) {
				alert('Please enter your First Name.');
				$('#first_name').focus();
				return false;
			}
			if (!Onsite.isValidEngName(firstName)) {
				alert('First Name must be English letters only.');
				$('#first_name').focus();
				return false;
			}
			let lastName = Onsite.normalizeEngName($('#last_name').val());
			$('#last_name').val(lastName);
			if (!lastName) {
				alert('Please enter your Last Name.');
				$('#last_name').focus();
				return false;
			}
			if (!Onsite.isValidEngName(lastName)) {
				alert('Last Name must be English letters only.');
				$('#last_name').focus();
				return false;
			}
			if (!$('#aff_eng').val()) {
				alert('Please enter your Affiliation.');
				$('#aff_eng').focus();
				return false;
			}
			if (!$('#cell').val()) {
				alert('Please enter your Phone Number.');
				$('#cell').focus();
				return false;
			}
			if (!/^[0-9]+$/.test($('#cell').val())) {
				alert('Phone Number must be digits only.');
				$('#cell').focus();
				return false;
			}
			if (!$('.js-fee:checked').length) {
				alert('Please select a Registration Fee category.');
				return false;
			}
			if (!$('input[name="pay_method"]:checked').length) {
				alert('Please select a Payment Method.');
				return false;
			}
			return true;
		});

		updatePayInfo();
		updatePhonePrefix();
	})(jQuery);
</script>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/include/onsite/include.footer.php'; ?>
