<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>领航联盟-后台管理</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    <link href="/website/css/font-awesome.css" rel="stylesheet"/>
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    <script>
        var Group = <?php print_r(json_encode($group, true));?>
        
        var Token = '{{csrf_token()}}';
    </script>
</head>

<body>
    <div id="app"></div>
    <script type="text/javascript" src="/assetsAdmin/dist/manifest.js?6449e8a88d481df6dcab"></script>
    <script type="text/javascript" src="/assetsAdmin/dist/vendor.js?9f2e8d3edb3315b4ab2a"></script>
    <script type="text/javascript" src="/assetsAdmin/dist/index.js?4aed65a60d57fa424691"></script>
</body>
</html>