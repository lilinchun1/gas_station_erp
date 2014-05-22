<?php
//上传类
class UploadAction extends Action{
	public function index(){
	    $this->display("upload");
	}

    //用户上传图片
    public function upload(){
		import('ORG.Net.UploadFile');
		//p($_FILES);
		$upload = new UploadFile();// 实例化上传类
		$upload->maxSize  = 1048576 ;// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$filepath = "../data/";
		if(!file_exists($filepath))
		{
			mkdir($filepath);
		}
		$filepath = "../data/";
		if(!file_exists($filepath))
		{
            mkdir($filepath);
		}
		$filepath = "../data/" . date('Y') . "/";
		if(!file_exists($filepath))
		{
            mkdir($filepath);
		}
		$filepath = "../data/" . date('Y') . "/" . date('m') . "/";
		if(!file_exists($filepath))
		{
            mkdir($filepath);
		}
		$filepath = "../data/" . date('Y') . "/" . date('m') . "/" . date('d') . "/";
		if(!file_exists($filepath))
		{
            mkdir($filepath);
		}
		$upload->savePath=$filepath;// 设置附件上传目录
		$upload->saveRule=uniqid;//上传文件的文件名保存规则
        //$upload->uploadReplace=true;//如果存在同名文件是否进行覆盖
        //$upload->allowTypes=array('image/png','image/jpg','image/jpeg','image/gif');//检测mime类型
        //$upload->thumb=true;//是否开启图片文件缩略图
        //$upload->thumbMaxWidth='300,500';
        //$upload->thumbMaxHeight='200,400';
        //$upload->thumbPrefix='s_,m_';//缩略图文件前缀
        //$upload->thumbRemoveOrigin=1;//如果生成缩略图，是否删除原图

		if(!$upload->upload()) {// 上传错误提示错误信息
			$this->error($upload->getErrorMsg());
		}
		$info = $upload->getUploadFileInfo();
		$filepath = "data/" . date('Y') . "/" . date('m') . "/" . date('d') . "/";
		$filepath =  $filepath . $info[0]['savename'];

		//p($allfilepath);
		return $filepath;
    }
}
?>