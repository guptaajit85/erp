<footer class="main-footer">
<strong>Copyright &copy; <?php echo date('Y');?> <a href="javascript:void(0);"></a>.</strong> All rights reserved.
</footer>

<script> 
 

function addDaysToDate(dateString, daysToAdd) 
{ 
  var dateParts = dateString.split('-');
  var day = parseInt(dateParts[0]);
  var month = parseInt(dateParts[1]) - 1;  
  var year = parseInt(dateParts[2]);
  var date = new Date(year, month, day); 
  date.setDate(date.getDate() + daysToAdd); 
  var resultYear = date.getFullYear();
  var resultMonth = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are one-based (1-12)
  var resultDay = date.getDate().toString().padStart(2, '0');

  // return resultYear + '-' + resultMonth + '-' + resultDay;
  return resultDay + '-' + resultMonth + '-' + resultYear;
} 
</script>