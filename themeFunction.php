<?php
    function themeFunction() {
        $backgroundColor = "#fff";
        $textColor = "black";

        if (isset($_COOKIE["theme"]) && $_COOKIE["theme"] == 'dark') {
            $backgroundColor = "#000";
            $textColor = "#fff";
        }

        echo "<style> 
            body, .profile-container, .header-line {background-color: $backgroundColor;} 
            .profile-container {border: 2px solid #fff;}
            h1, h2, h3, h4, h5, h6, p, b, i, span, a, label, input[type='file'], td, th {color: $textColor !important;}
        </style>";
    }
?>
