<?php 
echo $header;
if($loginpage == false){
	echo $banner;
	echo $main_navigation;
}
echo $content;
if($loginpage == false){
	echo $footer;
}
