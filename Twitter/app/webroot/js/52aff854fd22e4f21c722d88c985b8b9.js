$(document).ready(function () {$("#submit-1778145150").bind("click", function (event) {$.ajax({data:$("#submit-1778145150").closest("form").serialize(), dataType:"html", success:function (data, textStatus) {$("#timeline").html(data);}, type:"post", url:"\/Twitter-aug-6\/Twitter\/tweets\/index\/413"});
return false;});});