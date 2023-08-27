<?php

function fileExtension($file){
	if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){
		return '<img src="'.asset('assets').'/images/pdf.jpg">';
	}elseif(pathinfo($file,PATHINFO_EXTENSION) == 'ppt'){
		return '<img src="'.asset('assets') .'/images/ppt.jpg">';
	}elseif(pathinfo($file,PATHINFO_EXTENSION) == 'png'){
		return '<img src="'.asset('assets').'/images/png.png">';
	}elseif(pathinfo($file,PATHINFO_EXTENSION) == 'jpg'){
		return '<img src="'.asset('assets').'/images/jpg.jpg">';
	}elseif(pathinfo($file,PATHINFO_EXTENSION) == 'pptx'){
		return '<img src="'.asset('assets').'/images/pptx.jpg">';
	}else{
		return '<img src="'.asset('assets').'/images/pdf-1.jpg">';
	}
		
}

?>