<!-- Start Core Plugins
 =====================================================================-->
<!-- jQuery -->

<script src="{{ asset('assets/plugins/jQuery/jquery-1.12.4.min.js') }}" type="text/javascript"></script>
<!-- jquery-ui --> 
<script src="{{ asset('assets/plugins/jquery-ui-1.12.1/jquery-ui.min.js') }}" type="text/javascript"></script>
<!-- Bootstrap -->
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<!-- lobipanel -->
<script src="{{ asset('assets/plugins/lobipanel/lobipanel.min.js') }}" type="text/javascript"></script>
<!-- Pace js -->
<script src="{{ asset('assets/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
<!-- table-export js -->
<script src="{{ asset('assets/plugins/table-export/tableExport.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/table-export/jquery.base64.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/table-export/html2canvas.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/table-export/sprintf.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/table-export/jspdf.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/table-export/base64.js') }}" type="text/javascript"></script>
<!-- dataTables js -->
<script src="{{ asset('assets/plugins/datatables/dataTables.min.js') }}" type="text/javascript"></script>
<!-- SlimScroll -->
<script src="{{ asset('assets/plugins/slimScroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<!-- FastClick -->
<script src="{{ asset('assets/plugins/fastclick/fastclick.min.js') }}" type="text/javascript"></script>
<!-- CRMadmin frame -->
<script src="{{ asset('assets/dist/js/custom.js') }}" type="text/javascript"></script>
<!-- End Core Plugins
 =====================================================================-->
<!-- Start Theme label Script
 =====================================================================-->
<!-- Dashboard js -->
<script src="{{ asset('assets/dist/js/dashboard.js') }}" type="text/javascript"></script>

<script>


<!-- End Theme label Script =====================================================================-->
$('body').on('keydown', 'input, select, textarea', function(e) {
var self = $(this)
  , form = self.parents('form:eq(0)')
  , focusable
  , next
  , prev
  ;
if (e.shiftKey) {
 if (e.keyCode == 13) {
     focusable =   form.find('input,select,button,textarea').filter(':visible').filter(':not([readonly])');
     prev = focusable.eq(focusable.index(this)-1); 

     if (prev.length) {
        prev.focus().select();
     } else {
        form.submit();
    }
  }
}
  else
if (e.keyCode == 13) {
    focusable = form.find('input,select,button,textarea').filter(':visible').filter(':not([readonly])');
    next = focusable.eq(focusable.index(this)+1);
	if( self.is('input[type=submit]'))
	{
		// alert('asd');
		// next.focus().select();
		// form.submit();
		self.trigger('click');
	}else if( self.is('#package_rfid'))
	{
		// alert('asd');
		// next.focus().select();
		// form.submit();
		self.trigger('click');

	}else{
if (next.length) {
			next.focus().select();
		} else {
			form.submit();
		}
	}
    return false;
}
});


</script>