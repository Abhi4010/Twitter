$(document).ready(function () {$("#submit-820569407").bind("click", function (event) {$.ajax({data:$("#submit-820569407").closest("form").serialize(), dataType:"html", success:function (data, textStatus) {$("#timeline").html(data);}, type:"post", url:"\/Twitter-aug-6\/Twitter\/tweets\/index\/443"});
return false;});});