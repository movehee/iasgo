/**
 * IASGO 2026 On-Site Registration
 */
(function (window, $) {
	'use strict';

	function formatWon(num) {
		return '₩ ' + Number(num).toLocaleString('en-US');
	}

	function formatUsd(num) {
		return '$ ' + Number(num).toLocaleString('en-US');
	}

	function allowDigitKey(e) {
		let key = e.which || e.keyCode;
		if (e.ctrlKey || e.metaKey || key == 8 || key == 9 || key == 13) {
			return true;
		}
		// digits 0-9 only
		if (key >= 48 && key <= 57) {
			return true;
		}
		e.preventDefault();
		return false;
	}

	function allowEngKey(e) {
		let key = e.which || e.keyCode;
		if (e.ctrlKey || e.metaKey || key == 8 || key == 9 || key == 13) {
			return true;
		}
		// A-Z, a-z, space, apostrophe, hyphen
		if ((key >= 65 && key <= 90) || (key >= 97 && key <= 122) || key == 32 || key == 39 || key == 45) {
			return true;
		}
		e.preventDefault();
		return false;
	}

	function normalizeEngName(val) {
		val = $.trim(val || '');
		val = val.replace(/[\u2018\u2019\u02BC]/g, "'");
		val = val.replace(/[\u2013\u2014]/g, '-');
		val = val.replace(/\s+/g, ' ');
		return val;
	}

	function isValidEngName(val) {
		return /^[A-Za-z]+(?:['-][A-Za-z]+)*(?: [A-Za-z]+(?:['-][A-Za-z]+)*)*$/.test(normalizeEngName(val));
	}

	function isValidEmail(val) {
		return /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/.test(val);
	}

	function allowKorKey(e) {
		let key = e.which || e.keyCode;
		if (e.ctrlKey || e.metaKey || key == 8 || key == 9 || key == 13) {
			return true;
		}
		// space / digits blocked (Latin keys allowed for Hangul IME)
		if (key == 32 || (key >= 48 && key <= 57)) {
			e.preventDefault();
			return false;
		}
		return true;
	}

	function insertFiltered(el, filtered) {
		let start = el.selectionStart;
		let end = el.selectionEnd;
		let next = el.value.substring(0, start) + filtered + el.value.substring(end);
		el.value = next;
		if (typeof el.setSelectionRange == 'function') {
			let pos = start + filtered.length;
			el.setSelectionRange(pos, pos);
		}
	}

	function keepValidValue(el, pattern) {
		if (pattern.test(el.value)) {
			$(el).data('valid-val', el.value);
		} else {
			el.value = $(el).data('valid-val') || '';
		}
	}

	function toggleEtc($radios, etcId) {
		let val = $radios.filter(':checked').val();
		let $etc = $(etcId);
		if (val == '99') {
			$etc.prop('disabled', false).show();
		} else {
			$etc.prop('disabled', true).hide().val('');
		}
	}

	function checkEmailDuplicate(lang) {
		let email = $.trim($('#email').val()).replace(/\s+/g, '');
		$('#email').val(email);
		if (!email) {
			alert(lang == 'eng' ? 'Please enter your E-mail.' : 'E-mail을 입력해 주세요.');
			$('#email').focus();
			return;
		}
		if (!isValidEmail(email)) {
			alert(lang == 'eng' ? 'Please enter a valid E-mail address.' : '올바른 E-mail 형식이 아닙니다.');
			$('#email').focus();
			return;
		}
		$.ajax({
			type: 'POST',
			url: '/onsite/ajax_email_check.php',
			data: { email: email },
			dataType: 'json',
			success: function (res) {
				if (res && res.msg == 'invalid') {
					$('#email').data('email-checked', '');
					alert(lang == 'eng' ? 'Please enter a valid E-mail address.' : '올바른 E-mail 형식이 아닙니다.');
					$('#email').focus();
					return;
				}
				if (!res || !res.ok) {
					$('#email').data('email-checked', '');
					alert(lang == 'eng' ? 'Unable to check E-mail. Please try again.' : 'E-mail 확인 중 오류가 발생했습니다.');
					return;
				}
				if (res.dup) {
					alert(lang == 'eng' ? 'This E-mail is already registered.' : '이미 등록된 E-mail입니다.');
					$('#email').data('email-checked', '');
					$('#email').focus();
					return;
				}
				alert(lang == 'eng' ? 'This E-mail is available.' : '사용 가능한 E-mail입니다.');
				$('#email').data('email-checked', email);
			},
			error: function () {
				$('#email').data('email-checked', '');
				alert(lang == 'eng' ? 'Unable to check E-mail. Please try again.' : 'E-mail 확인 중 오류가 발생했습니다.');
			}
		});
	}

	function isEmailChecked(email) {
		return ($('#email').data('email-checked') == email && email != '');
	}

	function bindLicenseNoneToggle() {
		$(document).on('change', '#license_none', function () {
			let $license = $('#license_number');
			if ($(this).is(':checked')) {
				$license.val('0000').prop('readonly', true);
				$license.data('valid-val', '0000');
			} else {
				$license.prop('readonly', false).val('');
				$license.data('valid-val', '');
			}
		});
	}

	function bindInputFilters() {
		$(document).on('keypress', '.js-no-space', function (e) {
			if ((e.which || e.keyCode) == 32) {
				e.preventDefault();
			}
		});
		$(document).on('paste', '.js-no-space', function (e) {
			let clipboard = (e.originalEvent || e).clipboardData;
			let text = clipboard ? clipboard.getData('text') : '';
			if (text) {
				e.preventDefault();
				insertFiltered(this, text.replace(/\s+/g, ''));
			}
		});

		$(document).on('keypress', '.js-eng-only', allowEngKey);
		$(document).on('compositionend input', '.js-eng-only', function (e) {
			if (e.type == 'input' && e.originalEvent && e.originalEvent.isComposing) {
				return;
			}
			keepValidValue(this, /^[A-Za-z' -]*$/);
		});
		$(document).on('paste', '.js-eng-only', function (e) {
			let clipboard = (e.originalEvent || e).clipboardData;
			let text = clipboard ? clipboard.getData('text') : '';
			if (text) {
				e.preventDefault();
				text = text.replace(/[\u2018\u2019\u02BC]/g, "'").replace(/[\u2013\u2014]/g, '-');
				insertFiltered(this, text.replace(/[^A-Za-z' -]/g, ''));
				$(this).data('valid-val', this.value);
			}
		});

		$(document).on('keypress', '.js-kor-only', allowKorKey);
		$(document).on('compositionend input', '.js-kor-only', function (e) {
			if (e.type == 'input' && e.originalEvent && e.originalEvent.isComposing) {
				return;
			}
			keepValidValue(this, /^[가-힣ㄱ-ㅎㅏ-ㅣ]*$/);
		});
		$(document).on('paste', '.js-kor-only', function (e) {
			let clipboard = (e.originalEvent || e).clipboardData;
			let text = clipboard ? clipboard.getData('text') : '';
			if (text) {
				e.preventDefault();
				insertFiltered(this, text.replace(/[^가-힣ㄱ-ㅎㅏ-ㅣ]/g, ''));
				$(this).data('valid-val', this.value);
			}
		});

		$(document).on('keypress', '.js-digit-only', allowDigitKey);
		$(document).on('input', '.js-digit-only', function () {
			if ($(this).prop('readonly')) {
				return;
			}
			keepValidValue(this, /^[0-9]*$/);
		});
		$(document).on('paste', '.js-digit-only', function (e) {
			if ($(this).prop('readonly')) {
				e.preventDefault();
				return;
			}
			let clipboard = (e.originalEvent || e).clipboardData;
			let text = clipboard ? clipboard.getData('text') : '';
			if (text) {
				e.preventDefault();
				insertFiltered(this, text.replace(/[^0-9]/g, ''));
				$(this).data('valid-val', this.value);
			}
		});
	}

	$(function () {
		bindInputFilters();
		bindLicenseNoneToggle();
	});

	window.OnsiteForm = {
		formatWon: formatWon,
		formatUsd: formatUsd,
		allowDigitKey: allowDigitKey,
		allowEngKey: allowEngKey,
		normalizeEngName: normalizeEngName,
		isValidEngName: isValidEngName,
		isValidEmail: isValidEmail,
		allowKorKey: allowKorKey,
		insertFiltered: insertFiltered,
		keepValidValue: keepValidValue,
		toggleEtc: toggleEtc,
		checkEmailDuplicate: checkEmailDuplicate,
		isEmailChecked: isEmailChecked,
		bindInputFilters: bindInputFilters
	};
})(window, jQuery);
