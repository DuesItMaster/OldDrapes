function openTab(evt, tab_num) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById("tab_"+tab_num).style.display = "block";
    evt.currentTarget.className += " active";
}
function seleccionarNumero(num) {
  $(".btn_cantidad").removeClass("active");
  $("#btn_cantidad_"+num).addClass("active");
  if(num<5){
    $(".cantidades #cantidad").css("display", "none");
    $(".cantidades #cantidad").val(num);
  }
  else{
    $(".cantidades #cantidad").css("display", "inline-block");
    $(".cantidades #cantidad").val("");
  }
  CargarValor();
}