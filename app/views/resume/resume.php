<style>
    body {
        font-size: 16px;
    }

    .home-link {
        position: fixed;
        top: 15px;
        right: 15px;
        height: 50px;
        width: 50px;
        border-radius: 25px;
        text-align: center;
        line-height: 50px;
        background-color: #404040;
        color: #fff;
        vertical-align: middle;
        -moz-box-shadow: 0 2px 2px rgba(0, 0, 0, 0.3);
        -webkit-box-shadow: 0 2px 2px rgba(0, 0, 0, 0.3);
        box-shadow: 0 2px 2px rgba(0, 0, 0, 0.3);
    }

    .paper {
        margin-top: 50px;
        margin-bottom: 50px;
        border-radius: 2px;
        -moz-box-shadow: 0 2px 2px rgba(0, 0, 0, 0.3);
        -webkit-box-shadow: 0 2px 2px rgba(0, 0, 0, 0.3);
        box-shadow: 0 2px 2px rgba(0, 0, 0, 0.3);
        width: 100%;
        background-color: #F7F7F7;
        display: flex;
    }
    .paper-left-col {
        background-color: #5D9CEC;
        flex: 2;
        padding: 15px;
    }
    .paper-right-col {
        flex: 7;
        padding: 20px 40px;
    }

    .pic-container {
        margin-bottom: 15px;
    }

    .pic-circle {
        width: 220px;
        height: 220px;
        margin: auto;
        border-radius: 110px;
        background: #fff url('img/resume_image.jpg') no-repeat center center;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        -moz-box-shadow: 0 2px 2px rgba(0, 0, 0, 0.3);
        -webkit-box-shadow: 0 2px 2px rgba(0, 0, 0, 0.3);
        box-shadow: 0 2px 2px rgba(0, 0, 0, 0.3);
    }

    .left-info-container {
        width: 100%;
        display: block;
        color: #24292E;
    }

    .left-section a, .left-section a:visited {
        color: #24292E !important;
        text-decoration: underline;
    }

    .info-name-container {
        text-align: center;
        margin: auto;
    }
    .info-name-container h1 {
        font-size: 33px;
    }
    .info-name-container p {
        font-size: 19px;
        margin-bottom: 0;
    }

    .left-section {
        margin-top: 33px;
        font-size: 17px;
    }

    h3 {
        margin: 37px 0 15px;
        text-transform: uppercase;
        font-size: 1.3em;
        font-weight: 600;
    }

    h4 {
        font-size: 1em;
    }

    .show-more-trigger {
        display: none;
        flex-basis: 100%;
        font-size: .8em;
        margin-bottom: -13px;
        text-align: right;
    }

    @media (max-width: 767px) {
        .paper-left-col > div:nth-child(3) {
            flex-basis: 100%;
        }
    }

    @media (max-width: 1100px) {

        .show-more-trigger {
            display: block;
        }

        #hide-left {
            display: none;
            flex-basis: 100%;
        }
        .paper {
            display: block;
        }
        .paper-right-col {
            display: block;
        }
        .paper-left-col {
            display: flex;
            flex-wrap: wrap;
        }
        .paper-left-col > div:first-child {
            flex: 1;
        }
        .paper-left-col > div:nth-child(2) {
            flex: 2;
        }
        .paper-left-col > div:nth-child(3) {
            flex: 2;
        }
        .pic-container {
            margin-bottom: 0;
        }

        .pic-circle {
            height: 100px;
            width: 100px;
            border-radius: 50px;
            margin: 0 20px 0 0;
            display: inline-block;
        }
        .left-info-container {
            display: inline-block;
        }

        .info-name-container h1 {
            font-size: 20px;
            margin-top: 0;
        }
        .info-name-container p {
            font-size: 16px;
        }


    }
</style>

<div class="container">

        <div class="home-link" style="">
            <a href="<?=BASE_PATH?>" style="color: #fff"><i class="fa fa-home fa-2x" style="margin-top: 8px"></i></a>
        </div>

        <div class="paper">


            <div class="paper-left-col">

                <div class="pic-container">

                    <div class="pic-circle">

                    </div>

                </div>

                <div class="left-info-container">

                    <div class="info-name-container">

                        <h1>Chris Esser</h1>

                        <p>Madison, WI</p>
                        <p>esser32@gmail.com</p>
                        <p>(608) 886-0557</p>

                    </div>

                </div>


                <div class="left-section-container">

                    <div class="left-section">

                        <table class="table" style="border: none; margin-bottom: 0">
                            <tbody>
                                <tr>
                                    <td><a href="https://github.com/chrisesser" target="_blank"><i class="fa fa-github"></i> Github</a></td>
                                    <td><a href="https://www.linkedin.com/in/christopher-esser-316113b4/" target="_blank"><i class="fa fa-linkedin"></i> Linkedin</a></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>

                <div id="hide-left">

                    <h3>Skills</h3>

                    <h4 style="font-size: 1.1em; text-decoration: underline">Backend Development</h4>
                    <p>PHP 5.3+, PHPUnit, AWS, Composer, xDebug, Performance, SOAP/Resful API, Design Patterns, Laravel, MVC</p>

                    <h4 style="font-size: 1.1em; text-decoration: underline">Frontend Development</h4>
                    <p>HTML5, CSS3, Javascript, JQuery, React, Ajax, JSON, Bootstrap, Responsive Design, UI/UX</p>

                    <h4 style="font-size: 1.1em; text-decoration: underline">Databases</h4>
                    <p>MySQL, SQL Server, SQLite, PostgreSQL, MongoDB</p>


                    <h3>Personal Details</h3>

                    <p>DOB: 10/19/1982<br />
                        Hometown: Lancaster, WI</p>

                </div>

                <div id="show-more-trigger" class="show-more-trigger pull-right">
                    Show More <i class="fa fa-chevron-down"></i>
                </div>


            </div>

            <div class="paper-right-col">

                <h3 style="margin-top: 20px">Summary</h3>

                <p>I’ve worked as a web developer for 4 years. </p>

                <p>I have strong knowledge of PHP, OOP, and how to implement most common
                    design patters. I’ve worked with many third party, as well as created, RESTful
                    APIs. I have experience with upgrading legacy code with modern
                    technologies. I’ve worked with large and complex databases. I have strong
                    knowledge of HTML5, CSS and responsive web design.</p>

                <p>I am open to learn and implement any new technologies</p>

                <p>I am currently looking for a developer position that will allow me to apply my
                    knowledge, grow professionally, and expand my knowledge of all things.</p>


                <h3>Specialties</h3>

                <h4>Backend: PHP 5.6+, OOP, Composer, SOAP/RESTful APIs</h4>

                <h4>Frontend: HTML5, CSS3, SASS, LESS. JQuery, Bootstrap</h4>

                <h4>Databases: MsSQL, SQLite, PostgreSQ</h4>

                <h4>Other Software Development: Delphi (Windows Desktop Applications)</h4>


                <h3>Work History</h3>

                <table class="table">
                    <tr>
                        <td>May 2015 – Present</td>
                        <td>
                            <b>PHP/Software Developer</b><br />
                            Clarity Technology Group<br />
                            <ul>
                                <li>Architect, design, and develop PHP applications and web sites</li>
                                <li>Performance and database optimization</li>
                                <li>Implementing approved web designs</li>
                                <li>End user support</li>
                                <li>Client support/meetings</li>
                                <li>Windows desktop application development</li>
                            </ul>

                        </td>
                    </tr>
                    <tr>
                        <td>2011 – Present</td>
                        <td>
                            <b>Software Developer</b><br />
                            Freelance<br />
                            <ul>
                                <li>Custom MVC (PHP) framework development</li>
                                <li>Open Source CMS web development</li>
                                <li>C++ dll development</li>
                                <li>Mobile app development</li>
                                <li>Lua Scripting</li>
                            </ul>

                        </td>
                    </tr>
                </table>

                <h3>Education</h3>

                <p>Southwest Wisconsin Technical College - Associate of Science - 2015</p>

            </div>


        </div>

</div>

<script>
    $(document).ready(function() {
        $('#show-more-trigger').click(function() {
            if ($('#hide-left').is(":visible")) {
                $('#hide-left').slideUp(300);
                $(this).html('Show More <i class="fa fa-chevron-down"></i>');
            }
            else {
                $('#hide-left').slideDown(300);
                $(this).html('Show Less <i class="fa fa-chevron-up"></i>');
            }
        });
    });
</script>
