<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Share extends CI_Controller {

	public function free()
	{
        if(!is_cli()) {
            die("不是命令行执行");
        }

        $file_lock = "share_free_lock";
        if(file_exists($file_lock)) {
            die($file_lock."文件存在");
        }else {
            file_put_contents($file_lock, Date("Y-m-d H:i:s", time()));
        }

        $this->load->model("User_model");
        $this->load->model("Share_model");
        $shares = $this->Share_model->get_by_status(0);

        foreach($shares as $share) {
            if($share->frozen >= $share->free + $share->interval) {
                $user_detail = $this->User_model->detail($share->user_id);
                $user_detail->share_free += $share->interval;
                $user_detail->share_frozen -= $share->interval;
                $this->User_model->detail_update($user_detail);

                $share->free += $share->interval;
                if($share->free >= $share->frozen) {
                    $share->status = 1;
                }

                $this->Share_model->share_update($share);

                $share_record = array();
                $share_record['user_id'] = $share->user_id;
                $share_record['num'] = $share->interval;
                $share_record['type'] = 2;
                $share_record['note'] = $share->id;
                $share_record['created_at'] = time();
                $this->Share_model->share_record($share_record);
            }
        }

        unlink($file_lock);
	}


}
