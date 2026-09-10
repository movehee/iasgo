<?php
	$pageType = 'sub';
	include $_SERVER['DOCUMENT_ROOT'] . '/include/onsite/include.init.php';

	$feeList = $_ONSITE['fee_kor'];
	$gubun1List = $_ONSITE['gubun1'];
	$gubun2List = $_ONSITE['gubun2_kor'];
	$payMethodList = $_ONSITE['pay_method_kor'];
	$phonePrefix = $_ONSITE['domestic_phone_prefix']; // 국내 +82 prefix 고정

	include $_SERVER['DOCUMENT_ROOT'] . '/include/onsite/include.header.php';
?>
<div class="sub-conbox inner-layer">
	<div class="sub-tit-wrap minus">
		<h3 class="sub-tit">Personal Information</h3>
	</div>
	<div class="write-form-wrap">
		<form action="/onsite/post.php" method="post" id="onsiteForm" name="onsiteForm">
			<input type="hidden" name="reg_type" value="K">
			<input type="hidden" name="nation_code" id="nation_code" value="KR">
			<fieldset>
				<legend class="hide">등록</legend>
				<ul class="write-wrap">
					<li>
						<div class="form-tit">E-mail <strong class="required">*</strong></div>
						<div class="form-con">
							<div class="form-group has-btn">
								<input type="text" name="email" id="email" class="form-item js-no-space" maxlength="255" autocomplete="off">
								<button type="button" class="btn btn-type1 color-type-gra1 js-email-check" data-lang="kor">중복체크</button>
							</div>
						</div>
					</li>
					<li>
						<div class="form-tit">국가 Country <strong class="required">*</strong></div>
						<div class="form-con">
							<input type="text" class="form-item" value="Korea" readonly>
						</div>
					</li>
					<li>
						<div class="form-tit">First Name (영문) <strong class="required">*</strong></div>
						<div class="form-con">
							<input type="text" name="first_name" id="first_name" class="form-item js-eng-only" maxlength="50" autocomplete="off">
							<div class="help-text mt-10">ex) Gildong</div>
						</div>
					</li>
					<li>
						<div class="form-tit">Last Name (영문) <strong class="required">*</strong></div>
						<div class="form-con">
							<input type="text" name="last_name" id="last_name" class="form-item js-eng-only" maxlength="50" autocomplete="off">
							<div class="help-text mt-10">ex) Hong</div>
						</div>
					</li>
					<li>
						<div class="form-tit">성명 (국문) <strong class="required">*</strong></div>
						<div class="form-con">
							<input type="text" name="name_kr" id="name_kr" class="form-item js-kor-only" maxlength="50" autocomplete="off">
							<div class="help-text mt-10">ex) 홍길동 (공백없이 기입)</div>
						</div>
					</li>
					<li>
						<div class="form-tit">소속 기관 (국문) <strong class="required">*</strong></div>
						<div class="form-con">
							<input type="text" name="aff_kor" id="aff_kor" class="form-item" maxlength="255">
						</div>
					</li>
					<li>
						<div class="form-tit">소속 기관 (영문) <strong class="required">*</strong></div>
						<div class="form-con">
							<input type="text" name="aff_eng" id="aff_eng" class="form-item" maxlength="255">
							<div class="help-text mt-10">* Hankook University College of Medicine</div>
						</div>
					</li>
					<li>
						<div class="form-tit">부서</div>
						<div class="form-con">
							<input type="text" name="depart_kor" id="depart_kor" class="form-item" maxlength="255">
						</div>
					</li>
					<li>
						<div class="form-tit">핸드폰 번호 <strong class="required">*</strong></div>
						<div class="form-con">
							<div class="form-group form-group-text">
								<span class="text"><?=$phonePrefix?> - </span>
								<input type="text" name="cell" id="cell" class="form-item js-digit-only" maxlength="30" inputmode="numeric" autocomplete="off">
							</div>
						</div>
					</li>
					<li>
						<div class="form-tit">의사면허 번호 <strong class="required">*</strong></div>
						<div class="form-con">
							<div class="form-group has-btn">
								<input type="text" name="license_number" id="license_number" class="form-item js-digit-only" maxlength="255" inputmode="numeric" autocomplete="off">
								<div class="checkbox-wrap cst">
									<label for="license_none" class="checkbox-group">
										<input type="checkbox" name="license_none" id="license_none" value="Y">
										면허번호 없음
									</label>
								</div>
							</div>
							<div class="help-text mt-10">
								평점 신청을 위해 [의사면허 번호]를 기재해 주시기 바랍니다. <br>
								(*해당사항이 없으신 경우 '면허번호 없음'을 선택해 주세요.)
							</div>
						</div>
					</li>
					<li>
						<div class="form-tit">구분 선택 <strong class="required">*</strong></div>
						<div class="form-con">
							<div class="radio-wrap cst">
								<?php
									foreach ($gubun1List as $gKey => $gLabel):
										$isEtc = ($gKey == '99');
								?>
									<label for="gubun1_<?=$gKey?>" class="radio-group">
										<input type="radio" name="gubun1" id="gubun1_<?=$gKey?>" value="<?=$gKey?>" class="js-gubun1">
										<?=$gLabel?>
										<?php if ($isEtc): ?>
											<input type="text" name="gubun1_etc" id="gubun1_etc" class="form-item" placeholder="기타" style="display:none;" disabled>
										<?php endif; ?>
									</label>
								<?php endforeach; ?>
							</div>
						</div>
					</li>
					<li>
						<div class="form-tit">소속 선택 <strong class="required">*</strong></div>
						<div class="form-con">
							<div class="radio-wrap cst">
								<?php
									foreach ($gubun2List as $gKey => $gLabel):
										$isEtc = ($gKey == '99');
								?>
									<label for="gubun2_<?=$gKey?>" class="radio-group">
										<input type="radio" name="gubun2" id="gubun2_<?=$gKey?>" value="<?=$gKey?>" class="js-gubun2">
										<?=$gLabel?>
										<?php if ($isEtc): ?>
											<input type="text" name="gubun2_etc" id="gubun2_etc" class="form-item" placeholder="기타" style="display:none;" disabled>
										<?php endif; ?>
									</label>
								<?php endforeach; ?>
							</div>
						</div>
					</li>
				</ul>
				<div class="sub-tit-wrap">
					<h3 class="sub-tit">등록비 정보</h3>
				</div>
				<div class="table-wrap">
					<table class="cst-table">
						<caption class="hide">등록비 정보</caption>
						<colgroup>
							<col>
							<col>
						</colgroup>
						<thead>
							<tr>
								<th scope="col">참가구분</th>
								<th scope="col">현장등록 비용</th>
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
									<td>&#8361; <?=number_format($feePrice)?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<div class="bg-box mt-30">
					* 대한소화기암연구학회(KSGC), 대한종양외과학회(KSSO) 회원은 [IASGO Member]로 등록하실 수 있습니다. <br>
					* 회원이 아니신 경우에도, IASGO Full Membership으로 등록하신 후 회원자격으로 IASGO Member로 등록하시면 보다 저렴하게 등록하실 수 있습니다. <br>
					<a href="https://iasgo.net/member-app.html" target="_blank" class="link">▶ <u>IASGO Membership 등록 바로 가기</u></a>
				</div>
				<div class="sub-tit-wrap">
					<h3 class="sub-tit">결제 정보</h3>
				</div>
				<ul class="write-wrap">
					<li>
						<div class="form-tit">결제금액</div>
						<div class="form-con">
							<span id="payTotalText">&#8361; 0</span>
						</div>
					</li>
					<li>
						<div class="form-tit">결제방법</div>
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

		function updatePayInfo() {
			let $fee = $('.js-fee:checked');
			if ($fee.length) {
				$('#payTotalText').text(Onsite.formatWon($fee.data('price')));
			} else {
				$('#payTotalText').text(Onsite.formatWon(0));
			}
		}

		$(document).on('change', '.js-fee', updatePayInfo);
		$(document).on('change', '.js-gubun1', function () {
			Onsite.toggleEtc($('.js-gubun1'), '#gubun1_etc');
		});
		$(document).on('change', '.js-gubun2', function () {
			Onsite.toggleEtc($('.js-gubun2'), '#gubun2_etc');
		});
		$(document).on('click', '.js-email-check', function () {
			Onsite.checkEmailDuplicate($(this).data('lang') || 'kor');
		});
		$(document).on('input', '#email', function () {
			$(this).data('email-checked', '');
		});

		$('#onsiteForm').on('submit', function () {
			let email = $.trim($('#email').val()).replace(/\s+/g, '');
			$('#email').val(email);
			if (!email) {
				alert('E-mail을 입력해 주세요.');
				$('#email').focus();
				return false;
			}
			if (!Onsite.isValidEmail(email)) {
				alert('올바른 E-mail 형식이 아닙니다.');
				$('#email').focus();
				return false;
			}
			if (!Onsite.isEmailChecked(email)) {
				alert('E-mail 중복체크를 해 주세요.');
				$('#email').focus();
				return false;
			}
			let firstName = Onsite.normalizeEngName($('#first_name').val());
			$('#first_name').val(firstName);
			if (!firstName) {
				alert('First Name을 입력해 주세요.');
				$('#first_name').focus();
				return false;
			}
			if (!Onsite.isValidEngName(firstName)) {
				alert('First Name은 영문만 입력해 주세요.');
				$('#first_name').focus();
				return false;
			}
			let lastName = Onsite.normalizeEngName($('#last_name').val());
			$('#last_name').val(lastName);
			if (!lastName) {
				alert('Last Name을 입력해 주세요.');
				$('#last_name').focus();
				return false;
			}
			if (!Onsite.isValidEngName(lastName)) {
				alert('Last Name은 영문만 입력해 주세요.');
				$('#last_name').focus();
				return false;
			}
			if (!$('#name_kr').val()) {
				alert('성명(국문)을 입력해 주세요.');
				$('#name_kr').focus();
				return false;
			}
			if (!/^[가-힣]+$/.test($('#name_kr').val())) {
				alert('성명(국문)은 한글만, 공백 없이 입력해 주세요.');
				$('#name_kr').focus();
				return false;
			}
			if (!$('#aff_kor').val()) {
				alert('소속 기관(국문)을 입력해 주세요.');
				$('#aff_kor').focus();
				return false;
			}
			if (!$('#aff_eng').val()) {
				alert('소속 기관(영문)을 입력해 주세요.');
				$('#aff_eng').focus();
				return false;
			}
			if (!$('#cell').val()) {
				alert('핸드폰 번호를 입력해 주세요.');
				$('#cell').focus();
				return false;
			}
			if (!/^[0-9]+$/.test($('#cell').val())) {
				alert('핸드폰 번호는 숫자만 입력해 주세요.');
				$('#cell').focus();
				return false;
			}
			if (!$('#license_number').val()) {
				alert('의사면허 번호를 입력해 주세요.');
				$('#license_number').focus();
				return false;
			}
			if (!/^[0-9]+$/.test($('#license_number').val())) {
				alert('의사면허 번호는 숫자만 입력해 주세요.');
				$('#license_number').focus();
				return false;
			}
			if (!$('.js-gubun1:checked').length) {
				alert('구분 선택을 해 주세요.');
				return false;
			}
			if ($('.js-gubun1:checked').val() == '99' && !$('#gubun1_etc').val()) {
				alert('구분 기타 내용을 입력해 주세요.');
				$('#gubun1_etc').focus();
				return false;
			}
			if (!$('.js-gubun2:checked').length) {
				alert('소속 선택을 해 주세요.');
				return false;
			}
			if ($('.js-gubun2:checked').val() == '99' && !$('#gubun2_etc').val()) {
				alert('소속 기타 내용을 입력해 주세요.');
				$('#gubun2_etc').focus();
				return false;
			}
			if (!$('.js-fee:checked').length) {
				alert('등록비 카테고리를 선택해 주세요.');
				return false;
			}
			if (!$('input[name="pay_method"]:checked').length) {
				alert('결제방법을 선택해 주세요.');
				return false;
			}
			return true;
		});

		updatePayInfo();
	})(jQuery);
</script>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/include/onsite/include.footer.php'; ?>
