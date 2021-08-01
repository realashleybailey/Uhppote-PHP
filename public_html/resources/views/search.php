<div class="card mb-2">
    <div class="card-body">
        <h5 class="card-title">Search for Controllers</h5>
        <p class="card-text">
            Find Uhppote controllers on this local network, your controller must be on the same network as the server running this website.
        </p>
        <button type="button" id="searchUhppote" class="btn btn-primary">Search</button>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Serial Number</th>
                        <th scope="col">IP Address</th>
                        <th scope="col">Mac Address</th>
                        <th scope="col">Subnet Mask</th>
                        <th scope="col">Gateway</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody id="searchUpphoteList">
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="saveBox" class="modal fade" data-mdb-backdrop="static" data-mdb-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered">
        <div class="modal-content">
            <form id="saveController" novalidate>
                <div class="modal-header d-flex justify-content-center" style="margin-top: -1px;">
                    <h5 class="modal-title" style="font-family: 'Roboto',sans-serif;">Save Controller</h5>
                </div>
                <div class="modal-body row g-3 needs-validation">
                    <div class="col-md-12">
                        <div class="form-outline">
                            <input type="text" class="form-control" id="controllername" required />
                            <label for="validationCustom01" class="form-label">Controller Name</label>
                            <div class="invalid-feedback">Please choose a name.</div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-outline">
                            <input type="text" class="form-control" id="controllerserial" maxlength="6" required />
                            <label for="validationCustom02" class="form-label">Serial Number</label>
                            <div class="invalid-feedback">Please provide serial number.</div>
                        </div>
                        <div id="validationCustom02" class="form-text">
                            This is the last 6 charaters of the MAC address
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group form-outline">
                            <input type="text" class="form-control" id="controlleripv4" name="ipv4" />
                            <label for="validationCustomUsername" class="form-label">IP Address</label>
                            <div class="invalid-feedback">Please input IP address.</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success ripple-surface">
                        Save
                    </button>
                    <button type="button" class="btn btn-danger ripple-surface" data-mdb-dismiss="modal">
                        Close
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- <script src="/js/jquery-3.6.0.min.js"></script>
<script src="/js/inputmask.js"></script>
<script src="/js/mdb.min.js"></script> -->
<script>
    window.authToken = '<?php echo \UhppotePHP\JWT\WebAuth::Create(); ?>';
</script>