<?php

error_reporting(E_ALL | E_STRICT);
//require('UploadHandler.php');
//$upload_handler = new UploadHandler();
$error = '';
$max_file_size = 268435456;//256 Mb
$max_files_count = 8;
$count_files = 1;
$upload_dir = dirname(@$_SERVER['SCRIPT_FILENAME']).'/files/';


post();

function post($print_response = true) {
    global $count_files;

    $upload = @$_FILES['files'];
    // Parse the Content-Disposition header, if available:
    $content_disposition_header = @$_SERVER['HTTP_CONTENT_DISPOSITION'];
    $file_name = $content_disposition_header ?
        rawurldecode(preg_replace(
            '/(^[^"]+")|("$)/',
            '',
            $content_disposition_header
        )) : null;
    // Parse the Content-Range header, which has the following form:
    // Content-Range: bytes 0-524287/2000000
    $content_range_header = @$_SERVER['HTTP_CONTENT_RANGE'];
    $content_range = $content_range_header ?
        preg_split('/[^0-9]+/', $content_range_header) : null;
    $size =  $content_range ? $content_range[3] : null;
    $files = array();
    if ($upload) {
        if (is_array($upload['tmp_name'])) {
            $count_files = count($upload['tmp_name']);
            // param_name is an array identifier like "files[]",
            // $upload is a multi-dimensional array:
            foreach ($upload['tmp_name'] as $index => $value) {
                $files[] = handle_file_upload(
                    $upload['tmp_name'][$index],
                    $file_name ? $file_name : $upload['name'][$index],
                    $size ? $size : $upload['size'][$index],
                    $upload['type'][$index],
                    $upload['error'][$index],
                    $content_range
                );
            }
        } else {
            // param_name is a single object identifier like "file",
            // $upload is a one-dimensional array:
            $files[] = handle_file_upload(
                isset($upload['tmp_name']) ? $upload['tmp_name'] : null,
                $file_name ? $file_name : (isset($upload['name']) ?$upload['name'] : null),
                $size ? $size : (isset($upload['size']) ? $upload['size'] : @$_SERVER['CONTENT_LENGTH']),
                isset($upload['type']) ? $upload['type'] : @$_SERVER['CONTENT_TYPE'],
                isset($upload['error']) ? $upload['error'] : null,
                $content_range
            );
        }
    }
    generate_response(array('files' => $files), $print_response);
}
function handle_file_upload($uploaded_file, $name, $size, $type, $local_error, $content_range = null) {
    global $error;
    $error.=$local_error;

    $file = new \stdClass();
    $file->name = get_file_name($name);
    $file->size = (int)$size;
    $file->type = $type;
    if (validate($uploaded_file, $file)) {
        $upload_dir = get_upload_path();
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, '0644', true);
        }
        $file_path = get_upload_path($file->name);
        $append_file = $content_range && is_file($file_path) &&
            $file->size > filesize($file_path);
        if ($uploaded_file && is_uploaded_file($uploaded_file)) {
            // multipart/formdata uploads (POST method uploads)
            if ($append_file) {
                file_put_contents(
                    $file_path,
                    fopen($uploaded_file, 'r'),
                    FILE_APPEND
                );
            } else {
                move_uploaded_file($uploaded_file, $file_path);
            }
        } else {
            // Non-multipart uploads (PUT method support)
            file_put_contents(
                $file_path,
                fopen('php://input', 'r'),
                $append_file ? FILE_APPEND : 0
            );
        }
        $file_size = filesize($file_path);
        if ($file_size === $file->size) {
            //$file->url = get_download_url($file->name);
            $file->url = $file->name.'_download';
        } else {
            $file->size = $file_size;
            if (!$content_range) {
                unlink($file_path);
                $error .= 'abort';
            }
        }
    }
    return $file;
}
//генерация уникального md5 хэша файла
function get_file_name($_name) {
    $name = autoencode($_name);
    $name = latinstring($name);
    $name = preg_replace("/[^a-zA-Z0-9\-_\.]/","",$name);
    if($name == '')
        $name = md5($_name);
    return $name;
}
//проверка файла на соответствие требованиям
function validate($uploaded_file, $file) {
    global $error;
    global $max_file_size;
    global $max_files_count;
    global $count_files;

    $content_length = (int)@$_SERVER['CONTENT_LENGTH'];
    $post_max_size = get_config_bytes(ini_get('post_max_size'));
    if ($post_max_size && ($content_length > $post_max_size)) {
        $error = 'post_max_size';
        return false;
    }
    if ($uploaded_file && is_uploaded_file($uploaded_file)) {
        $file_size = filesize($uploaded_file);
    } else {
        $file_size = $content_length;
    }
    if ($max_file_size && (
            $file_size > $max_file_size ||
            $file->size > $max_file_size)
    ) {
        $error = 'max_file_size';
        return false;
    }

    if (is_int($max_files_count) &&
        ($count_files >= $max_files_count) &&
        // Ignore additional chunks of existing files:
        !is_file(get_upload_path($file->name))) {
        $error = 'max_number_of_files';
        return false;
    }
    return true;
}
//получает из конфига пхп максимальный размер файла для загрузки
function get_config_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last) {
        case 'g':
            $val *= 1024*1024*1024;
            break;
        case 'm':
            $val *= 1024*1024;
            break;
        case 'k':
            $val *= 1024;
    }
    return $val;
}
//получает имя папки
function get_upload_path($file_name = null) {
    global $upload_dir;
    $file_name = $file_name ? $file_name : '';
    return $upload_dir.$file_name;
}
//генерация ответа
function generate_response($content, $print_response = true) {
    $redirect_allow_target = '/^'.preg_quote(
        parse_url(@$_SERVER['HTTP_REFERER'], PHP_URL_SCHEME)
        .'://'
        .parse_url(@$_SERVER['HTTP_REFERER'], PHP_URL_HOST)
        .'/', // Trailing slash to not match subdomains by mistake
        '/' // preg_quote delimiter param
    ).'/';

    if ($print_response) {
        $json = json_encode($content);
        $redirect = stripslashes(@$_POST['redirect']);
        if ($redirect && preg_match($redirect_allow_target, $redirect)) {
            header('Location: '.sprintf($redirect, rawurlencode($json)));
            return null;
        }

        header('Pragma: no-cache');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Content-Disposition: inline; filename="files.json"');
        // Prevent Internet Explorer from MIME-sniffing the content-type:
        header('X-Content-Type-Options: nosniff');
        header('Vary: Accept');
        if (strpos(@$_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
            header('Content-type: application/json');
        } else {
            header('Content-type: text/plain');
        }

        if (@$_SERVER['HTTP_CONTENT_RANGE']) {
            $files = isset($content['files']) ?
                $content['files'] : null;
            if ($files && is_array($files) && is_object($files[0]) && $files[0]->size) {
                header('Range: 0-'.((int)$files[0]->size - 1));
            }
        }
        echo $json;
    }
    return $content;
}
// функция превода текста с кириллицы в траскрипт
function latinstring($st)
{
    // Сначала заменяем "односимвольные" фонемы.
    $st=strtr($st,"абвгдеёзийклмнопрстуфхъыэ",
        "abvgdeeziyklmnoprstufh'ie");
    $st=strtr($st,"АБВГДЕЁЗИЙКЛМНОПРСТУФХЪЫЭ",
        "ABVGDEEZIYKLMNOPRSTUFH'IE");
    // Затем - "многосимвольные".
    $st=strtr($st,
        array(
            "ж"=>"zh", "ц"=>"ts", "ч"=>"ch", "ш"=>"sh",
            "щ"=>"shch","ь"=>"", "ю"=>"yu", "я"=>"ya",
            "Ж"=>"ZH", "Ц"=>"TS", "Ч"=>"CH", "Ш"=>"SH",
            "Щ"=>"SHCH","Ь"=>"", "Ю"=>"YU", "Я"=>"YA",
            "ї"=>"i", "Ї"=>"Yi", "є"=>"ie", "Є"=>"Ye"
        )
    );
    // Возвращаем результат.
    return $st;
}

function is_utf8($string) {
    for ($i=0; $i<strlen($string); $i++) {
        if (ord($string[$i]) < 0x80) continue;
        elseif ((ord($string[$i]) & 0xE0) == 0xC0) $n=1;
        elseif ((ord($string[$i]) & 0xF0) == 0xE0) $n=2;
        elseif ((ord($string[$i]) & 0xF8) == 0xF0) $n=3;
        elseif ((ord($string[$i]) & 0xFC) == 0xF8) $n=4;
        elseif ((ord($string[$i]) & 0xFE) == 0xFC) $n=5;
        else return false;
        for ($j=0; $j<$n; $j++) {
            if ((++$i == strlen($string)) || ((ord($string[$i]) & 0xC0) != 0x80))
                return false;
        }
    }
    return true;
}
function autoencode($string, $encoding='utf-8')
{
    if (is_utf8($string)) $detect='utf-8';
    else
    {
        $cp1251=0;
        $koi8u=0;
        $strlen=strlen($string);
        for($i=0;$i<$strlen;$i++)
        {
            $code=ord($string[$i]);
            if (($code>223 and $code<256) or ($code==179) or ($code==180) or ($code==186) or ($code==191)) $cp1251++; // ?-?, ?, ?, ?, ?
            if (($code>191 and $code<224) or ($code==164) or ($code==166) or ($code==167) or ($code==173)) $koi8u++; // ?-?, ?, ?, ?, ?
        }
        if ($cp1251>$koi8u) $detect='windows-1251';
        else $detect='koi8-u';
    }
    if ($encoding==$detect) return $string;
    else return iconv($detect, $encoding, $string);
}