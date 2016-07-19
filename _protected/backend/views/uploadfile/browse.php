<?php

$filesizefinal = 0;
$count = 0;
for($i=count($files)-1; $i >= 0; $i--):
$image = $files[$i];
$image_pathinfo = pathinfo($image);
$image_extension = $image_pathinfo['extension'];
$image_filename = $image_pathinfo['filename'];
$image_basename = $image_pathinfo['basename'];

// image src/url
$protocol = !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
$site = $protocol. $_SERVER['SERVER_NAME'] .'/';

$image_url = Yii::$app->homeUrl."uploads/ckeditor/".$image_basename;

$size = getimagesize($image);
$image_height = $size[0];
$file_size_byte = filesize($image);
$file_size_kilobyte = ($file_size_byte/1024);
$file_size_kilobyte_rounded = round($file_size_kilobyte,1);
$filesizetemp = $file_size_kilobyte_rounded;
$filesizefinal = round($filesizefinal + $filesizetemp) . " KB";
$calcsize = round($filesizefinal + $filesizetemp);
$count = ++$count;

 ?>
<div class="fileDiv"
     onclick="showUseBar(this);" onmouseover="showUseBar(this)"
     ondblclick="showImage('<?php echo $image_url; ?>','<?php echo $image_height; ?>','<?php echo $image_basename; ?>');"
     data-imgid="<?php echo $count; ?>">
    <div class="imgDiv"><img class="fileImg lazy" data-original="<?php echo $image_url; ?>"></div>
    <p class="fileDescription"> <?php echo $image_filename; ?><?php echo '.'.$image_extension; ?></p>
    <p class="fileTime"><?php echo date ("M d Y", filemtime($image)); ?><i><?php echo $filesizetemp; ?> KB</i></p>
    <span onclick="useImage('<?php echo $image_url; ?>')">use this image</span>
</div>

<?php
endfor;
if(!$count){
?>
   <h1>No Images are found. Please upload images to use</h1>
<?php
}