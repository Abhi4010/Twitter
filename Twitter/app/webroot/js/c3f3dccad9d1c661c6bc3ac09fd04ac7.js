$(document).ready(function () {$("#submit-1308838579").bind("click", function (event) {$.ajax({data:$("#submit-1308838579").closest("form").serialize(), dataType:"html", success:function (data, textStatus) {$("#timeline").html(data);}, type:"post", url:"\/Twitter-aug-6\/Twitter\/tweets"});
return false;});});