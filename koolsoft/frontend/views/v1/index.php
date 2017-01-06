<script>
        $(document).ready(function(){$('[data-toggle="tooltip"]').tooltip();});
</script>

<STYLE type="text/css">
	.panelContent{
		width: 90%;
		margin: 0 auto;
        margin-bottom: 20px;
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

<BODY >
	<DIV class='panelContent'>
		<a class='iconFont-Home' href="/moodle/koolsoft/course/?action=new" >
            <i class="fa fa-plus-circle" style="color:black;width:60px;float:right;"></i>
        </a>
		<div style="padding:30px 0px;">
			<a class='iconFont-Home' href="" ><i class="fa fa-star-o" style="color:black;width:30px;"></i></a>
			<h4 style="display:inline-block;">Lop yeu thich<a href="" style="font-size: 0.8em;"> Tat ca</a></h4>
		</div>

        <div class="" style="width: 100%; overflow: hidden;">
            <?php
                foreach ($myCourses as $course) {
                    include ("course_overview.php");
                }
            ?>
        </div>

		<div style="padding:30px 0px" style="margin-top:10px;">
			<a style="font-size: 2.0em;" href="" ><i class="fa fa-user-plus" style="color:black;width:30px;"></i></a>
			<h4 style="display:inline-block;">Lop cua toi<a href="" style="font-size: 0.8em;"> Tat ca</a></h4>
		</div>

        <div class="" style="width: 100%; overflow: hidden;">
            <?php
                foreach ($myCourses as $course) {
                    include ("course_overview.php");
                }
            ?>
        </div>

		<div style="padding:30px 0px">
			<a style="font-size: 2.0em;" href="" ><i class="fa fa-thumbs-o-up" style="color:black;width:30px;"></i></a>
			<h4 style="display:inline-block;">Lop noi bat<a href="" style="font-size: 0.8em;"> Tat ca</a></h4>
		</div>

        <div class="" style="width: 100%; overflow: hidden;">
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
