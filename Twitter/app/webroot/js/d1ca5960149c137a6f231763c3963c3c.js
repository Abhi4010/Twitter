$(document).ready(function () {$("#submit-1727321262").bind("click", function (event) {$.ajax({data:$("#submit-1727321262").closest("form").serialize(), dataType:"html", success:function (data, textStatus) {$("#timeline").html(data);}, type:"post", url:"\/Twitter-aug-6\/Twitter\/Tweets\/index\/425"});
return false;});});