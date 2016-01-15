<?php
    $filename = null;
    $Foreground = null;
    $Background = null;
    require_once 'PHPWord.php';
    session_start();
    $Foreground = $_SESSION['SaveImageToDocForeground'];
    $Background =$_SESSION['SaveImageToDocBackground'];
    $filename = "Ταυτότητα πρωσωπικού - ".$_SESSION["SurnameOfEmployee"]." ".$_SESSION["NameOfEmployee"].".docx";
    
    // New Word Document
    $PHPWord = new PHPWord();

    // New portrait section
    $section = $PHPWord->createSection();

    // Add image elements
    $section->addImage($Foreground, array('width'=>363, 'height'=>242, 'align'=>'center'));
$section = $PHPWord->createSection();
$section->addImage($Background,array('width'=>363, 'height'=>242, 'align'=>'center'));
    
    // Save File
    $objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
    $objWriter->save($filename);

    header('Content-Description: File Transfer');
    header("Content-Type: application/octet-stream charset='utf-8'");
    header('Content-Disposition: attachment; filename='.$filename);
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filename));
    flush();
    readfile($filename);
    unlink($filename); // deletes the temporary file
?>
