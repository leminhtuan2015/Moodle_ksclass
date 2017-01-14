<div class="container">
    <ul class = "pagination">
<!--        <li><a href = "#">&laquo;</a></li>-->
        <?php for ($i = 1; $i <= $pageZise; $i++) {?>
            <li class="ks_paging <?php if($i == 1){ echo "active";}?>"
                id="<?php echo $i?>"><a href = "#"><?php echo $i?></a></li>
        <?php } ?>
<!--        <li class="ks_paging" id="6"><a href = "#">&raquo;</a></li>-->
    </ul>
</div>

<script>
    $(".ks_paging").click(function (event) {
        id = event.target.id
        $(".ks_paging").removeClass("active")
        $(this).addClass("active")

        getByTag(this.id)
    });
</script>