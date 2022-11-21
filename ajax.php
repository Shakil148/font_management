<?php
$action = $_REQUEST['action'];
// echo $action;
if (!empty($action)) {
    require_once 'includes/Font.php';
    $obj = new Font();
}
if ($action=="getfonts" | $action=="getfontgroups") {
    require_once 'includes/TTFInfo.php';
    $ex = new TTFInfo();
}
$tableFont = 'fonts';
$tableGroup = 'font_groups';
$groupDetails = 'group_details';

if ($action == 'addfont' && !empty($_POST)) {
    $font_file = $_FILES['font'];
    // file upload
    $fontname = '';
    if (!empty($font_file['name'])) {
        $fontname = $obj->uploadPhoto($font_file);
        $font_name = explode(".",$font_file['name']);
        $fontData = [
            'font_name' => $font_name[0],
            'font_file' => $fontname,
        ];
    }

    $fontId = $obj->add($fontData,$tableFont);

    if (!empty($fontId)) {
        $font = $obj->getRow('id', $fontId, $tableFont);
        echo json_encode($font);
        exit();
    }
}
if ($action == "getfonts") {

    $fonts = $obj->getAllRows($tableFont);
    if (!empty($fonts)) {
        foreach($fonts as $key => $font){
            $ttfInfo    = $ex->setFontFile('assets/uploads/'.$font['font_file']);
            $fontInfo   = $ttfInfo->getFontInfo();

            $postscript = $fontInfo[TTFInfo::NAME_POSTSCRIPT_NAME];
            $full_name  = $fontInfo[TTFInfo::NAME_FULL_NAME];
            $family     = $fontInfo[TTFInfo::NAME_NAME];
            $sub_family = $fontInfo[TTFInfo::NAME_SUBFAMILY];
            $fonts[$key]['full_name'] = $full_name;
            $fonts[$key]['family'] = $family;
        }
        $fontslist = $fonts;
    } else {
        $fontslist = [];
    }
    $fontArr = ['fonts' => $fontslist];
    echo json_encode($fontArr);
    exit();
}
if ($action == "getfontgroups") {
    $fonts = $obj->getAllRows($tableGroup);
    if (!empty($fonts)) {
        $groupId = "";
        foreach($fonts as $key => $val){
            $font = "";
            $fontDetails = $obj->getAllRowsWitnCon($groupDetails,$val['id'],'group_id');
            foreach($fontDetails as $value){
                $file       = $obj->getRow('id', $value['font'], $tableFont);
                // print_r($file);
                $ttfInfo    = $ex->setFontFile('assets/uploads/'.$file['font_file']);
                $fontInfo   = $ttfInfo->getFontInfo();
                $full_name  = $fontInfo[TTFInfo::NAME_FULL_NAME];
                $font .= $full_name.",";
            }
            $fonts[$key]['fonts'] = trim($font,",");
            $fonts[$key]['total'] = count($fontDetails);
        }
        $fontslist = $fonts;
    } else {
        $fontslist = [];
    }
    $fontArr = ['fonts' => $fontslist];
    echo json_encode($fontArr);
    exit();
}
if ($action == "getallfonts") {

    $fonts = $obj->getAllRows($tableFont);
    if (!empty($fonts)) {
        foreach($fonts as $key => $font){
            $ttfInfo    = $ex->setFontFile('assets/uploads/'.$font['font_file']);
            $fontInfo   = $ttfInfo->getFontInfo();

            $postscript = $fontInfo[TTFInfo::NAME_POSTSCRIPT_NAME];
            $full_name  = $fontInfo[TTFInfo::NAME_FULL_NAME];
            $family     = $fontInfo[TTFInfo::NAME_NAME];
            $sub_family = $fontInfo[TTFInfo::NAME_SUBFAMILY];
            $fonts[$key]['full_name'] = $full_name;
            $fonts[$key]['family'] = $family;
        }
        $fontslist = $fonts;
    } else {
        $fontslist = [];
    }
    $fontArr = ['fonts' => $fontslist];
    echo json_encode($fontArr);
    exit();
}

if ($action == "deletefont") {
    $fontId = (!empty($_GET['id'])) ? $_GET['id'] : '';
    if (!empty($fontId)) {
        $isDeleted = $obj->deleteRow($fontId, $tableFont, 'id');
        if ($isDeleted) {
            $message = ['deleted' => 1];
        } else {
            $message = ['deleted' => 0];
        }
        echo json_encode($message);
        exit();
    }
}
if ($action == "deletefontgroup") {
    $fontId = (!empty($_GET['id'])) ? $_GET['id'] : '';
    if (!empty($fontId)) {
        $isDeleted = $obj->deleteRow($fontId, $tableGroup, 'id');
        $isGroupDeleted = $obj->deleteRow($fontId, $groupDetails, 'group_id');
        if ($isDeleted && $isGroupDeleted) {
            $message = ['deleted' => 1];
        } else {
            $message = ['deleted' => 0];
        }
        echo json_encode($message);
        exit();
    }
}
if ($action == 'add_font_group' && !empty($_POST)) {
    $group_title = $_POST['group_title'];
    $font_name = $_POST['font_name'];
    $font_list = $_POST['font_list'];
    $groupId = (!empty($_POST['font_group_id'])) ? $_POST['font_group_id'] : '';

    if(empty($group_title) | count($font_name)<2 | count($font_list)<2){
        echo "Please provide required data";
        exit;
    }
    $groupData = [
        'group_name' => $group_title,
    ];

    $groupId = $obj->add($groupData, $tableGroup);
    
    if (!empty($groupId)) {
        for($i=0;$i<count($font_list); $i++){
            $groupDetailsData = [
                'group_id' => $groupId,
                'font_name' => $font_name[$i],
                'font' => $font_list[$i],
            ];
            $groupDetailsId = $obj->add($groupDetailsData, $groupDetails);
        }
    }
    if (!empty($groupId) & !empty($groupDetailsId)) {
        $group = $obj->getBothRow('id', $groupId);
        echo json_encode($group);
        exit();
    }
}
