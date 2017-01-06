<script>
        $(document).ready(function(){$('[data-toggle="tooltip"]').tooltip();});
</script>

	<TITLE>Home</TITLE>
	<STYLE type="text/css">
	.panelContent{
		width: 90%;
		margin: 0 auto;
	}
	.hearder-Home{
		width: 100%;
		background-color: #0091ea;
		vertical-align: middle;
		padding: 5px 0px;
	}
	.iconFont-Home{
		font-size: 2.3em;
	}
	.itemCategory-Home{
		width: calc(100% - 35px);
		color: white;
	}
</STYLE>
</HEAD>

<BODY >
	<DIV class='panelContent'>
		<div class="hearder-Home">
			<a class='iconFont-Home' href="" style="margin-left:3%;"><i class="fa fa-graduation-cap" style="color:black;width:45px;"></i></a>
			<input type="text" placeholder="Search.." style="margin-left:3%;">
			<img src="images/viettel.png" style="width:60px;margin-left:3%;">
			<div style="display:inline-block;width:30%;float:right;">
				<a class='iconFont-Home' href="" style="margin-left:3%;"><i class="fa fa-book" style="color:black;width:45px;"></i></a>
				<a class='iconFont-Home' href="" style="margin-left:3%;"><i class="fa fa-user" style="color:black;width:45px;"></i></a>
				<h5 style="display:inline-block;margin-left:3%;" >Author</h5>
				<a class='iconFont-Home' href="" style="margin-left:3%;"><i class="fa fa-bell-o" style="color:black;width:45px;"></i></a>
			</div>
		</div>

		<a class='iconFont-Home' href="" ><i class="fa fa-plus-circle" style="color:black;width:60px;float:right;"></i></a>
		<div style="padding:30px 0px;">
			<a class='iconFont-Home' href="" ><i class="fa fa-star-o" style="color:black;width:30px;"></i></a>
			<h4 style="display:inline-block;">Lop yeu thich<a href="">Tat ca</a></h4>
		</div>

        <div class="" style="width: 100%">
            <?php
                foreach ($myCourses as $course) {
                    include ("course_overview.php");
                }
            ?>
        </div>

		<div style="padding:30px 0px" style="margin-top:10px;">
			<a style="font-size: 2.0em;" href="" ><i class="fa fa-user-plus" style="color:black;width:30px;"></i></a>
			<h4 style="display:inline-block;">Lop cua toi<a href="">Tat ca</a></h4>
		</div>

        <div class="" style="width: 100%">
            <?php
                foreach ($myCourses as $course) {
                    include ("course_overview.php");
                }
            ?>
        </div>

		<div style="padding:30px 0px">
			<a style="font-size: 2.0em;" href="" ><i class="fa fa-thumbs-o-up" style="color:black;width:30px;"></i></a>
			<h4 style="display:inline-block;">Lop noi bat<a href="">Tat ca</a></h4>
		</div>

        <div class="" style="width: 100%">
            <?php
            foreach ($courses as $course) {
                if($course->sortorder == 1){ continue;}

                include ("course_overview.php");
            }
            ?>
        </div>
	</DIV>
</BODY>
</HTML>
