
// Get the modal
var modal = document.getElementById("myModal");

$(document).ready(function(){

  $(".btnsubmit").click(function(){
  	var fired_button = $(this).val();
  	var id_name = "#myModal" + fired_button;
  	//alert(id_name);
    $(id_name).fadeIn(700);
  });

  $(".close").click(function(){
    $(".modal").fadeOut(700);
  });
});