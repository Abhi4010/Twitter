$(document).ready(function () {$("#submit-1819177740").bind("click", function (event) {$.ajax({beforeSend:function (XMLHttpRequest) {$("#sending")}, data:$("#submit-1819177740").closest("form").serialize(), dataType:"html", success:function (data, textStatus) {$("#sending").fadeOut();$("#success").html(data);}, type:"post", url:"\/Twitter\/users\/register"});
return false;});});