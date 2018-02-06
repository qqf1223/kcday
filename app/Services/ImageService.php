<?php
/**
 * Created by PhpStorm.
 * User: qinqinfeng
 * Date: 17/8/23
 * Time: 下午7:46
 */

namespace App\Services;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\URL;


class ImageService extends KcService
{
    public function uploadAvatar($file, $avatar_data=null)
    {
        if(! $file->isValid()) {
            return $this->handleError('无效文件');
        }
        $originalName = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $realPath = $file->getRealPath();
        $type = $file->getClientMimeType();

        $filename = md5($originalName);
        $manager = new ImageManager();
        $img = $manager->make($realPath);

        if(isset($avatar_data)){
            $imgW = (int)$avatar_data->width;
            $imgH = (int)$avatar_data->height;
            $x = (int)$avatar_data->x;
            $y = (int)$avatar_data->y;
            $img->rotate($avatar_data->rotate)->crop($imgW, $imgH, $x,$y);
        }
        $img->resize(64,64);
        $newfilename = $filename.'.'.$ext;
        $filePath = public_path('avatar/') . $newfilename;
        $img->save($filePath);
        return $this->handleSuccess('操作成功', ['url'=>URL::asset('avatar/' . $filename.'.'.$ext), 'filename' => $newfilename,'msg'=>'ok']);
    }
}