<?
    require_once($_SERVER['DOCUMENT_ROOT'].'/include/database.php');
    
    
    $userName = isset($_REQUEST['user'])?htmlspecialchars($_REQUEST['user']):'';
    $msg = isset($_REQUEST['msg'])?htmlspecialchars($_REQUEST['msg']):'';
    $imNotRobot = isset($_REQUEST['imNotRobot'])?htmlspecialchars($_REQUEST['imNotRobot']):'';
    
    if($imNotRobot == 'Y' && $userName!='' && $msg!=''){
        $dateadd=date("Y-m-d H:i:s ");
        if($dbWorker->query("INSERT INTO questbook VALUES(NULL,'$userName','','$msg','$dateadd',0)"))
            echo 'true';
        else
            echo 'false';
    }else{
        echo 'false';
    }
    
?>