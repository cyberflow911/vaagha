
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="../admin/bower_components/jquery/dist/jquery.min.js"></script>
<script src="../admin/dist/js/jquery.form.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../admin/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../admin/dist/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="../admin/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../admin/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="../admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll -->
<script src="../admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
 <!-- multiselect --> 

<!--CKEditor-->
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>

<script src="../js/jquery.min.js"></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<!--plugins-->
	<script src="../admin/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="../admin/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="../admin/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<!-- App JS -->
	<script src="../js/app.js"></script>

  <script src="../admin/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
	<script src="../admin/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script src="../admin/plugins/vectormap/jquery-jvectormap-in-mill.js"></script>
	<script src="../admin/plugins/vectormap/jquery-jvectormap-us-aea-en.js"></script>
	<script src="../admin/plugins/vectormap/jquery-jvectormap-uk-mill-en.js"></script>
	<script src="../admin/plugins/vectormap/jquery-jvectormap-au-mill.js"></script>
	<script src="../admin/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
	<script src="../js/index.js"></script>
	<!-- App JS -->
	<!-- <script>
		new PerfectScrollbar('.dashboard-social-list');
		new PerfectScrollbar('.dashboard-top-countries');
	</script> -->
 
<script>
  $(function () {
           if(window.location.href.substring(window.location.href.lastIndexOf('/') + 1).includes('?'))
      {
          
 
          $("a[href$='"+window.location.href.substring(window.location.href.lastIndexOf('/') + 1)+"']").parent().parent().parent().addClass("active");
 
      }else
      {
           $("a[href$='"+window.location.href.substring(window.location.href.lastIndexOf('/') + 1)+"']").parent().addClass("active");

      }
           
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    })
  })
</script>

<script>
  $("input:checkbox").on("change", function () {
     
    var val = $(this).is(':checked') ? 1 : 0;
    $.ajax({type: "POST",
        url: "indexAjax.php",
        data: {val: val}
    });
});
</script>

<script>

    //file type validation
   
$(document).on('change', '#image_upload_file', function () {
var progressBar = $('.progressBar'), bar = $('.progressBar .bar'), percent = $('.progressBar .percent');

$('#image_upload_form').ajaxForm({
    beforeSend: function() {
		progressBar.fadeIn();
        var percentVal = '0%';
        bar.width(percentVal)
        percent.html(percentVal);
    },
    uploadProgress: function(event, position, total, percentComplete) {
        var percentVal = percentComplete + '%';
        bar.width(percentVal)
        percent.html(percentVal);
    },
    success: function(html, statusText, xhr, $form) {		
		obj = $.parseJSON(html);	
		if(obj.status){		
			var percentVal = '100%';
			bar.width(percentVal)
			percent.html(percentVal);
			$("#imgArea>img").prop('src',obj.image_medium);			
		}else{
			alert(obj.error);
		}
    },
	complete: function(xhr) {
		progressBar.fadeOut();			
	}	
}).submit();		

});

    
</script>
</body>
</html>