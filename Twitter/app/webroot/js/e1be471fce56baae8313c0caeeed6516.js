$(document).ready(function () {$("#submit-1783415567").bind("click", function (event) {$.ajax({data:$("#submit-1783415567").closest("form").serialize(), dataType:"html", success:function (data, textStatus) {$("#timeline").html(data);}, type:"post", url:"\/Twitter-aug-6\/Twitter\/Tweets"});
return false;});});