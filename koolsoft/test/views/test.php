<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 1/3/17
 * Time: 11:12 AM
 */
?>
<script src="resources/javascript/test.js"></script>
<div class="container">
    <h4>Start quiz : <?php echo $quizName;?></h4>
    <form action="?action=process" method="post" id="formQuestion" role="form">
        <?php
        $index = 0;
        foreach ($questions as $question){
            $index ++;
            $prefix = "";
            if($index != 1){
                $prefix = " style='display: none;' ";
            }
            $answers = $question->options->answers;
            $questionHtml = "";
            $questionHtml .= "<div ".$prefix." id='questionDiv".$index."'> <label> Question ".$index." : ".$question->name."</label> <br>";
            $questionHtml .= "<input type='hidden' name='q".$attempt->uniqueid.":".$index."_:sequencecheck' value='".$sequenceChecks[$index - 1]."'>";

            $indexAnswer = 0;
            foreach ($answers as $answer){
                $questionHtml .= "<input type='radio' value='".$indexAnswer."' name='q".$attempt->uniqueid.":".$index."_answer'>"."<label>".$answer->answer."</label> <br>";
                $indexAnswer++;
            }

            $questionHtml .= "</div>";
            echo $questionHtml;
        }
        ?>

        <input type="hidden" name="action" value="process" >
        <input type="hidden" name="finishattempt" value="true" >
        <input type="hidden" name="attempt" value="<?php echo $id?>" >
        <input type="hidden" name="thispage" value="0" >
        <input type="hidden" name="nextpage" value="-1" >
        <input type="hidden" name="timeup" value="0" id="timeup">
        <input type="hidden" name="scrollpos" value="" id="scrollpos">
        <input type="hidden" name="slots" value="<?php echo $slotString?>" >
    </form>

    <input type="hidden" id="numberQuestion" value="<?php echo count($questions);?>" >
    <?php
    $index = 0;
    $questionHtml = "<div class='container'>";
    foreach ($questions as $question){
        $index ++;
        $questionHtml .= "<button class='btn btn-primary' indexQuestion='".$index."' id='questionBtn".$index."'>".$index."</button>";
    }
    $questionHtml .= "</div>";
    echo $questionHtml;
    ?>
    <br>
    <br>
    <button type="submit" form="formQuestion" class="btn btn-primary"> Finish test </button>
</div>
