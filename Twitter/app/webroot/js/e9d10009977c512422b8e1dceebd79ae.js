$(document).ready(function () {$("#submit-535921928").bind("click", function (event) {$.ajax({data:$("#submit-535921928").closest("form").serialize(), dataType:"html", success:function (data, textStatus) {$("#timeline").html(data);}, type:"post", url:"\/Twitter-aug-6\/Twitter\/tweets\/index\/429"});
return false;});});