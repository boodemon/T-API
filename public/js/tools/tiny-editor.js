var tiny = {
	section  	: 'textarea',
	theme 	 	: 'modern',
	height 	 	: '300',
	width	 	: '100',
	base_url 	: _base,
	content_css : '',
	inline		: false,
	base_path 	:  function(){
		if(this.base_url == ''){
			var path = $(location).attr('pathname');
			path.indexOf(1);
			path.toLowerCase();
			var len =  path.split("/").length;
			console.log('Count : ' + path.split("/").length);
			if(len >= 7){
				return '/' + path.split("/")[1]+'/'+path.split("/")[2];
			}else if(len >= 5){
				return '/' + path.split("/")[1];
			}else{
				return '/';
			}
		}else{
			return this.base_url;
		}
	},

	full : function(){
		var _this = this;
		tinymce.init({
			selector: _this.section,
			theme	: _this.theme,
			width 	: _this.width,
			height	: _this.height,
			inline 	: _this.inline,
			relative_urls: false,
			remove_script_host: false,
			plugins: [
				"advlist autolink lists link image charmap print preview hr anchor pagebreak",
				"searchreplace wordcount visualblocks visualchars code fullscreen",
				"insertdatetime media nonbreaking save table contextmenu directionality",
				"emoticons template paste textcolor colorpicker textpattern responsivefilemanager imagetools"
			],
			content_css : _this.content_css,
			menubar:true,
			toolbar1: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media responsivefilemanager emoticons forecolor backcolor | preview code fullscreen",
			image_advtab: true,
			templates: [
				{title: 'Test template 1', content: 'Test 1'},
				{title: 'Test template 2', content: 'Test 2'}
			],
			external_filemanager_path: this.base_path() + "/public/admin/lib/filemanager/",
			filemanager_title:"File Explorer" ,
			external_plugins: { "filemanager" : this.base_path() + "/public/admin/lib/filemanager/plugin.min.js"}
		});

	},

	medium : function(){
		var _this = this;
		tinymce.init({
			selector: _this.section,
			theme	: _this.theme,
			width 	: _this.width,
			height	: _this.height,
			inline 	: _this.inline,
			relative_urls: false,
			remove_script_host: false,
			font_formats : 'Arial=arial',
			fontsize_formats: "8pt 10pt 12pt 14pt 16px 18pt 20px 22px 24pt 32px 36pt 42px",
			plugins: [
				"advlist autolink lists link image charmap print preview hr anchor pagebreak",
				"searchreplace wordcount visualblocks visualchars code fullscreen",
				"insertdatetime media nonbreaking save table contextmenu directionality",
				"emoticons template paste textcolor colorpicker textpattern responsivefilemanager imagetools"
			],
			content_css : _this.content_css,
			menubar:false,
			toolbar1: "undo redo | styleselect | font fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media responsivefilemanager | emoticons forecolor backcolor | preview code fullscreen",
			image_advtab: true,
			templates: [
				{title: 'Test template 1', content: 'Test 1'},
				{title: 'Test template 2', content: 'Test 2'}
			],
			external_filemanager_path: this.base_path() + "/public/admin/lib/filemanager/",
			filemanager_title:"File Explorer" ,
			external_plugins: { "filemanager" : this.base_path() + "/public/admin/lib/filemanager/plugin.min.js"}
		});

	},

	mini : function(){
		var _this = this;
		tinymce.init({
			selector: _this.section,
			theme	: _this.theme,
			width 	: _this.width,
			height	: _this.height,
			inline 	: _this.inline,
			relative_urls: false,
			remove_script_host: false,
			fontsize_formats: "8pt 10pt 12pt 14pt 16px 18pt 20px 22px 24pt 32px 36pt 42px",
			plugins: [
				"advlist autolink lists link image charmap print preview hr anchor pagebreak",
				"searchreplace wordcount visualblocks visualchars  ",
				"insertdatetime media nonbreaking save table contextmenu directionality",
				"emoticons template paste textcolor colorpicker textpattern "
			],
			default_link_target: "_blank",
			content_css : _this.content_css,
			menubar:false,
			toolbar1: " bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | forecolor backcolor",
			image_advtab: true,
			templates: [
				{title: 'Test template 1', content: 'Test 1'},
				{title: 'Test template 2', content: 'Test 2'}
			],
		});

	},

}
