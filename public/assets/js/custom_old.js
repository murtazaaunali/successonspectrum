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
})

$(document).ready(function(e) {
    $(".trigger-1").click(function(e) {
        $(".dis-none-3").show();
        $(".dis-none-5").hide();
    });
    $(".trigger").click(function(e) {
        $(".dis-none-3").hide();
        $(".dis-none-5").hide();
    });
    $(".trigger-5").click(function(e) {
        $(".dis-none-3").hide();
        $(".dis-none-5").show();
    });

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


window.onload = function () {

//Better to construct options first and then pass it as a parameter
    var options = {
        animationEnabled: true,
        title:{
            text: "Sales of ACME based on Sales-Channels"
        },
        axisY: {
            suffix: "%"
        },
        toolTip: {
            shared: true,
            reversed: true
        },
        legend: {
            reversed: true,
            verticalAlign: "center",
            horizontalAlign: "right"
        },
        data: [
            {
                type: "stackedColumn100",
                name: "WholeSale",
                showInLegend: true,
                yValueFormatString: "#,##0\"%\"",
                dataPoints: [
                    { label: "Q1", y: 44 },
                    { label: "Q2", y: 88 },
                    { label: "Q3", y: 65 },
                    { label: "Q4", y: 69 }
                ]
            },
            {
                type: "stackedColumn100",
                name: "Retail",
                showInLegend: true,
                yValueFormatString: "#,##0\"%\"",
                dataPoints: [
                    { label: "Q1", y: 48 },
                    { label: "Q2", y: 29 },
                    { label: "Q3", y: 73 },
                    { label: "Q4", y: 99 }
                ]
            },
            {
                type: "stackedColumn100",
                name: "Inside Sales",
                showInLegend: true,
                yValueFormatString: "#,##0\"%\"",
                dataPoints: [
                    { label: "Q1", y: 19 },
                    { label: "Q2", y: 41 },
                    { label: "Q3", y: 5 },
                    { label: "Q4", y: 39 }
                ]
            },
            {
                type: "stackedColumn100",
                name: "Mail Order",
                showInLegend: true,
                yValueFormatString: "#,##0\"%\"",
                dataPoints: [
                    { label: "Q1", y: 20 },
                    { label: "Q2", y: 100 },
                    { label: "Q3", y: 7 },
                    { label: "Q4", y: 43 }
                ]
            }
        ]
    };

}

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

$("#trip_itinerary_search").on("submit",function(e){
    e.preventDefault();
    var url = $(this).attr("action");

    var filter_franchise    = $('select[name=\'franchise\']').val();
    var filter_state        = $('select[name=\'state\']').val();

    if(filter_franchise == "" && filter_state == "")
    {
        alert("Please Select Filter Options");
    }
    else
    {
        url += '?';
    }

    if(filter_state != "")
    {
        url += 'state=' + encodeURIComponent(filter_state);
    }

    if(filter_franchise != "")
    {
        if(filter_state != "")
            url += '&';
        url += 'franchise=' + encodeURIComponent(filter_franchise);
    }

    window.location = url;
})