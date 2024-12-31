<!doctype html>
<html>
    <head>
        <meta charset='utf-8'>
        <title>Mgregchi: Snippet - Bootstrap popover</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <meta name='author' content="Mgregchi">
        <meta name="email" content="mgregchi@gmail.com">
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css' rel='stylesheet'>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>        
    </head>
    <body>


        <style>
            html, body {
                color: goldenrod;
                background-color: darkslategray;
            }
            .body-content {
                margin: 25% 25%;
            }
            .popover{
                width:250px;
            }
        </style>


        <section class="body-content" >
            <div hidden style="width: 300px;">
                <div data-name="popover-content" style="text-align:center;width:100%;">
                    <div style="display:flex;flex-direction:column;justify-content:center;align-items:center;">
                        <i class="bx bxs-user" style="font-size:5rem;"></i>
                        <p>July Htwe</p>
                        <p>july@gmail.com</p>
                        <button class="btn btn-danger">LogOut</button>
                    </div>
                </div>
            </div>
            
            <a id="example" data-bs-placement="bottom" tabindex="0" role="button" data-bs-toggle="popover" style="position:absolute;top: 3rem;right:4rem;"><i class="bx bxs-user" style="font-size:2rem;"></i></a>
            
        </section>
        
            <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>

            <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js'></script>
            <script type='text/javascript'>
    
            
                $(document).ready(function() {
                    
                    var options = {
                        html: true,
                        title: "Profile",
                        //html element
                        //content: $("#popover-content")
                        content: $('[data-name="popover-content"]')
                        //Doing below won't work. Shows title only
                        //content: $("#popover-content").html()
            
                    }
                    var exampleEl = document.getElementById('example')
                    var popover = new bootstrap.Popover(exampleEl, options)
                })
            </script>
    </body>
</html>