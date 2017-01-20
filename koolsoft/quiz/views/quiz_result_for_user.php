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
                <ul class="nav nav-tabs">
				  <li class="active"><a id="testTab" data-toggle="tab" href="#test">Test</a></li>
				  <li><a id="exerciseTab" data-toggle="tab" href="#exercise">Exercise</a></li>
				</ul>

				<div class="tab-content">
				  <div id="test" class="tab-pane fade in active">
				    <table class="table">
	                    <thead>
	                        <tr>
	                            <td>Test name</td>
	                            <td>Grade</td>
	                            <td>Time</td>
	                        </tr>
	                    </thead>
	                    <tbody id="quizResultTestForUser">

	                    </tbody>
	                </table>
				  </div>
				  <div id="exercise" class="tab-pane fade">
				    <table class="table">
	                    <thead>
	                        <tr>
	                            <td>Exercise name</td>
	                            <td>Progress</td>
	                        </tr>
	                    </thead>
	                    <tbody id="quizResultExerciseForUser">

	                    </tbody>
	                </table>
				  </div>
				</div>
            </div>
            <div class="modal-footer">
            </div>
        </div>

    </div>
</div>
