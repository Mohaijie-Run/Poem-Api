<?php
    // 允许所有和设置格式与初始化
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: text/plain; charset=utf-8');
    $response = "";

    // 检查参数并检查网页爬取
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['poem'])) {
        $url = $_GET['poem'];
        if (preg_match('/https:\/\/www\.gushiwen\.cn\/shiwenv_[a-zA-Z0-9]+\.aspx/', $url)) {
            // 获取诗文网页代码
            $html = file_get_contents($url);
            $dom = new DOMDocument;
            libxml_use_internal_errors(true);
            $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_clear_errors();

            // 提取标题
            $h1Content = "";
            $h1Elements = $dom->getElementsByTagName('h1');
            if ($h1Elements->length > 0) {
                $h1Content = "<div class='title'>" . htmlspecialchars($h1Elements->item(0)->textContent) . "</div>";
            }

            // 提取诗文内容
            $divs = $dom->getElementsByTagName('div');
            foreach ($divs as $div) {
                if ($div->getAttribute('class') == 'contson') {
                    // 获取原始内容
                    $content = $div->nodeValue;
                    
                    // 移除空白的字符
                    $content = preg_replace('/\s+/', ' ', $content);
                    $content = trim($content);
                    
                    // 按句分割诗文
                    $lines = explode('。', $content);
                    foreach ($lines as $line) {
                        $line = trim($line);
                        if (!empty($line)) {
                            // 确保都是以句号结尾
                            if (substr($line, -1) !== '。') {
                                $line .= '。';
                            }
                            // 创建新的DIV元素
                            $response .= "<div class='segment'>" . $line . "</div>";
                        }
                    }
                    break;
                }
            }

            // 检查是否成功提取内容
            if (empty($response)) {
                $response = "<div class='tips'>未找到诗文内容</div>";
            } else {
                $response = $h1Content . $response;
            }
            echo $response;
        } else {
            echo "<div class='tips'>该诗文链接无效</div>";
        }
    } else {
        echo "<div class='tips'>请提供诗文链接</div>";
    }
?>
