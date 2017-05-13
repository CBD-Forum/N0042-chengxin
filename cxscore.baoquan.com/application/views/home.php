<!DOCTYPE html>
<html>
  <head>
    <title>首页</title>
    <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

<meta name="description" content="Write an awesome description for your new site here. You can edit this line in _config.yml. It will appear in your document head meta (for Google search results) and in your feed.xml site description.
">

<link rel="stylesheet" href="./static/lib/weui.min.css">
<link rel="stylesheet" href="./static/css/jquery-weui.css">
<link rel="stylesheet" href="./static/css/demos.css">
<link rel="stylesheet" href="./static/css/weui.css"/>

    <style>
      .swiper-container {
        width: 100%;
      } 

      .swiper-container img {
        display: block;
        width: 100%;
      }
      .no-ceritify{
        margin-top: 10px;
        background: #eadada;
      }

      .no-ceritify img{
        display: block;
        width: 40%;
        height: 40%;
        padding-top: 10px;
        margin: 0 auto;
      }
      .no-ceritify p{
        margin-top: 10px;
        font-size: 16px;
        color: white;
        text-align: center; 
      }
      .no-ceritify-btn button{

        width:140px;
        height:40px;
        line-height:40px;
        text-align:center;
        color:#fff;
        border:none;
        border-radius:8px;
        background:#086bd0;
        display: block;
        margin: 0 auto;
      }
      .no-ceritify-btn{
        margin-top: 10px;
        padding-bottom: 10px;
      }
      .partner{
        margin-top: 10px;
        overflow: hidden;  
      }
      .partner button{
        width:240px;
        height:40px;
        line-height:40px;
        text-align:center;
        color:#fff;
        border:none;
        border-radius:8px;
        background:#558dcc;
        display: block;
        margin: 0 auto;
      }

      .corporate-logo {
        display: flex;
        margin: 20px auto;
        margin-right: -20px;   
        font-size: 0;
      }

      .item {
        display: inline-block;   
        vertical-align: top;   
        font-size: 16px;   
        height: 100px;   
        width: calc(25% - 20px);   
        margin-right: 20px; 
      }
    </style>
  </head>

  <body ontouchstart>
    <div>
    <div class="swiper-container">
      <!-- Additional required wrapper -->
      <div class="swiper-wrapper">
        <!-- Slides -->
        <div class="swiper-slide"><img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1493892988&di=98a327620f0c28de09808380edfbbb45&imgtype=jpg&er=1&src=http%3A%2F%2Fpic24.nipic.com%2F20121006%2F8733453_203133518000_2.jpg" /></div>
        <div class="swiper-slide"><img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1493298273418&di=a09dbcd34a97c0a0f84d42d20fe0d2c8&imgtype=0&src=http%3A%2F%2Fpic.58pic.com%2F58pic%2F15%2F63%2F79%2F12P58PICs3X_1024.jpg" /></div>
        <div class="swiper-slide"><img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1493298322216&di=1a114a839483e40f4fa3b89d9965947c&imgtype=0&src=http%3A%2F%2Fpic31.nipic.com%2F20130802%2F13331903_051110199000_2.jpg" /></div>
      </div>
      <!-- If we need pagination -->
      <div class="swiper-pagination"></div>
    </div>
    <!-- 未认证 -->
    <div class="no-ceritify">
      <img src="https://ss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=2745685655,4075825738&fm=23&gp=0.jpg" />
      <p>暂时没有数据</p>
      <div class="no-ceritify-btn"><button type="button" id="go-to-ceritify">立即查看</button></div>
    </div>
    <!-- 已认证 -->
    <!-- <div class="weui-cells_title" style="width: 100%;background: #ecd0d0;margin-top: 10px;font-size:16px;color:red;">
      <span>证书信息</span><span style="float:right;margin-right:45px;">展开</span>
    </div>
    <div class="weui-cells" style="width: 100%;background: #f9f3f3;margin-top: -5px">
      <div class="weui-cell">
        <div class="weui-cell__hd"><img src="./static/images/baoquan_logo.png" alt="" style="width:40px;height:40px;margin-right:5px;display:block"></div>
        <div class="weui-cell__bd" style="margin-left:10px;">
          <p>浙江数秦科技有限公司</p>
        </div>
        <div class="weui-cell__ft"><a href="">查看详情</a></div>
      </div>
      <div class="weui-cell">
        <div class="weui-cell__bd">
          <p>企业评分</p>
        </div>
        <div class="weui-cell__ft">120</div>
      </div>
      <div class="weui-cell">
        <div class="weui-cell__bd">
          <p>网站域名</p>
        </div>
        <div class="weui-cell__ft">www.baoquan.com</div>
      </div>
      <div class="weui-cell">
        <div class="weui-cell__bd">
          <p>证书编号</p>
        </div>
        <div class="weui-cell__ft">BQ2017011248975499</div>
      </div>
      <div class="weui-cell">
        <div class="weui-cell__bd">
          <p>证书有效期</p>
        </div>
        <div class="weui-cell__ft">2017-04-14~2018-04-14</div>
      </div>
    </div>
 -->
    <!-- 合作伙伴 -->
    <div class="partner">
      <button type="button">合作伙伴</button>
      <div class="corporate-logo">
          <div class="item" >
            <a href="http://www.zjmax.com" target="_blank">
              <img src="http://chengxin-public.oss-cn-shanghai.aliyuncs.com/chengxin_rz/148938385320135d2fe276bf1497097ec500812128e9f78e3173c505c5344839192e1cc325101b.png" width="80px"  />
            </a>
          </div>
          <div class="item">
            <a href="http://www.suanlibao.com" target="_blank">
              <img src="http://chengxin-public.oss-cn-shanghai.aliyuncs.com/chengxin_rz/148938394316633472ed813a803dd9d801fc1f4312f588ef59b7a2babec21dab7d0a4010a840c45.svg" width="80px" />
            </a>
          </div>
          <div class="item">
            <a href="https://www.qian360.com" target="_blank">
              <img src="http://chengxin-public.oss-cn-shanghai.aliyuncs.com/chengxin_rz/149282445615368b46ac010ad53775e7bc91715cce4882c7f6a339ca60ba956a664f2717725d83a.png" width="80px" />
            </a>
          </div>
          <div class="item">
            <a href="http://www.qbm360.com/" target="_blank">
              <img src="http://chengxin-public.oss-cn-shanghai.aliyuncs.com/chengxin_rz/14928245631121132c575d30e81fe404ce2592ed830937b2adb8b59e749511b306ce4a1c45a99a0.png" width="80px" />
            </a>
          </div>
      </div>
    </div> 

    </div>
   <?php $this->load->view('public/tabbar.php')?>
    <script src="./static/lib/jquery-2.1.4.js"></script>
    <script src="./static/lib/fastclick.js"></script>
    <script>
      $(function() {
        FastClick.attach(document.body);
      });
    </script>
    <script src="./static/js/jquery-weui.js"></script>

        <script src="./static/js/swiper.js"></script>

        <script>
          $(".swiper-container").swiper({
            loop: true,
            autoplay: 3000
          });
        </script>
  </body>
</html>
