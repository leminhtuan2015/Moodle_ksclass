<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Nav tabs --><div class="card">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Files</a></li>
                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Tests</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <?php require_once ("files/index.php");?>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile">
                        <?php require_once (__DIR__."/../../question_categories/index.php");?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>