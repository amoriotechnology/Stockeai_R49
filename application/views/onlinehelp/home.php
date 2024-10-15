<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Sidebar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: "Lato", sans-serif;
            margin: 0;
            padding: 0;
        }

        li>a {
            padding: 12px 5px 12px 15px;
            display: block;
            color: #fff;
            position: relative;
            font-size: 15px;
            font-weight: 500;
            letter-spacing: .3px;
        }

        .sidenav {
            height: 100%;
            width: 230px;
            position: fixed;
            z-index: 1;
            top: 65px;
            left: 0;
            background-color: #424f5c;
            overflow-x: hidden;
            padding-top: 20px;
            border-right: 2px solid #fff;
        }

        .sidenav a,
        .sidenav ul li a {
            padding: 6px 8px 6px 16px;
            text-decoration: none;
            font-size: 15px;
            color: #fff;
            display: block;
        }

        .sidenav ul {
            list-style-type: none;
            padding: 0;
        }

        .sidenav .dropdown-content {
            display: none;
            background-color: #424f5c;
            padding-left: 16px;
        }

        .sidenav .dropdown-content a {
            padding: 8px 8px 8px 16px;
        }

        .main {
            margin-left: 250px;
            /* Adjust this margin based on your sidebar width */
            padding: 16px;
            font-size: 28px;
        }

        .hidden {
            display: none;
        }

        .breadcrumb {
            border: 3px solid #D7D4D6;
        }

        input[type="text"] {
            height: 40px;
            margin: 20px 10px;

        }

        .topbar {
            height: 65px;
            width: auto !important;
            background-color: #424f5c;
            border-bottom: 2px solid;
        }

        .img-circle {
            border-radius: 500px;

            width: 100%;
            max-width: 65px;
            height: 65px;
            border: 2px solid rgba(255, 255, 255, .1);
            padding: 5px;
        }

        .info p {
            font-weight: 500;
            color: #fff;
            margin: 5px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
</head>

<body>
    <section>
        <div class="topbar"></div>
    </section>

    <aside>
        <div class="sidenav">
            <div style="display: flex; align-items: center;">
                <div class="image col-md-6">
                    <?php if (!empty($superadmin_logo[0]['logo'])) : ?>
                        <img src="<?php echo base_url() . htmlspecialchars($superadmin_logo[0]['logo']); ?>" class="img-circle">
                    <?php else : ?>
                        <p>No logo uploaded.</p>
                    <?php endif; ?>
                </div>
                <div class="info col-md-6">
                    <?php
                    if ($_SESSION['u_type'] == 1) {

                    ?>
                        <p>Super User </p>
                    <?php } elseif ($_SESSION['u_type'] == 2) { ?>
                        <p style="margin-left: -30px;text-wrap: wrap;"><?php echo ($retrieve_admin_data[0]['first_name'] . ' ' . $retrieve_admin_data[0]['last_name']); ?> </p>
                        <p style="color:white;"> <?php echo $_SESSION['unique_id']; ?> </p>
                    <?php } elseif ($_SESSION['u_type'] == 3) { ?>
                        <p style="margin-left: -30px;text-wrap: wrap;"> <?php echo ($retrieve_user_data[0]['first_name'] . ' ' . $retrieve_user_data[0]['last_name']); ?> <?php
                                                                                                                                                                            //    $retrieve_user_data[0]['last_name']
                                                                                                                                                                            $data = $this->session->all_userdata();
                                                                                                                                                                            //print_r($data) ;
                                                                                                                                                                            ?></p>
                        <p style="color:white;"> <?php echo $_SESSION['unique_id']; ?> </p>
                    <?php } ?>
                </div>
            </div>

            <input type="text" id="mySearch" onkeyup="myFunction()" placeholder="Search.." title="Type in a category">
            <ul id="myMenu">
                <li class="dropdown">
                    <a href="#" class="dropbtn"><i class="fa fa-plus" aria-hidden="true"></i> Package Information</a>
                    <div class="dropdown-content">
                        <a href="#" onclick="toggleSection('div1')">Package 1</a>
                        <a href="#" onclick="toggleSection('div2')">Package 2</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropbtn"><i class="fa fa-plus" aria-hidden="true"></i> Installation And Implementing</a>
                    <div class="dropdown-content">
                        <a href="#" onclick="toggleSection('div3')">Banana</a>
                        <a href="#" onclick="toggleSection('div4')">Grapes 2</a>
                    </div>
                </li>
                <li><a href="#">CSS</a></li>
                <li><a href="#">JavaScript</a></li>
                <li><a href="#">PHP</a></li>
            </ul>
        </div>
    </aside>

    <div class="main">
        <div id="div1" style="display:none;">
            <h2>Package 1</h2>
            <p>Apple</p>
        </div>
        <div id="div2" style="display:none;">
            <h2>Package 2</h2>
            <p>This is the content for Package 2.</p>
        </div>
        <div id="div3" style="display:none;">
            <h2>Apple</h2>
            <p>Green Apple</p>
        </div>
        <div id="div4" style="display:none;">
            <h2>Package 2</h2>
            <p>banana</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var dropdowns = document.querySelectorAll('.dropdown .dropbtn');
            dropdowns.forEach(function(dropdown) {
                dropdown.addEventListener('click', function(e) {
                    e.preventDefault();
                    var dropdownContent = this.nextElementSibling;
                    dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
                    var icon = this.querySelector('i');
                    icon.className = icon.className === 'fa fa-plus' ? 'fa fa-minus' : 'fa fa-plus';
                });
            });
        });

        function myFunction() {
            var input, filter, ul, li, a, i;
            input = document.getElementById("mySearch");
            filter = input.value.toUpperCase();

            // Search through sidebar menu items
            ul = document.getElementById("myMenu");
            li = ul.getElementsByTagName("li");
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName("a")[0];
                if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = ""; // Show the list item
                } else {
                    li[i].style.display = "none"; // Hide the list item
                }
            }

            // Search through div elements in the main content
            var divs = document.querySelectorAll('.main > div');
            divs.forEach(function(div) {
                var h2 = div.getElementsByTagName("h2")[0];
                var p = div.getElementsByTagName("p")[0];
                if (h2.innerHTML.toUpperCase().indexOf(filter) > -1 || p.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    div.style.display = ""; // Show the div
                } else {
                    div.style.display = "none"; // Hide the div
                }
            });
        }

        function toggleSection(sectionId) {
            var section = document.getElementById(sectionId);
            var allSections = document.querySelectorAll('.main > div'); // Select all divs inside .main

            // Hide all other sections
            allSections.forEach(function(sec) {
                if (sec.id !== sectionId) {
                    sec.style.display = 'none';
                }
            });

            // Toggle the display of the selected section
            if (section.style.display === 'none') {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        }
    </script>

</body>

</html>