$(document).ready(function () {$("#submit-35138248").bind("click", function (event) {$.ajax({data:$("#submit-35138248").closest("form").serialize(), dataType:"html", success:function (data, textStatus) {$("#timeline").html(data);}, type:"post", url:"\/Twitter-aug-6\/Twitter\/tweets\/index\/431"});
return false;});});