<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 1/10/17
 * Time: 10:10 AM
 */
?>

<script src="/moodle/koolsoft/quiz/resources/javascript/quiz_result_user.js"></script>
<div id="quizResultForUserDialog" class="modal fade" role="dialog" style="overflow-y: auto;">
    <div class="modal-dialog" style="width: 90%">
        <div class="modal-content" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 id="quizResultForUserHeader" class="modal-title">Result for all quiz in class</h4>
            </div>
            <div class="modal-body" style="overflow: hidden" >
                <table class="table">
                    <thead>
                        <tr>
                            <td>Quiz name</td>
                            <td>Status</td>
                            <td>Grade</td>
                            <td>Time</td>
                        </tr>
                    </thead>
                    <tbody id="quizResultForUserContent">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
            </div>
        </div>

    </div>
</div>
