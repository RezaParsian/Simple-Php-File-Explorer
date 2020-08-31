<?php
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Tehran');

function Number_Desimal($number)
{
    return number_format((float)$number, 2, '.', '');
}

function filsize_32b($file) {
    if(substr(PHP_OS, 0, 3) == "WIN")
    {
        exec('for %I in ("'.$file.'") do @echo %~zI', $output);
        $return = $output[0];
    }
    else
    {
        $return = filesize($file);
    }
    return $return;
}

function Hajm($size)
{
    $type = '';
    if ($size >= 1073741824) {
        $size = number_format($size / 1073741824, 2);
        $type = ' گیگابایت';
    } elseif ($size >= 1048576) {
        $size = number_format($size / 1048576, 2);
        $type = ' مگابایت';
    } elseif ($size >= 1024) {
        $size = number_format($size / 1024, 2);
        $type = ' کیلوبایت';
    }
    return ($size) . $type;
}

$dirs = array();
$files = array();

$except_file = array(
    '.',
    '..',
    ".htaccess",
);

$except_type = array(
    // "php",
);

$dir_icon = "fa fa-folder-open";
$defult_path = "fa fa-question";
$file_type_icon = array(
    "apk" => "fab fa-android",
    "zip"=>"fas fa-file-archive",
    "php"=>"fab fa-php",
    "html"=>"fab fa-html5",
    "htm"=>"fab fa-html5",
    "css"=>"fab fa-css3",
    "png"=>"far fa-file-image",
    "jpg"=>"far fa-file-image",
    "jpeg"=>"far fa-file-image",
    "gif"=>"far fa-file-image",
    "js"=>"fab fa-js",
);

$mime_types = array(

    'txt' => 'text/plain',
    'htm' => 'text/html',
    'html' => 'text/html',
    'php' => 'text/html',
    'css' => 'text/css',
    'js' => 'application/javascript',
    'json' => 'application/json',
    'xml' => 'application/xml',
    'swf' => 'application/x-shockwave-flash',
    'flv' => 'video/x-flv',
    'sql' => "application/sql",

    // images
    'png' => 'image/png',
    'jpe' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'jpg' => 'image/jpeg',
    'gif' => 'image/gif',
    'bmp' => 'image/bmp',
    'ico' => 'image/vnd.microsoft.icon',
    'tiff' => 'image/tiff',
    'tif' => 'image/tiff',
    'svg' => 'image/svg+xml',
    'svgz' => 'image/svg+xml',

    // archives
    'zip' => 'application/zip',
    'rar' => 'application/x-rar-compressed',
    'exe' => 'application/x-msdownload',
    'msi' => 'application/x-msdownload',
    'cab' => 'application/vnd.ms-cab-compressed',

    // audio/video
    'mp3' => 'audio/mpeg',
    'qt' => 'video/quicktime',
    'mov' => 'video/quicktime',

    // adobe
    'pdf' => 'application/pdf',
    'psd' => 'image/vnd.adobe.photoshop',
    'ai' => 'application/postscript',
    'eps' => 'application/postscript',
    'ps' => 'application/postscript',

    // ms office
    'doc' => 'application/msword',
    'rtf' => 'application/rtf',
    'xls' => 'application/vnd.ms-excel',
    'ppt' => 'application/vnd.ms-powerpoint',

    // open office
    'odt' => 'application/vnd.oasis.opendocument.text',
    'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
);

$path = isset($_GET["path"]) ? htmlentities($_GET["path"]) : ".";

$temp = explode("/", $path);
$page_title = end($temp);


if (substr($path, -1) == "/") {
    $path = substr($path, 0, -1);
}

$found = scandir($path);

foreach ($found as $file) {
    $type = filetype($path . "/" . $file);

    if ($type == "dir") {
        array_push($dirs, $file);
    } else {
        array_push($files, $file);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>    <title>Rp76 - File Explorer</title>

    <style>
        .rtl {
            text-align: right;
            direction: rtl;
        }

        .ltr {
            text-align: left;
            direction: ltr;
        }
        .brd::after{
            content: '/';
            color: #dc3545;
        }
        .text-rose{
            color:#ff0054 !important;
        }
    </style>
</head>

<body class="bg-dark text-white rtl">
    <div class="container py-5">
        <div class="row ltr mx-auto my-2">
            <h2 class="title" style="direction: ltr;">
                <i class="fa fa-eercast text-danger"></i><a href="." title="Home" rel="bookmark" class='brd'>Home</a>
                <?php $splitpath = explode('/', $path);
                $link = "";
                foreach ($splitpath as $clm) {
                    $link .= $clm . "/";

                    if ($clm != ".." && $clm != ".") {
                        echo "<a href='?path=$link' rel='bookmark' title='$link' class='brd'>$clm</a>";
                    }
                }
                ?>
            </h2>
        </div>
        <div class="row mx-auto">
            <table class="table text-white shadow text-center border">
                <thead class="bg-primary">
                    <tr class="row-1 odd">
                        <th class="column-1">آیکون</th>
                        <th class="column-2">نام فایل</th>
                        <th class="column-3">پسوند فایل</th>
                        <th class="column-4">نوع فایل</th>
                        <th class="column-5">تاریخ بارگذاری</th>
                        <th class="column-6">ساعت بارگذاری</th>
                        <th class="column-7">حجم فایل
                        </th>
                        <th class="column-8">لینک دانلود</th>
                    </tr>
                </thead>
                <tbody class="row-hover">
                    <?php
                    foreach ($dirs as $dir) {
                        if (!in_array($dir, $except_file) && !in_array($dir, $except_type)) {
                            $filedate = date("Y-m-d", filectime($path . "/" . $dir));
                            $filetime = date("H:i:s", filectime($path . "/" . $dir));
                    ?>
                            <tr class="row-2 even">
                                <td class="column-1"><i class="<?= $dir_icon ?> fa-2x text-warning" aria-hidden="true"></i></td>
                                <td class="column-2"><?= $dir ?></td>
                                <td class="column-3">Dir</td>
                                <td class="column-4"> - </td>
                                <td class="column-5"><?= $filedate ?></td>
                                <td class="column-6"><?= $filetime ?></td>
                                <td class="column-7 text-rose"> - </td>
                                <td class="column-8"><a href="?path=<?= $path . "/" . $dir ?>" class="btn btn-outline-success btn-sm btn-block" role="button" rel="noopener noreferrer">ورود</a></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                    <?php
                    foreach ($files as $file) {
                        $mime_type = explode(".", $file);
                        $mime_type = end($mime_type);
                        $fl=$path . "/" . $file;
                        $filesize = filsize_32b($fl);//filesize($path . "/" . $file);
                        $filedate = date("Y-m-d", filectime($path . "/" . $file));
                        $filetime = date("H:i:s", filectime($path . "/" . $file));
                        if (!in_array($file, $except_file) && !in_array($mime_type, $except_type)) {
                    ?>
                            <tr class="row-2 even">
                                <td class="column-1"><i class="<?= isset($file_type_icon[$mime_type]) ? $file_type_icon[$mime_type] : $defult_path ?> fa-2x text-warning" aria-hidden="true"></i></td>
                                <td class="column-2"><?= $file ?></td>
                                <td class="column-3"><?= strtoupper($mime_type) ?></td>
                                <td class="column-4"><?= isset($mime_types[$mime_type]) ? $mime_types[$mime_type] : "" ?></td>
                                <td class="column-5"><?= $filedate ?></td>
                                <td class="column-6"><?= $filetime ?></td>
                                <td style="direction: rtl;" class="column-7 text-rose"><?= Hajm($filesize) ?></td>
                                <td class="column-8"><a target="_blank" href="<?= $path . "/" . $file ?>" class="btn btn-outline-success btn-sm btn-block" role="button" rel="noopener noreferrer">دانلود</a></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
