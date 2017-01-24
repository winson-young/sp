框架命名:
Standard And Performance
简称 SP

需要提前深入了解的原理或机制
1. MVC
2. 自动加载: PHP: 自动加载类;
3. 错误处理：http://php.net/manual/zh/book.errorfunc.php;
4. PHP标准库 (SPL)PHP: SPL - Manual;
5. 输出缓冲控制: PHP: 输出控制;
6. PHP 选项/信息：PHP:PHP 选项/信息;
7. 数据库抽象层：PHP: 数据库抽象层;
8. session拓展：PHP: Session 扩展;
9. 反射：http://php.net/manual/zh/book.reflection.php;
10. 类和对象：PHP: 类/对象;
11. 图像处理和 GD：PHP: GD - Manual;
12. 邮件相关的SMTP;
13. 文件系统：PHP: Filesystem;
14. 预定义变量：PHP: 预定义变量;
15. 字符串处理：PHP: 字符串 - Manual;
15. 正则表达式: http://php.net/manual/en/book.pcre.php;

框架需求：
实现自动加载类,实现路由访问,实现DMVC分层;

工作进度
1:实现自动加载类
2:实现路由访问
    通过系统参数SCRIPT_NAME和REQUEST_URI分离出参数