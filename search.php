<?php
    // 设置规则头
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/xml; charset=utf-8');
    $response = '<?xml version="1.0" encoding="UTF-8"?><response>';

    // 开始判断返回
    if (isset($_GET['type']) && !empty($_GET['type'])) {
        $type = urlencode($_GET['type']);
        $url = 'https://www.gushiwen.cn/shiwen2017/ajaxSearchSoD.aspx?valuekey=' . $type;
        $ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$htmlContent = curl_exec($ch);
        curl_close($ch);
        if ($htmlContent) {
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($htmlContent);
            libxml_clear_errors();
            $xpath = new DOMXPath($dom);
            $baseUrl = 'https://www.gushiwen.cn';
            $mainDivs = $xpath->query('//div[@class="main"]');
            foreach ($mainDivs as $mainDiv) {
                $poetrySpan = $xpath->query('.//span[text()="诗文"]', $mainDiv);
                if ($poetrySpan->length > 0) {
                    $adivElements = $xpath->query('.//div[@class="adiv"]', $mainDiv);
                    foreach ($adivElements as $element) {
                        $link = $element->getElementsByTagName('a')->item(0);
                        if ($link) {
                            $title = trim($link->nodeValue);
                            $href = $link->getAttribute('href');
                            $href = $baseUrl . $href;
                            $response .= '<poem ofetch="' . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') . '">' 
                                       . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') 
                                       . '</poem>';
                        }
                    }
                }
            }
        } else {
            $response .= '<error><message>无法连接服务器</message></error>';
        }
    } else {
        $response .= '<error><message>请提供诗文标题</message></error>';
    }
    
    // 返回结束的标志
    $response .= '</response>';
    echo $response;
?>
