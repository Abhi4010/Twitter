$(document).ready(function () {$("#submit-1391796175").bind("click", function (event) {$.ajax({data:$("#submit-1391796175").closest("form").serialize(), dataType:"html", success:function (data, textStatus) {$("#timeline").html(data);}, type:"post", url:"\/Twitter-aug-6\/Twitter\/tweets"});
return false;});});