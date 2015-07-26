$(document).ready(function() {
	$('#Class').change(function() {
		try{
		gotClass=$(this).children('option:selected').val();
		htmlobj=$.ajax({url:"./ajax/getClass.php?class="+gotClass,async:false});
  		response=htmlobj.responseText.split("|");
  		$('#Charapter').empty();
  		for(x in response){
  			$('#Charapter').append('<option value='+response[x]+'>'+response[x]+'</option>');
  		}
  		htmlobj=$.ajax({url:"./ajax/getClass.php?getteacher="+gotClass,async:false});
  		response=htmlobj.responseText.split("|");
  		$('#Experiment').empty();
  		for(x in response){
  			$('#Experiment').append('<option value='+response[x]+'>'+response[x]+'</option>');
  		}
  	}catch(e){
  		alert(e);
  	}
	});
})