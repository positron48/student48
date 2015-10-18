<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/database.php');

$error = '';
$max_file_size = 268435456;//256 Mb
$max_files_count = 8;
$count_files = 1;
$upload_dir = dirname(@$_SERVER['SCRIPT_FILENAME']).'/storage/';


post();

//обрабо тка загрузки фала/фалов
function post($print_response = true) {
    global $count_files;
    global $dbWorker;
    $upload = @$_FILES['files'];
    $content_disposition_header = @$_SERVER['HTTP_CONTENT_DISPOSITION'];
    $file_name = $content_disposition_header ?
        rawurldecode(preg_replace(
            '/(^[^"]+")|("$)/',
            '',
            $content_disposition_header
        )) : null;
    $content_range_header = @$_SERVER['HTTP_CONTENT_RANGE'];
    $content_range = $content_range_header ?
        preg_split('/[^0-9]+/', $content_range_header) : null;
    $size =  $content_range ? $content_range[3] : null;
    $files = array();
    if ($upload) {
        $arr_count=0;
        foreach($upload['tmp_name'] as $key=>$value){
            $arr_count++;
        }
        $count_files = $arr_count;
        foreach ($upload['tmp_name'] as $index => $value) {
            $file = handle_file_upload(
                $upload['tmp_name'][$index],
                $file_name ? $file_name : $upload['name'][$index],
                $size ? $size : $upload['size'][$index],
                $upload['type'][$index],
                $upload['error'][$index],
                $content_range
            );
            if(is_file($_SERVER['DOCUMENT_ROOT'].'/files/storage/'.$file->name)) {
                //файл записался, все ок
                $files[] = $file;
                $dateAdd = date("Y-m-d H:i:s ");
                $dbWorker->query("INSERT INTO uploads VALUES(
                    NULL,
                    '{$file->name_eng}',
                    '{$file->name_orig}',
                    '{$file->name}',
                    0,
                    0,
                    0,
                    '{$file->size}',
                    '{$dateAdd}',
                    ''
                )");
            }
        }
    }
    generate_response(array('files' => $files), $print_response);
}
//обработка каждого файла
function handle_file_upload($uploaded_file, $name, $size, $type, $local_error, $content_range = null) {
    global $error;
    $error.=$local_error;

    $file = new \stdClass();
    $file->name_orig = $name;
    $file->name_eng = get_file_name($name);
    $file->name = get_file_link($name);
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
    $name = $_name;
    $name = translit($name);
    $name = preg_replace("/[^a-zA-Z0-9\-_\.]/","",$name);
    if($name == '')
        $name = md5($_name);
    return $name;
}
//генерация уникального md5 хэша файла
function get_file_link($file) {
    global $dbWorker;
    $link = (string)substr(md5($file.'student'),0,5);
    //проверка на уникальность в базе
    while($dbWorker->query("SELECT COUNT(*) FROM uploads WHERE link='".$link."'")->fetch()[0] > 0){
        $link = (string)substr(md5(rand().'student'),0,5);
    }
    return $link;
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

    if (($count_files >= $max_files_count)) {
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
function translit($st)
{
    $st = mb_strtolower($st);
    $st = strtr($st,array('а'=>'a', 'б'=>'b', 'в'=>'v', 'г'=>'g', 'д'=>'d', 'е'=>'e', 'ё'=>'e', 'ж'=>'zh',
        'з'=>'z', 'и'=>'i', 'к'=>'k', 'л'=>'l', 'м'=>'m', 'н'=>'n', 'о'=>'o', 'п'=>'p', 'р'=>'r', 'с'=>'s',
        'т'=>'t', 'у'=>'u', 'ф'=>'f', 'х'=>'h', 'ц'=>'c', 'ч'=>'ch', 'ш'=>'sh', 'щ'=>'sh', 'ь'=>'', 'ы'=>'y',
        'ъ'=>'', 'э'=>'e', 'ю'=>'yu', 'я'=>'ya', ' ' => '_'));
    // Возвращаем результат.
    return $st;
}