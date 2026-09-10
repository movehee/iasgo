var specialChars = [
  { text: 'exclamation mark', value: '!' },
  { text: 'at', value: '@' },
  { text: 'hash', value: '#' },
  { text: 'dollars', value: '$' },
  { text: 'percent sign', value: '%' },
  { text: 'caret', value: '^' },
  { text: 'ampersand', value: '&' },
  { text: 'asterisk', value: '*' }
];

tinymce.init({
	selector: '#content',
	theme: "silver", //테마종류 modern / mobile
	mobile: { theme: 'mobile' },
	language : 'ko_KR',
	menubar:false,
	quickbars_selection_toolbar: 'removeformat | bold underline italic | superscript subscript', //입력글에 영역 잡았을때 퀵메뉴 정의
	quickbars_insert_toolbar : 'template  quicktable quickimage ',
	plugins: 'print preview fullpage importcss  searchreplace autolink autosave save directionality  visualblocks visualchars fullscreen image link media   codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists  wordcount   imagetools textpattern noneditable help    charmap  quickbars  emoticons code template spellchecker paste',
	
	toolbar : 'removeformat| bold italic underline | table code superscript subscript | insertfile Lab | image | template | charmap | alignleft aligncenter alignright | showcomments addcomment  |  fontsizeselect   ',
	// | outdent indent | pagebreak emoticons | fullscreen  preview print  | a11ycheck ltr rtl | link anchor codesample strikethrough template spellchecker alignjustify  |  numlist bullist |  fontselect formatselect     | forecolor backcolor
   
	templates: [
	{title: 'CBC 순서', description: 'CBC 순서', url: '/lab/1/box1.php'}
	],
	//undo redo | 
	image_title: true,
	fontsize_formats: '11px 12px 13px 14px 16px 18px 24px 36px 48px',
	setup: function (editor) {
		editor.ui.registry.addMenuButton('Lab', {
		  text: '단위',
		  fetch: function (callback) {
			var items = [
				{type: 'menuitem',text: 'µ',onAction: function () {editor.insertContent('µ');}},
				{type: 'menuitem',text: 'µL',onAction: function () {editor.insertContent('µL');}},
				{type: 'menuitem',text: 'mL',onAction: function () {editor.insertContent('mL');}},
				{type: 'menuitem',text: 'dL',onAction: function () {editor.insertContent('dL');}},
				{type: 'menuitem',text: 'L',onAction: function () {editor.insertContent('L');}},
				{type: 'menuitem',text: 'fL',onAction: function () {editor.insertContent('fL');}},
				{type: 'menuitem',text: 'µg/L',onAction: function () {editor.insertContent('µg/L');}},
				{type: 'menuitem',text: 'U/L',onAction: function () {editor.insertContent('U/L');}},
				{type: 'menuitem',text: 'IU/L',onAction: function () {editor.insertContent('IU/L');}},
				{type: 'menuitem',text: 'mEq/L',onAction: function () {editor.insertContent('mEq/L');}},
				{type: 'menuitem',text: 'mmol/L',onAction: function () {editor.insertContent('mmol/L');}},
				{type: 'menuitem',text: 'g/dL',onAction: function () {editor.insertContent('g/dL');}},
				{type: 'menuitem',text: 'ng/dL',onAction: function () {editor.insertContent('ng/dL');}},
				{type: 'menuitem',text: 'µg/dL',onAction: function () {editor.insertContent('µg/dL');}},
				{type: 'menuitem',text: 'mg/dL',onAction: function () {editor.insertContent('mg/dL');}},
				{type: 'menuitem',text: 'uIU/mL',onAction: function () {editor.insertContent('uIU/mL');}},
				{type: 'menuitem',text: 'U/mL',onAction: function () {editor.insertContent('U/mL');}},
				{type: 'menuitem',text: 'IU/mL',onAction: function () {editor.insertContent('IU/mL');}},
				{type: 'menuitem',text: 'pg/mL',onAction: function () {editor.insertContent('pg/mL');}},
				{type: 'menuitem',text: 'µm',onAction: function () {editor.insertContent('µm');}},
				{type: 'menuitem',text: 'mm',onAction: function () {editor.insertContent('mm');}},
				{type: 'menuitem',text: 'cm',onAction: function () {editor.insertContent('cm');}},
				{type: 'menuitem',text: 'cm²',onAction: function () {editor.insertContent('cm<sup>2</sup>');}},
				{type: 'menuitem',text: 'mm³',onAction: function () {editor.insertContent('mm<sup>3</sup>');}},
				{type: 'menuitem',text: 'mm/hr',onAction: function () {editor.insertContent('mm/hr');}},
				{type: 'menuitem',text: 'ng/mL/hr',onAction: function () {editor.insertContent('ng/mL/hr');}},
				{type: 'menuitem',text: 'µg/day',onAction: function () {editor.insertContent('µg/day');}},
				{type: 'menuitem',text: 'mg/day',onAction: function () {editor.insertContent('mg/day');}},
				{type: 'menuitem',text: 'mL/min/1.73 m²',onAction: function () {editor.insertContent('mL/min/1.73 m<sup>2</sup>');}},
				{type: 'menuitem',text: 'mmHg',onAction: function () {editor.insertContent('mmHg');}},
				{type: 'menuitem',text: 'g',onAction: function () {editor.insertContent('g');}},
				{type: 'menuitem',text: 'kg',onAction: function () {editor.insertContent('kg');}},
				{type: 'menuitem',text: 'kg/m²',onAction: function () {editor.insertContent('kg/m<sup>2</sup>');}},
				{type: 'menuitem',text: 'g/g',onAction: function () {editor.insertContent('g/g');}},
				{type: 'menuitem',text: 'mOsm/kg',onAction: function () {editor.insertContent('mOsm/kg');}},
				{type: 'menuitem',text: 'HPF',onAction: function () {editor.insertContent('HPF');}},
				{type: 'menuitem',text: '%',onAction: function () {editor.insertContent('%');}},
				{type: 'menuitem',text: '℃',onAction: function () {editor.insertContent('℃');}},
				{type: 'menuitem',text: 'β',onAction: function () {editor.insertContent('β');}}
			];
			callback(items);
		  }
		});
	},
	automatic_uploads: true,
	images_upload_url: '/func/tinymce/postAcceptor.php', //이미지 업로드하면 저장하는 페이지
	file_picker_types: 'image',
	file_picker_callback: function (cb, value, meta) {
	var input = document.createElement('input');
	input.setAttribute('type', 'file');
	input.setAttribute('accept', 'upload/tinymce/*');
	
	
	input.onchange = function () {
		var file = this.files[0];
		var reader = new FileReader();
		reader.onload = function () {
			var id = 'blobid' + (new Date()).getTime();
			var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
			var base64 = reader.result.split(',')[1];
			var blobInfo = blobCache.create(id, file, base64);
			blobCache.add(blobInfo);
			cb(blobInfo.blobUri(), { title: file.name });
		};
		reader.readAsDataURL(file);
	};
    input.click();
  }
});



var dfreeBodyConfig = {
  selector: '.dfree-body',
  menubar: false,
  inline: true,
  language : 'ko_KR',
  /*plugins: [
	'codesample','code'
  ],*/
  plugins: 'codesample code  importcss   paste',
toolbar : ' bold italic underline  |  superscript subscript | removeformat | code | alignleft aligncenter alignright | forecolor backcolor | fontselect fontsizeselect',
setup: function (editor) {
	editor.ui.registry.addMenuButton('Lab', {
	  text: '단위',
	  fetch: function (callback) {
		var items = [
			{type: 'menuitem',text: 'µ',onAction: function () {editor.insertContent('µ');}},
			{type: 'menuitem',text: 'µL',onAction: function () {editor.insertContent('µL');}},
			{type: 'menuitem',text: 'mL',onAction: function () {editor.insertContent('mL');}},
			{type: 'menuitem',text: 'dL',onAction: function () {editor.insertContent('dL');}},
			{type: 'menuitem',text: 'L',onAction: function () {editor.insertContent('L');}},
			{type: 'menuitem',text: 'fL',onAction: function () {editor.insertContent('fL');}},
			{type: 'menuitem',text: 'µg/L',onAction: function () {editor.insertContent('µg/L');}},
			{type: 'menuitem',text: 'U/L',onAction: function () {editor.insertContent('U/L');}},
			{type: 'menuitem',text: 'IU/L',onAction: function () {editor.insertContent('IU/L');}},
			{type: 'menuitem',text: 'mEq/L',onAction: function () {editor.insertContent('mEq/L');}},
			{type: 'menuitem',text: 'mmol/L',onAction: function () {editor.insertContent('mmol/L');}},
			{type: 'menuitem',text: 'g/dL',onAction: function () {editor.insertContent('g/dL');}},
			{type: 'menuitem',text: 'ng/dL',onAction: function () {editor.insertContent('ng/dL');}},
			{type: 'menuitem',text: 'µg/dL',onAction: function () {editor.insertContent('µg/dL');}},
			{type: 'menuitem',text: 'mg/dL',onAction: function () {editor.insertContent('mg/dL');}},
			{type: 'menuitem',text: 'uIU/mL',onAction: function () {editor.insertContent('uIU/mL');}},
			{type: 'menuitem',text: 'U/mL',onAction: function () {editor.insertContent('U/mL');}},
			{type: 'menuitem',text: 'IU/mL',onAction: function () {editor.insertContent('IU/mL');}},
			{type: 'menuitem',text: 'pg/mL',onAction: function () {editor.insertContent('pg/mL');}},
			{type: 'menuitem',text: 'µm',onAction: function () {editor.insertContent('µm');}},
			{type: 'menuitem',text: 'mm',onAction: function () {editor.insertContent('mm');}},
			{type: 'menuitem',text: 'cm',onAction: function () {editor.insertContent('cm');}},
			{type: 'menuitem',text: 'cm²',onAction: function () {editor.insertContent('cm<sup>2</sup>');}},
			{type: 'menuitem',text: 'mm³',onAction: function () {editor.insertContent('mm<sup>3</sup>');}},
			{type: 'menuitem',text: 'mm/hr',onAction: function () {editor.insertContent('mm/hr');}},
			{type: 'menuitem',text: 'ng/mL/hr',onAction: function () {editor.insertContent('ng/mL/hr');}},
			{type: 'menuitem',text: 'µg/day',onAction: function () {editor.insertContent('µg/day');}},
			{type: 'menuitem',text: 'mg/day',onAction: function () {editor.insertContent('mg/day');}},
			{type: 'menuitem',text: 'mL/min/1.73 m²',onAction: function () {editor.insertContent('mL/min/1.73 m<sup>2</sup>');}},
			{type: 'menuitem',text: 'mmHg',onAction: function () {editor.insertContent('mmHg');}},
			{type: 'menuitem',text: 'g',onAction: function () {editor.insertContent('g');}},
			{type: 'menuitem',text: 'kg',onAction: function () {editor.insertContent('kg');}},
			{type: 'menuitem',text: 'kg/m²',onAction: function () {editor.insertContent('kg/m<sup>2</sup>');}},
			{type: 'menuitem',text: 'g/g',onAction: function () {editor.insertContent('g/g');}},
			{type: 'menuitem',text: 'mOsm/kg',onAction: function () {editor.insertContent('mOsm/kg');}},
			{type: 'menuitem',text: 'HPF',onAction: function () {editor.insertContent('HPF');}},
			{type: 'menuitem',text: '%',onAction: function () {editor.insertContent('%');}},
			{type: 'menuitem',text: '℃',onAction: function () {editor.insertContent('℃');}},
			{type: 'menuitem',text: 'β',onAction: function () {editor.insertContent('β');}}
		];
		callback(items);
	  }
	});
},
  quickbars_selection_toolbar: 'bold italic |Lab| superscript subscript | removeformat | code ',
  powerpaste_word_import: 'clean',
  powerpaste_html_import: 'clean',
  content_css: '/func/tinymce_ver5/codepen.min.css'
};

tinymce.init(dfreeBodyConfig);

