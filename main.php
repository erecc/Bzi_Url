<?php

//================================= 别名检查==================================================
// 检查是否提交了表单
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 从$_POST数组中读取数据
    $txt_url= $_POST["txt_url"]; // 别名
    $new_url= $_POST["new_url"]; // 网址

// 假设这是你的变量数据
//$data = "Hello123";

// 使用正则表达式检查变量是否只包含数字与字母
if (!preg_match('/^[a-z0-9]+$/', $txt_url)) {
    // 如果没有只包含数字与字母，弹出提醒（在Web环境中，使用JavaScript alert）
    // 但注意，PHP本身不直接弹出JavaScript alert，所以这里只是输出一个HTML片段
    echo '<script type="text/javascript">alert("别名中禁止非数字与小写字母之外的字符！");</script>';
    
    echo'<script type="text/javascript">window.history.back();</script>';
exit;
    // 或者，你可以只是输出一个错误消息到页面
    // echo "数据中包含非数字与字母的字符！";
} else {
    // 如果只包含数字与字母，你可以继续你的代码逻辑
    //echo "数据只包含数字与字母。";
}

//================================= 网址检查==================================================

// 假设这是你的变量数据
//$data = "Hello, World!";

// 这是你想要检查的字符或子字符串
$searchFor = "http";

// 使用strpos()函数检查$data中是否包含$searchFor
if (strpos($new_url, $searchFor) === false) {
    // 如果没有找到，弹出提醒（在Web环境中，通常使用JavaScript的alert()）
    // 但请注意，PHP本身在服务器端运行，不能直接弹出JavaScript的alert()
    // 所以这里我们假设你正在输出HTML到浏览器，并使用JavaScript
    echo '<script type="text/javascript">alert("请输入完整的网址带上htttp://例如：http://example.com/");</script>';
    // 或者，你可以只是输出一个错误消息到页面
    // echo "没有找到指定的字符或子字符串！";
    //exit; // 如果需要，可以终止脚本的执行
    echo'<script type="text/javascript">window.history.back();</script>';
exit;
} else {
    // 如果找到了，你可以继续你的代码逻辑
    //echo "找到了指定的字符或子字符串！";
}



    // 现在你可以使用$txt_url和$new_url变量了
    echo "</br>你提交了短别名: " . htmlspecialchars($txt_url);
    echo "<br>";
    echo "你提交了新网址: " . htmlspecialchars($new_url);
}

///＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝

//================================= 黑名单检查==================================================
require_once 'blacklist.php'; // 引入 blacklist.php 文件

$ne_url =htmlspecialchars($new_url);// 'https://www.baidu.com/'; // 示例 URL

$blacklisted_paths = getFilePaths();

// 使用 strpos() 检查 $ne_url 是否包含黑名单中的任何子串
foreach ($blacklisted_paths as $path) {
    if (strpos($ne_url, $path) !== false) {
        // 如果 $ne_url 包含黑名单中的子串，则输出错误并退出
        echo '<script type="text/javascript">alert("该网站存在黑名单中！拒绝跳转服务！！！");</script>';
    echo '<script type="text/javascript">window.history.back();</script>';
    exit; // 确保不再执行后续代码
    
    //echo "</br>ERRO: URL 进入黑名单";

    }
}

// 如果不包含任何黑名单中的子串，则继续执行后续代码
//echo "</br>YES: 没有进入黑名单.";


//================================= 创建目录==================================================
//$txt_url = 'abc';
// 目录路径
$directoryPath = __DIR__ . '/' . $txt_url;

// 检查目录是否存在，如果不存在则创建
if (!is_dir($directoryPath)) {
    mkdir($directoryPath, 0755, true);
}
else
 {
    // 如果目录存在，则输出 JavaScript 警告并返回上一页
    echo '<script type="text/javascript">alert("别名重复了，请重新输入！");</script>';
    echo '<script type="text/javascript">window.history.back();</script>';
    exit; // 确保不再执行后续代码
}

//================================= 创建跳转PHP==================================================
// PHP文件名称
$fileName = 'index.php';
// PHP文件路径
$filePath = $directoryPath . '/' . $fileName;

// 要重定向到的URL
///$new_url = 'http://example.com';//

// 生成PHP文件内容
$fileContent = "<?php\nheader('Location: " . $new_url . "');\nexit;\n?>";

// 写入PHP文件
file_put_contents($filePath, $fileContent);
//================================= 输出结果==================================================
// 输出成功消息或进行其他操作
echo "</br>";
echo "您可直接访问: bgo.cc/" . htmlspecialchars($txt_url);
echo "</br>或是直接访问：".htmlspecialchars($txt_url).".bgo.cc"; //如域名未使用泛解析请注释此行
//================================= 日志记录==================================================

// 获取客户端IP地址的函数
function getClientIP() {
    $keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR');
    foreach ($keys as $key) {
        if (array_key_exists($key, $_SERVER)) {
            if (filter_var($_SERVER[$key], FILTER_VALIDATE_IP)) {
                return $_SERVER[$key];
            }
        }
    }
    return 'UNKNOWN';
}
 
// 使用函数获取IP地址
$ip = getClientIP();
//echo "来访IP地址: " . $ip;

$logFile = 'log.php'; // 存放日志文件名，文件格式随意，以文本格式输出
$message ="IP: ". $ip."      ----Name: ".htmlspecialchars($txt_url).".bgo.cc"."      ----URL: " .htmlspecialchars($new_url)."</br>";  
// 将变量内容追加到日志文件
file_put_contents($logFile, date('Y-m-d H:i:s') . " - " . $message . PHP_EOL, FILE_APPEND);

//================================= 站点声明==================================================

echo "</br></br>";
echo "<h3>关于本站：本站仅提供学习交流所用，不定期清理缓存，如遇到无法访问可重新提交或联系本人锁定，请勿用于非法用途，发现立即清除</h3>";
?>
