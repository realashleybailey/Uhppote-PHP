<?php
/*
 * Created on Tue Jul 27 2021
 *
 * The MIT License (MIT)
 * Copyright (c) 2021 Uhppote PHP
 * Created by Ashley Bailey
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * and associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial
 * portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED
 * TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

require_once(realpath(dirname(__FILE__) . "/resources/config.php"));
template('header_inc.php');

if (isset($_SESSION['LOGGED_IN']) && $_SESSION['LOGGED_IN'] == true) {
    header('Location: /admin');
}

?>
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

    @media (max-width:820px) {
        .loginbox {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    }
</style>
<div class="main">
    <div class="loginbox bg-white rounded-5 shadow-5-strong p-5 ">
        <form id="login">
            <div class="w-100 d-flex justify-content-center mb-6">
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

            <div id="errorInfo" class="alert bg-danger m-0 mt-3 p-2 text-center text-white" style="display:none; font-family: 'Roboto',sans-serif;">
            </div>
        </form>
    </div>
</div>


<?php
template('footer_inc.php');
?>
<script>
    window.authToken = '<?php echo \UhppotePHP\JWT\WebAuth::Create(); ?>';
</script>
</body>

</html>