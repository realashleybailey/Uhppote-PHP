<link rel="stylesheet" href="/css/mdb.min.css">

<div id="errorBox" class="modal" tabindex="-1">
    <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white d-flex justify-content-center" style="margin-top: -1px;">
                <h5 class="modal-title" style="font-family: 'Roboto',sans-serif;">Notice</h5>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row text-center">
                        <i class="fa fa-times fa-3x text-danger"></i>
                    </div>
                    <div class="row bodytext text-center d-flex justify-content-center">
                        <?php
                        echo $error_message
                        ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-danger ripple-surface" data-mdb-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script src="/js/jquery-3.6.0.min.js"></script>
<script src="/js/mdb.min.js"></script>

<script>
    const errorBox = $('#errorBox');
    const errorModal = new mdb.Modal(errorBox);

    $(function() {
        errorModal.show();
    })
</script>