/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	config.uiColor = '#AADC6E';

	// 定义图片上传时的url地址
	config.filebrowserUploadUrl = 'http://localhost/myblog/php/server.php?p=Back&c=Article&a=uploadImg';
	config.filebrowserImageUploadUrl = 'http://localhost/myblog/php/server.php?p=Back&c=Article&a=uploadImg';
};
