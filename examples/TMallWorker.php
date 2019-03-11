<?php
/**
 * Created by PhpStorm.
 * User: tangkeyu
 * Date: 2019-03-10
 * Time: 22:20
 */

namespace SplashPhpExamples;

use SplashPhp\Worker;
use Symfony\Component\DomCrawler\Crawler;

class TMallWorker extends Worker
{
    protected $useSplash = true;
    protected $splashHost = 'localhost';
    protected $splashPost = 8050;

    /**
     * @return array
     */
    public function getSeed(): array
    {
//        return ['https://www.tmall.com'];
        return ['https://s.taobao.com/search?q=摄像头&ie=utf8'];
    }

    protected function beforeDownload()
    {
        $this->headers['cookie'] = 'thw=cn; cna=xfEBEy1iixECAXJeQTzN4qXs; tracknick=%5Cu6D41%5Cu6C34%5Cu5BFF%5Cu53F8; tg=0; ali_ab=114.94.65.60.1525580948397.7; enc=L6Wzt2Hbuu6%2BcRXb%2ByfNQmEp56LXZYOBm8lYEGwGcO3EjeyS6D0kTPOkcKTm32fi3XFqgjKk5NE7455gLL941g%3D%3D; hng=CN%7Czh-CN%7CCNY%7C156; miid=9211451841888727334; l=aBft4935yukO2nDXzMa2NlbCC702LMBPn12Y1MamliThNspDGDn-XTto-VwW7_qC5gTy_K-5F; t=183ce4ab5e4718d75b2e3907a56848ae; lgc=%5Cu6D41%5Cu6C34%5Cu5BFF%5Cu53F8; uc3=vt3=F8dByEv1QDfr7Wxovh0%3D&id2=Vvj%2B3%2Foy&nk2=ogVYuLgkRU0%3D&lg2=Vq8l%2BKCLz3%2F65A%3D%3D; _cc_=Vq8l%2BKCLiw%3D%3D; UM_distinctid=1693d4bcd1937b-02bdf56371a79f-36667105-1fa400-1693d4bcd1a403; cookie2=34119c4eee3c0f944e0588e7e4c7583c; v=0; _tb_token_=e3d1bb0f7bd63; mt=ci=-1_0; birthday_displayed=1; alitrackid=www.taobao.com; lastalitrackid=www.taobao.com; JSESSIONID=BB2FAEF5D4DBC11FB681A42C2AB36966; uc1=cookie14=UoTZ5icHXDgWzQ%3D%3D; isg=BPDwLhXLWHW5EgTJEUHWMCXjwbiCkZHfBXWxC-pBsMsepZBPkk_uE7WX-e1gNYxb';
    }

    protected function downloadedPage(Crawler $crawler)
    {
        echo $crawler->filter('meta[charset]')->first()->attr('charset');
        echo $crawler->filter('title')->first()->text();
    }

}