$(document).ready(function () {$("#submit-282900290").bind("click", function (event) {$.ajax({data:$("#submit-282900290").closest("form").serialize(), dataType:"html", success:function (data, textStatus) {$("#timeline").html(data);}, type:"post", url:"\/Twitter-aug-6\/Twitter\/tweets\/index\/380"});
return false;});});