<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Clean Keyword Lists & Duplicate Remover</title>
    <meta name="description"
        content="List Cleaner removes duplicates, bad characters, and cleanses your keyword lists, email lists, URL lists and other text-based lists." />
    <meta name="keywords"
        content="list cleaner, list cleanup, clean list, listclean, list cleaner tool, remove duplicates, remove duplicate keywords, remove duplicate emails, clean up list" />
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        function ajaxFunction(ajaxurl, str, ajaxout, fMethod) {
            var fMethod = (fMethod == null) ? "GET" : fMethod;
            var token = $("meta[name='csrf-token']").attr("content");
            var xmlHttp;
            try {
                // Firefox, Opera 8.0+, Safari
                xmlHttp = new XMLHttpRequest();
            } catch (e) {
                // Internet Explorer
                try {
                    xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
                } catch (e) {
                    try {
                        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
                    } catch (e) {
                        alert("Your browser does not support AJAX!");
                        return false;
                    }
                }
            }
            xmlHttp.onreadystatechange = function() {
                if (xmlHttp.readyState == 4) {
                    if (xmlHttp.status == 200) {
                        var ajaxDisplay = document.getElementById(ajaxout);
                        ajaxDisplay.innerHTML = xmlHttp.responseText;
                    } else {
                        ajaxDisplay.innerHTML = "<div class='error'>Error: Invalid response from server</div>";
                    }
                }
            }
            switch (fMethod) {
                case "GET":
                    xmlHttp.open("GET", ajaxurl, true);
                    xmlHttp.send(null);
                    break;

                case "POST":
                    xmlHttp.open("POST", ajaxurl, true);
                    xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
                    xmlHttp.send(str);
                    break;
            }

        }

        function getFormValues(fname, valFunc) {
            var str = "";
            var valueArr = null;
            var val = "";
            var cmd = "";
            fobj = document.getElementById(fname);
            for (var i = 0; i < fobj.elements.length; i++) {
                switch (fobj.elements[i].type) {
                    case "text":
                        if (valFunc) {
                            cmd = valFunc + "(" + 'fobj.elements[i].value' + ")";
                            val = eval(cmd)
                        }
                        str += fobj.elements[i].name + "=" + escape(fobj.elements[i].value) + "&";
                        break;
                    case "select-one":
                        str += fobj.elements[i].name + "=" + fobj.elements[i].options[fobj.elements[i].selectedIndex]
                            .value + "&";
                        break;
                    case "checkbox":
                        if(fobj.elements[i].checked){
                            str += fobj.elements[i].name + "=" + escape(fobj.elements[i].value) + "&";
                        }
                        break;
                    case "textarea":
                        str += fobj.elements[i].name + "=" + escape(fobj.elements[i].value) + "&";
                        break;
                }
            }
            str = str.substr(0, (str.length - 1));
            return str;
        }

        function submitForm(fId, fAction) {

            document.getElementById("ajaxResults").innerHTML =
                "<div style='text-align:center;'><img src='__Iphone-spinner-1.gif' /></div>";
            var str = getFormValues("fMain", "");
            ajaxFunction(fAction, str, "ajaxResults", "POST");
        }
    </script>
    <link rel="shortcut icon" href="http://tools.seobook.com/favicon.ico">
    <link rel="stylesheet" type="text/css" href="http://tools.seobook.com/css/loader.css" />
    <link href='http://fonts.googleapis.com/css?family=Droid+Sans:regular&subset=latin' rel='stylesheet'
        type='text/css'>
    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-214089-1', 'auto');
        ga('require', 'displayfeatures');
        ga('send', 'pageview');
    </script>
    <script type="text/javascript" src="http://tools.seobook.com/js/loader.js" />
    </script>

    <script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>
</head>

<body>
    <div id="primer" align="center">
        <!-- START PAGE -->
        <div id="binder" class="round" align="left">
            <div id="training">
                <div id="content">
                    <h1>Keyword List Cleaner</h1>
                    <form action="{{ route('test') }}" methods="post" id="fMain" name="fMain">
                        @csrf
                        <h2>1. Choose Your Settings</h2>

                        <div class="frmBoxSettings">
                            <input type="checkbox" value="f_duplicates" name="check[]" checked /> Remove duplicates
                        </div>
                        <div class="frmBoxSettings">
                            <input type="checkbox" value="f_empty" name="check[]" checked /> Remove blank lines
                        </div>
                        <div class="frmBoxSettings">
                            <input type="checkbox" value="f_sort" name="check[]" checked /> Sort alphabetically
                        </div>
                        <div class="frmBoxSettings">
                            <input type="checkbox" value="f_alphanum" name="check[]" /> Make alphanumeric
                        </div>
                        <div class="frmBoxSettings">
                            <input type="checkbox" value="f_toupper" name="check[]" /> Make all uppercase
                        </div>
                        <div class="frmBoxSettings">
                            <input type="checkbox" value="f_tolower"  name="check[]"/> Make all lowercase
                        </div>
                        <div class="frmBoxSettings">
                            <input type="checkbox" value="f_emailsonly" name="check[]" /> Extract valid emails only
                        </div>
                        <div class="frmBoxSettings">
                            <input type="checkbox" value="f_urlsonly" name="check[]" /> Extract valid URLs only
                        </div>

                        <br clear="all" />

                        <h2>2. Paste Your List Below</h2>
                        <textarea name="f_list" id="f_list" class="fTextbox"></textarea>
                        <br />
                        <input type="button" onClick="submitForm('fMain','{{ route('test') }}');"
                            value="Run List Cleaner" class="frmSubmit" />
                    </form>

                    <div id="ajaxResults" name="ajaxResults" class="frmResults">

                    </div>
                </div>

                <div class="foot"></div>
            </div>

        </div>
    </div>
    <!-- END PAGE & PRIMER -->


    <!-- FOOTER END -->
</body>

</html>
