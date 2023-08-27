
/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

$('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
});

	//Custom js
	$(document).ready(function(e) {

	    $(".tar_set").click(function(e) {
	        e.preventDefault();
	        $(this).toggleClass('activetoogle').siblings('.dropdown-menu-1').slideToggle();
	        $(this).parent().siblings().find('.tar_set').removeClass('activetoogle').siblings('.dropdown-menu-1').slideUp();
	    });
	    
		$winheight = $(window).height() - 108;
	    $('.side-bar-main').css("min-height", $winheight);

	    $(".res-bar-icon").click(function(){
	        $(".side-bar-main").slideToggle();
	    });

	    if($(window).width() <= "991"){
	        $("table").addClass("table");
	    }

	    $(".draggable").draggable({
	        connectToSortable: '.sortableList',
	        cursor: 'pointer',
	        helper: 'clone',
	        revert: 'invalid'
	    });
	    $(".alert-success").fadeOut(3000);
	});		


$('.noitfication-drop-down-4').click(function() {
    if($(this).next(".logout-box-main-cargo").hasClass('notnone-6')){
        $(this).next(".logout-box-main-cargo").removeClass('notnone-6');
    }else{
        $(this).next(".logout-box-main-cargo").addClass('notnone-6');
    }
});

$('.upload_profile').click(function(){
    $('.upload_picture').click();
});

var before_img_upload = "";
var hasborder = 0;
$('.upload_picture').change(function(){

    if(before_img_upload == "") before_img_upload = $('.upload-display-icon-main').html();

    if($('.upload-display-icon-main').hasClass('no-border') && hasborder == 0) hasborder = 1;
    else if(hasborder != 1) hasborder = 2;

    console.log(hasborder);

    if(this.files[0])
    {
        var reader = new FileReader();
        reader.onload = function (e) {
            if(hasborder == 2) $('.upload-display-icon-main').addClass('no-border');

            $('.upload-display-icon-main').html('<img src="'+e.target.result+'" class="img-responsive img-circle" />');
        }
        reader.readAsDataURL(this.files[0]);
    }
    else
    {
        if(hasborder == 2) $('.upload-display-icon-main').removeClass('no-border');

        $('.upload-display-icon-main').html(before_img_upload);
    }
});





