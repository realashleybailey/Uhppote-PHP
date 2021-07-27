<style>
    html,
    body {
        height: 100%;
    }

    div.main {
        width: 100%;
        height: 100%;
        margin-right: auto;
        margin-left: auto;

        display: flex;
        justify-content: center;
        align-items: center;
        align-content: center;
    }
</style>
<div class="main">
    <div class="login bg-white rounded-5 shadow-5-strong p-5">
        <form action="" method="post">
            <div class="w-100 d-flex justify-content-center mb-4">
                <img src="/img/uhppote.png" height="50" alt="" loading="lazy">
            </div>
            <div class="form-outline mb-4">
                <input name="username" type="username" id="username" class="form-control active" autocompleted="">
                <label class="form-label" for="username" style="margin-left: 0px;">Username</label>
                <div class="form-notch">
                    <div class="form-notch-leading" style="width: 9px;"></div>
                    <div class="form-notch-middle" style="width: 67.2px;"></div>
                    <div class="form-notch-trailing"></div>
                </div>
            </div>

            <div class="form-outline mb-4">
                <input name="password" type="password" id="password" class="form-control active" autocompleted="">
                <label class="form-label" for="password" style="margin-left: 0px;">Password</label>
                <div class="form-notch">
                    <div class="form-notch-leading" style="width: 9px;"></div>
                    <div class="form-notch-middle" style="width: 64px;"></div>
                    <div class="form-notch-trailing"></div>
                </div>
            </div>

            <div class="row mb-4 d-flex justify-content-center">
                <div class="col-sm-12 col-lg-auto d-flex justify-content-center">
                    <div class="form-check">
                        <input name="remember" class="form-check-input" type="checkbox" value="" id="remember">
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>

    </div>
</div>