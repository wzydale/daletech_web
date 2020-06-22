<?php

$file = $_FILES['file'];
if (is_uploaded_file($file['tmp_name']))
{
        $extension = pathinfo($file['name'])['extension'];
        $imgname = time().rand(100,1000).'.'.$extension;
        if (move_uploaded_file($file['tmp_name'], $imgname))
        {
                $data  = array
                (
                        'scene' => 'aeMessageCenterV2ImageRule',
                        'name' =>$imgname,
                        'file' => new \CURLFile(realpath($imgname))
                );
                $res = json_decode(icurl('https://kfupload.alibaba.com/mupload',$data));
                @unlink($imgname);
                if ($res->msg == 0)
                {
                        echo json_encode($res);
                }
        }
}


function icurl($url, $data){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
}