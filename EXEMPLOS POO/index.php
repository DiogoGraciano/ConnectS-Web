<!DOCTYPE html>
<html>

<head>
    <!-- Remote style sheet -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    
    <!-- Local style sheet relative to workspace folder -->
    <link rel="stylesheet" href="/style.css">

    <!-- Local style sheet relative to this file -->
    <link rel="stylesheet" href="style.css">
    
    <!-- Embedded style sheet -->
    <style>
        #content {
            display: block;
        }

        .internal {
            display: block;
        }
    </style>
</head>

<body>
    <div class="container external internal" id="content">
        <div class="row">
            <div class="col">1 of 2</div>
            <div class="col">2 of 2</div>
        </div>
    </div>
</body>

</html>