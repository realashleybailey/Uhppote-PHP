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
            <div class="modal-header d-flex justify-content-center" style="margin-top: -1px;">
                <h5 class="modal-title" style="font-family: 'Roboto',sans-serif;">Save Controller</h5>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" novalidate>
                    <div class="col-md-12">
                        <div class="form-outline">
                            <input type="text" class="form-control" id="validationCustom01" required />
                            <label for="validationCustom01" class="form-label">Controller Name</label>
                            <div class="invalid-feedback">Please choose a name.</div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-outline">
                            <input type="text" class="form-control" id="validationCustom02" required />
                            <label for="validationCustom02" class="form-label">Serial Number</label>
                            <div class="invalid-feedback">Please provide serial number.</div>
                        </div>
                        <div id="validationCustom02" class="form-text">
                            This is the last 6 charaters of the MAC address
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group form-outline">
                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                            <input type="text" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required />
                            <label for="validationCustomUsername" class="form-label">Username</label>
                            <div class="invalid-feedback">Please choose a username.</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-outline">
                            <input type="text" class="form-control" id="validationCustom03" required />
                            <label for="validationCustom03" class="form-label">City</label>
                            <div class="invalid-feedback">Please provide a valid city.</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-outline">
                            <input type="text" class="form-control" id="validationCustom05" required />
                            <label for="validationCustom05" class="form-label">Zip</label>
                            <div class="invalid-feedback">Please provide a valid zip.</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required />
                            <label class="form-check-label" for="invalidCheck">
                                Agree to terms and conditions
                            </label>
                            <div class="invalid-feedback">You must agree before submitting.</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Submit form</button>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success ripple-surface" data-mdb-dismiss="modal">
                    Save
                </button>
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
    // var cookie = new mdb.Modal($('#exampleFrameModal2'));
    // cookie.show();
    window.authToken = '<?php echo \UhppotePHP\JWT\WebAuth::Create(); ?>';
</script>