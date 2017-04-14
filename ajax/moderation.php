<?
require_once($_SERVER['DOCUMENT_ROOT'].'/include/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/include/settings.php');

if(!$isAdmin){
    echo 'false';
    die();
}

$status = 'false';
if($isAdmin){
    switch($_REQUEST['action']) {
        case 'pmf_remove': {
            $id = intval($_REQUEST['id']);
            if ($id > 0) {
                $rm_file = $dbWorker->prepare('DELETE FROM pm_files WHERE pmfileid = ?');
                if ($rm_file->execute(array($id)))
                    $status = 'true';
            }
            break;
        }
        case 'pmf_ok': {
            $id = intval($_REQUEST['id']);
            if ($id > 0) {
                //получим данные о материале на премодерации
                $pmMaterial = $dbWorker->prepare("SELECT * FROM pm_files WHERE pmfileid = ?");
                $pmMaterial->execute(array($id));
                $pmMaterial = $pmMaterial->fetch();

                //получим данные о предмете
                $pmPredmet = array();
                if(intval($pmMaterial['pmfilepredmetid'])>0){
                    $pmPredmet = $dbWorker->prepare("SELECT * FROM predmets WHERE id = ?");
                    $pmPredmet->execute(array($pmMaterial['pmfilepredmetid']));
                    $pmPredmet = $pmPredmet->fetch();

                    //получим данные о файле
                    $pmFile = $dbWorker->prepare("SELECT * FROM uploads WHERE link = ?");
                    $pmFile->execute(array($pmMaterial['pmfilename']));
                    $pmFile = $pmFile->fetch();

                    if($pmFile['link']!='') {
                        $newFilePath = "/materials/semestr_" . $pmPredmet['semestr'] . "/" . $pmPredmet['title_predmet_english'];//.$pmFile['file_name'];
                        $oldPath = "/files/storage/" . $pmFile['link'];

                        //переместим файл
                        if (!is_dir($_SERVER['DOCUMENT_ROOT'] .$newFilePath))
                            mkdir($_SERVER['DOCUMENT_ROOT'].$newFilePath, 0777, true);

                        if(copy($_SERVER['DOCUMENT_ROOT'] . $oldPath, $_SERVER['DOCUMENT_ROOT'] . $newFilePath . '/' . $pmFile['file_name'])){
                            //добавим материал
                            $dateAdd = date("Y-m-d H:i:s");
                            $insertMaterial = $dbWorker->prepare("INSERT INTO materials VALUES(NULL,?,?,?,?,?,0,?)");
                            if ($insertMaterial->execute(array(
                                $pmMaterial['pmfiletitle'],
                                $pmMaterial['pmfilemetakey'],
                                $pmMaterial['pmfilepredmetid'],
                                $newFilePath . '/' . $pmFile['file_name'],
                                $pmFile['file_size']/1024,
                                $dateAdd))
                            ) {
                                $status = 'true';

                                //удалим материал с файлообменника
                                if (is_file($_SERVER['DOCUMENT_ROOT'] . $oldPath))
                                    unlink($_SERVER['DOCUMENT_ROOT'] . $oldPath);

                                $deleteFile = $dbWorker->prepare("DELETE FROM uploads WHERE link = ?");
                                $deleteFile->execute(array($pmFile['link']));

                                $deleteFile = $dbWorker->prepare("DELETE FROM pm_files WHERE pmfileid = ?");
                                $deleteFile->execute(array($id));
                            }
                        }else{
                            $status = 'move file fail';
                        }
                    }
                }
            }
            break;
        }
        default:
            break;
    }
}
echo $status;