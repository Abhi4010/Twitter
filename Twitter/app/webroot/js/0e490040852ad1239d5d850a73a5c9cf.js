$(document).ready(function () {$("#submit-1407730527").bind("click", function (event) {$.ajax({data:$("#submit-1407730527").closest("form").serialize(), dataType:"html", success:function (data, textStatus) {$("#timeline").html(data);}, type:"post", url:"\/Twitter-aug-6\/Twitter\/tweets"});
return false;});});