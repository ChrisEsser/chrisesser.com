<link rel="stylesheet" href="<?=BASE_PATH?>/css/home.css">

<div class="container">

    <div class="row row-eq-height" style="margin-top: 50px;">

        <div class="col-md-4" data-url="<?=BASE_PATH?>/trade">
            <div class="card card-trade">
                <div class="card-content">
                    <h4 class="card-title">Trade</h4>
                    <p class="category">Bitcoin toadding application using GDAX API.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4" data-url="<?=BASE_PATH?>/portfolio">
            <div class="card card-portfolio">
                <div class="card-content">
                    <h4 class="card-title">Portfolio</h4>
                    <p class="category">Screen shots and images of projects I've worked on.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4" data-url="<?=BASE_PATH?>/resume">
            <div class="card card-resume">
                <div class="card-content">
                    <h4 class="card-title">Resume</h4>
                    <p class="category">An HTML version of my resume.</p>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    $(document).ready(function() {
        $('.row-eq-height .col-md-4').click(function() {
            document.location = $(this).data('url');
        });
    });
</script>








