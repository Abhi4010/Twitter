$(document).ready(function () {$("#tweet_submit").bind("click", function (event) {$.ajax({data:$("#tweet_submit").closest("form").serialize(), dataType:"html", success:function (data, textStatus) {$("#timeline").html(data);}, type:"post", url:"\/Twitter-aug-6\/Twitter\/Tweets"});
return false;});});