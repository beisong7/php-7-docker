<script>

    function mainTemplate() {
        let template = `<html xmlns='http://www.w3.org/1999/xhtml'>

                                    <head>
                                        <meta charset="utf-8">
                                        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                                        <meta name='viewport' content='width=device-width' />

                                    <style type='text/css'>
                                    * {
                                    margin: 0;
                                    padding: 0;
                                    font-size: 100%;
                                    font-family: 'Avenir Next', 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
                                    line-height: 1.65;
                                    }

                                    img {
                                    max-width: 100%;
                                    margin: 0 auto;
                                    display: block;
                                    }

                                    body,
                                    .body-wrap {
                                    width: 100% !important;
                                    height: 100%;
                                    background: #f8f8f8;
                                    }

                                    a {
                                    color: #E63812;
                                    text-decoration: none;
                                    }

                                    a:hover {
                                    text-decoration: underline;
                                    }

                                    .text-center {
                                    text-align: center;
                                    }

                                    .text-right {
                                    text-align: right;
                                    }

                                    .text-left {
                                    text-align: left;
                                    }

                                    .button {
                                    display: inline-block;
                                    color: white;
                                    background: #E63812;
                                    border: solid #E63812;
                                    border-width: 10px 20px 8px;
                                    font-weight: bold;
                                    border-radius: 4px;
                                    }

                                    .button:hover {
                                    text-decoration: none;
                                    }

                                    h1,
                                    h2,
                                    h3,
                                    h4,
                                    h5,
                                    h6 {
                                    margin-bottom: 20px;
                                    line-height: 1.25;
                                    }

                                    h1 {
                                    font-size: 32px;
                                    }

                                    h2 {
                                    font-size: 28px;
                                    }

                                    h3 {
                                    font-size: 24px;
                                    }

                                    h4 {
                                    font-size: 20px;
                                    }

                                    h5 {
                                    font-size: 16px;
                                    }

                                    p,
                                    ul,
                                    ol {
                                    font-size: 16px;
                                    font-weight: normal;
                                    margin-bottom: 20px;
                                    }

                                    .container {
                                    display: block !important;
                                    clear: both !important;
                                    margin: 0 auto !important;
                                    max-width: 580px !important;
                                    }

                                    .container table {
                                    width: 100% !important;
                                    border-collapse: collapse;
                                    }

                                    .container .masthead {
                                    padding: 80px 0;
                                    background: #E63812;

                                    color: white;
                                    }

                                    .container .masthead h1 {
                                    margin: 0 auto !important;
                                    max-width: 90%;
                                    text-transform: uppercase;
                                    }

                                    .container .content {
                                    background: white;
                                    padding: 30px 35px;
                                    }

                                    .container .content.footer {
                                    background: none;
                                    }

                                    .container .content.footer p {
                                    margin-bottom: 0;
                                    color: #888;
                                    text-align: center;
                                    font-size: 14px;
                                    }

                                    .container .content.footer a {
                                    color: #888;
                                    text-decoration: none;
                                    font-weight: bold;
                                    }

                                    .container .content.footer a:hover {
                                    text-decoration: underline;
                                    }
                                    </style>
                                    </head>

                                    <body>
                                    <table class='body-wrap'>
                                    <tr>
                                    <td class='container'>

                                    <table>
                                    <tr>
                                    <td align='center' class='masthead'>
                                    <div class="" style="width: 30%">
                                    <img src='https://www.irecharge.ng/images/irechargenormallogo.svg' alt="logo" style="width: 100%">
                                    </div>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td class='content'>

                                    <h5>Dear __name__,</h5>

                                       <i>replace content</i>


                                    </td>
                                    </tr>
                                    </table>

                                    </td>
                                    </tr>
                                    <tr>
                                    <td class='container'>

                                    <table>
                                    <tr>
                                    <td class='content footer' align='center'>
                                    <p>Sent by <a href='https://irecharge.ng' target="_blank">irecharge.ng</a>, Nigeria</p>
                                    </td>
                                    </tr>
                                    </table>
                                    </td>
                                    </tr>
                                    </table>
                                    </body></html>`;
        var answer = prompt("Are you sure you want to add this template? it will remove previous template if any. type 'yes' to continue");
        if (answer === "yes") {
            tinyMCE.activeEditor.setContent(template);
        }else{

        }
    }

    function clearTemplate() {
        var answer = prompt("Are you sure you want to clear the email field? type 'yes' to continue");
        if (answer === "yes") {
            tinyMCE.activeEditor.setContent(" ");
        }else{

        }
    }

    $(document).on('click', '.add-template', function (e) {
        let content = $(this).data('payload');
        tinyMCE.activeEditor.setContent(content);
    })
</script>
