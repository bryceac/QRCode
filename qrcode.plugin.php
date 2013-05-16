<?php
/*

Copyright (c) 2013 Bryce Campbell

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

*/

// the QRCode class makes it easy to place a QRCode in posts
class QRCode extends Plugin
{
	public function filter_post_content_out($content, $post)
	{
		$content = $content . $this->create_code($post);
		return $content;
	}
	
	// function to display QR code
	public function show_qr_code($theme, $post)
	{
		return $this->create_code($post);
	}
	
	// function used to add things to header
	public function theme_header()
	{
		Stack::add('template_stylesheet', $this->get_url() . '/style.css');
	}
	
	// function used to add the necessary Javascript to footer
	public function theme_footer()
	{
		Stack::add('template_footer_javascript', Site::get_url('scripts') . '/jquery.js', 'jquery');
		Stack::add('template_footer_javascript', $this->get_url() . '/jquery-qrcode/jquery.qrcode.min.js', 'jquery-qrcode');
	}
	
	// function to hold QR Javascript
	private function qrscript($post)
	{
		$script = 'jQuery(\'#qrcode\').qrcode({ width: 150, height: 150, text: "' . $post->permalink . '"});';
		return $script;
	}
	
	// the following creates a div container that holds the code to display a QR Code
	private function create_code($post)
	{
		$code = '<div class="QR">';
		$code .= '<div id="qrcode"></div>';
		$code .= '<p>Use an app on your on phone (e.g. <a href="https://play.google.com/store/apps/details?id=me.scan.android.client&hl=en">Scan</a> for Android) to capture the image above. If successful, you should be taken the web version of this article.</p></div>';
		Stack::add('template_footer_javascript', array($this->qrscript($post), 'type="text/javascript"'), 'qcode', array('jquery', 'jquery-qrcode')); /* this code is in the function because footer function will not recognize post variable, no matter how I went about it */
		return $code;
	}
}
?>