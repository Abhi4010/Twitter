$(document).ready(function () {$("#submit-902678714").bind("click", function (event) {$.ajax({data:$("#submit-902678714").closest("form").serialize(), type:"post", url:"\/Twitter\/users\/register"});
return false;});});