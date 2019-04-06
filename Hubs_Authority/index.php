<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $dir_path = "documentfiles";
        if (is_dir($dir_path)) {
            $files = scandir($dir_path);
            $count = 0;
            for ($i = 0; $i < count($files); $i++) {
                if ($files[$i] != '.' && $files[$i] != '..') {
                    $Q[$count] = strtoupper($files[$i]);
                    $count++;
                }
            }
        }
        //print_r($files);
        //print_r($Q);
        for ($k = 0; $k < count($Q); $k++) {
            $Q[$k] = trim(rtrim($Q[$k], ".TXT"));
        }
        //print_r($Q);
        foreach ($Q as $i) {
            foreach ($Q as $j) {
                $adj[$i][$j] = 0;
            }
        }
        //print_r($adj);
        foreach ($adj as $i => $v1) {
            $myfile = fopen("documentfiles/" . $i . ".txt", "r") or die("Unable to open file!");
            $D = fread($myfile, filesize("documentfiles/" . $i . ".txt"));
            $word_of_single_document = trim($D);
            $word_of_single_document = strtoupper($word_of_single_document);
            $word_of_single_document = preg_split("/[ ]+/", $word_of_single_document);
            $word_of_single_document = array_unique($word_of_single_document);

            foreach ($adj[$i] as $j => $v2) {
                foreach ($word_of_single_document as $l) {
                    //echo $l."  ".$j."  ".$i." <br>";
                    if ($l == $j && $l != $i) {
                        $adj[$i][$j] = 1;
                    }
                }
            }
        }
        print_r($adj);
        foreach ($Q as $i) {
            $h[$i] = 1;
            $a[$i] = 1;
        }
        //$temp_h = product($adj, $h);
        //print_r($temp_h);
        // print_r($adjt);
        // $a= normalization($a);
        //print_r($a);
        $adjt = transpose($adj);
        for ($i = 0; $i < 1; $i++) {
            $a = normalization(product($adjt, $h));
            $h = normalization(product($adj, $a));
            
           
        }
        echo "  HUBS   ";
        print_r($h);
        echo "<br>";
        echo 'AUTHORITY   ';
        print_r($a);

        function transpose($x) {
            foreach ($x as $i => $v1) {
                foreach ($x as $j => $v2) {
                    $xt[$i][$j] = $x[$j][$i];
                }
            }
            return $xt;
        }
        function product($x, $y) {
            foreach ($x as $i => $v1) {
                $z[$i] = 0;
                foreach ($y as $j => $v2) {
                    $z[$i] += ($x[$i][$j] * $y[$j]);
                }
            }

            return $z;
        }

        function normalization($x) {
            $sum = 0;
            foreach ($x as $j => $v1) {
                $sum += $x[$j] * $x[$j];
            }
            foreach ($x as $i => $v) {
                $x[$i] = $x[$i] / sqrt($sum);
            }
            return $x;
        }
        ?>
    </body>
</html>