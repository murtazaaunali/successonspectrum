	<footer>
		<div class="add-footer">
			<div class="container">
				<h4>Success On The Spectrum &copy; {{ date('Y') }} All Rights Reserved </h4>
				<h5><!--Designed and Developed by Accunity-->Agency Partner Interactive | <a href="https://www.agencypartner.com/" target="_blank">Web Design & Development Agency</a></h5>
				<div class="clearfix"></div>
			</div>
		</div>
	</footer>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker1, #datetimepicker2, #datetimepicker3, #startdate,#enddate, #datetimepicker4, #datetimepicker5, #datetimepicker6, #datetimepicker7, #datetimepicker8, #datetimepicker9, #datetimepicker10, #datetimepicker11, #datetimepicker12, #datetimepicker13, #datetimepicker14, #datetimepicker15, #datetimepicker16, #datetimepicker17, #datetimepicker18, #datetimepicker19').datetimepicker({
                pickerPosition: 'top-left',
                format: 'mm/dd/yyyy',
			    maxView: 4,
			    minView: 2,
			    autoclose: true,
        });
    });
    
	$(function(){
	  var checkboxs = $('.checkboxjq');
	  checkboxs.each(function(){
	    $(this).wrap('<div class="customCheckbox"></div>');
	    $(this).before('<span>&#10004;</span>');
	  });
	  checkboxs.change(function(){
	    if($(this).is(':checked')){
	     $(this).parent().addClass('customCheckboxChecked');
	    } else {
	     $(this).parent().removeClass('customCheckboxChecked');
	    }
	  });
	});

	$(document).ready(function(){
        $(".dash-bor").click(function(){
            $(this).parent('div').find(".clickme").click();
            $(this).parent('div').find('.clickme').bind('change', function () {
                var filename = $(this).val();
                if (/^\s*$/.test(filename)) {
                    $(".file-upload").removeClass('active');
                    $(this).parent('div').find(".noFile").text(""); 
                }else {
	                $(".file-upload").addClass('active');
	                $(this).parent('div').find(".noFile").text(filename.replace("C:\\fakepath\\", "")); 
              	}
            });
        });

        $(".dash-bor_multiple").click(function(){
            $(this).parent('div').find(".clickme").click();
            $(this).parent('div').find('.clickme').bind('change', function () {
                var filename = $(this).val();
                var files = $(this)[0].files;
                if (/^\s*$/.test(filename)) {
                    $(".file-upload").removeClass('active');
                    $(this).parent('div').find(".noFile").text(""); 
                }else {
	                $(".file-upload").addClass('active');
	                //$(this).parent('div').find(".noFile").text(filename.replace("C:\\fakepath\\", ""));

					var allfiles = "";
				    for (var i = 0; i < files.length; i++) {
				        console.log(files[i].name);
						allfiles += files[i].name.replace("C:\\fakepath\\", "")+'<br/>';
				    }

					$(this).parent('div').find(".noFile").html(allfiles);

              	}
            });
        });
    });    
    
   
</script>

</body>
</html>