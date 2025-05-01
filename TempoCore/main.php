<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <script>
        async function run_cyclic(link) {
            let promise = await new Promise(function(resolve, reject) {
                var xml = new XMLHttpRequest;
                xml.onload = function() {
                    var data = xml.responseText;
                    console.log(data);
                    resolve(data);
                }
                xml.open("GET", link);
                xml.send();
            });
            return promise;
        }


        <?php
            $module_power_devices_optymalization = true;

            if ($module_power_devices_optymalization) echo 'var opt_dev_pov = setInterval(() => {run_cyclic("power_devices_optymalization/optymalization.php")},30*60*1000)';
        ?>





    </script>
</body>
</html>