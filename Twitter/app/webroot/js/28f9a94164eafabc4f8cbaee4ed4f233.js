$(document).ready(function () {$("#submit-174507454").bind("click", function (event) {$.ajax({beforeSend:function (XMLHttpRequest) {$("#sending")}, data:$("#submit-174507454").closest("form").serialize(), dataType:"html", success:function (data, textStatus) {$("#sending").fadeOut();$("#success").html(data);}, type:"post", url:"\/Twitter\/users\/register"});
return false;});});