$(document).ready(function () {$("#submit-900121209").bind("click", function (event) {$.ajax({data:$("#submit-900121209").closest("form").serialize(), dataType:"html", success:function (data, textStatus) {$("#timeline").html(data);}, type:"post", url:"\/Twitter-aug-6\/Twitter\/tweets"});
return false;});});