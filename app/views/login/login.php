<style>
    body, html {
        height: 100%;
        background-repeat: no-repeat;
        background-image: linear-gradient(#abbaab, #ffffff);
    }
</style>

<div class="container">

    <?=HTML::displaySiteErrors()?>

    <div class="card card-container">
        <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
        <p id="profile-name" class="profile-name-card"></p>
        <form class="form-signin" action="<?=BASE_PATH?>/auth/login" method="POST">
            <span id="reauth-email" class="reauth-email"></span>
            <input type="email" id="email" name="email" class="form-control" placeholder="Email" required autofocus>
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
<!--            <div id="remember" class="checkbox">-->
<!--                <label>-->
<!--                    <input type="checkbox" value="1" id="remember" name="remember"> Remember me-->
<!--                </label>-->
<!--            </div>-->
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" role="button">Sign in</button>
        </form>
<!--        <a href="#" class="forgot-password">-->
<!--            Forgot the password?-->
<!--        </a>-->
    </div>
</div>


<script>
    $( document ).ready(function() {

         testLocalStorageData();
        // Load profile if it exits
//        loadProfile();
    });

    function getLocalProfile(callback){
        var profileImgSrc      = localStorage.getItem("PROFILE_IMG_SRC");
        var profileName        = localStorage.getItem("PROFILE_NAME");
        var profileReAuthEmail = localStorage.getItem("PROFILE_REAUTH_EMAIL");

        if(profileName !== null
            && profileReAuthEmail !== null
            && profileImgSrc !== null) {
            callback(profileImgSrc, profileName, profileReAuthEmail);
        }
    }

    function loadProfile() {
        if(!supportsHTML5Storage()) { return false; }
        getLocalProfile(function(profileImgSrc, profileName, profileReAuthEmail) {
            $("#profile-img").attr("src",profileImgSrc);
            $("#profile-name").html(profileName);
            $("#reauth-email").html(profileReAuthEmail);
            $("#inputEmail").hide();
            $("#remember").hide();
        });
    }

    function supportsHTML5Storage() {
        try {
            return 'localStorage' in window && window['localStorage'] !== null;
        } catch (e) {
            return false;
        }
    }

    function testLocalStorageData() {
        if(!supportsHTML5Storage()) { return false; }
        localStorage.setItem("PROFILE_IMG_SRC", "//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" );
        localStorage.setItem("PROFILE_NAME", "Chris Esser");
        localStorage.setItem("PROFILE_REAUTH_EMAIL", "esser32@gmail.com");
    }
</script>