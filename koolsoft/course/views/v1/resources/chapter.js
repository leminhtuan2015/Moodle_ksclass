$(".active_link_lecture_test").click(function(){
	$(".active_link_lecture_test").removeClass("active_link_lecture_test_color");
	$(this).addClass("active_link_lecture_test_color");
});
$(".active_link_lecture").click(function(){
	$(".active_link_lecture").removeClass("active_link_lecture_test_color");
	$(this).addClass("active_link_lecture_test_color");
});