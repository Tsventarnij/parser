<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use App\Http\Controllers\Controller;

class LinkFollow extends Controller
{
    /**
     * Show the form for parse data.
     *
     *
     * @return Response
     */
    public function index()
    {
        return view('LinkFollow');
    }

    public function show(Request $request)
    {

        if (!$request->has(['domain', 'links'])) {
            return view('LinkFollow');
        }

//        $links = explode(PHP_EOL, $request->input('links', ''));
        $links = preg_split("/\R/", $request->input('links', ''));
        $domain = $request->input('domain', '');
        $result = [];

        foreach ($links as $link){

            $html = file_get_contents(rtrim($link, PHP_EOL));
            $crawler = new Crawler(null, $link);
            $crawler->addHtmlContent($html, 'UTF-8');

            $crawler->filter('a')->each(function (Crawler $node) use (&$result, $link, $domain) {
                if(preg_match('/^(https?:\/\/)?(([\w\.]+)\.)?('.$domain.')\/?$/', $node->attr('href'))){

                    $result[$link] = [
                        'link' =>  $link,
                        'domain' => $domain,
                        'exist' => true,
                        'dofollow' => strpos($node->attr('rel'), 'nofollow') === false
                    ];
                }
            });
            if(!array_key_exists($link, $result)){
                $result[$link] = [
                    'link' =>  $link,
                    'domain' => $domain,
                    'exist' => false,
                    'dofollow' => false
                ];
            }
        }

        return view('LinkFollow', ['result' => $result]);
    }
}