captcha
=======

使用方法之一
------------

直接复制captcha.php到你的项目中，用img标签引用captcha.php，即可出现验证码

<code>
&lt;img src="./captcha.php" width="175" height="45" /&gt;
</code>

captcha.php会自动使用$_SESSION['captcha']来保存验证码，请自行写代码在收到请求时验证相应字段。

使用方法之二
------------

在你的项目中包含datauricaptcha.php。

getCaptcha()函数可以返回一个关联数组，其"question"字段是验证码图片的datauri，其"answer"字段是验证码的文本。你可以根据需要使用。