$(document).ready(function () {$("#submit-2046921012").bind("click", function (event) {$.ajax({data:$("#submit-2046921012").closest("form").serialize(), dataType:"html", success:function (data, textStatus) {$("#timeline").html(data);}, type:"post", url:"\/Twitter-aug-6\/Twitter\/tweets"});
return false;});});