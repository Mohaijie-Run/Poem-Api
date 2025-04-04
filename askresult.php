<?php
    // 设置规则头
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/xml; charset=utf-8');
    $response = '<?xml version="1.0" encoding="UTF-8"?><response>';

    // 开始判断返回
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['poem'])) {
        $url = $_GET['poem'];
        if (preg_match('/https:\/\/www\.gushiwen\.cn\/shiwenv_[a-zA-Z0-9]+\.aspx/', $url)) {
            $html = file_get_contents($url);
            $dom = new DOMDocument;
            libxml_use_internal_errors(true);
            $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_clear_errors();
            $h1Elements = $dom->getElementsByTagName('h1');
            if ($h1Elements->length > 0) {
                $response .= '<title>' . htmlspecialchars($h1Elements->item(0)->textContent) . '</title>';
            }
            $divs = $dom->getElementsByTagName('div');
            foreach ($divs as $div) {
                if ($div->getAttribute('class') == 'contson') {
                    $content = $div->nodeValue;
                    $content = preg_replace('/\s+/', ' ', $content);
                    $content = trim($content);
                    $lines = explode('。', $content);
                    foreach ($lines as $line) {
                        $line = trim($line);
                        if (!empty($line)) {
                            if (substr($line, -1) !== '。') {
                                $line .= '。';
                            }
                            $response .= '<line>' . htmlspecialchars($line) . '</line>';
                        }
                    }
                    break;
                }
            }
            if (empty($response)) {
                $response .= '<error><message>未找到诗文内容</message></error>';
            }
        } else {
            $response .= '<error><message>该诗文链接无效</message></error>';
        }
    } else {
        $response .= '<error><message>请提供诗文链接</message></error>';
    }

    // 返回结束的标志
    $response .= '</response>';
    echo $response;
?>
