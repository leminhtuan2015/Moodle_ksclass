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
        <?php require_once ("my_following_classes.php")?>
        <?php require_once ("my_created_classes.php")?>
        <?php require_once ("suggestion_classes.php")?>

	</DIV>
</BODY>
</HTML>
