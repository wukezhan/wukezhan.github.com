---
layout: post
title: 闭包的一个通俗解释及简单示例  
categories: [ code ]
tags: [ javascript, closure ]
published: false
---

今日帮同事调试一个bug，遇到了一个闭包相关的问题，此问题的解决方案恰好简约生动的体现了闭包的一些特性，想起之前所看相关资料，多是从理论、数学等比较抽象的角度来阐释闭包，乃记录此例，以期能对闭包之特性形成一生动鲜明之印象。

### 闭包是什么？

javascript的闭包是其强大语言特性的重要组成部分，但是其究竟是什么，却似乎不是一两句话所能解释清楚的。

通俗来讲，大致可以理解为：闭包就是一个被绑定了某些上下文环境的javascript函数。

在javascript中，环境上行文是一个无处不在的概念，普通函数的环境上行文只有在执行时才会真正被绑定，在此之前，此函数的任何的变量都是未知；但是闭包则不尽相同，闭包自产生之时起，其作用域内的某些变量即以完全确定，除了闭包函数本身或其产生子闭包之外，再无其他操作能够改变这些变量。

### 为什么需要用到闭包？

一个简单例程，目的很简单，就是输出每个元素对应的序号a：

{% highlight javascript linenos %}

    $(function(){
      var a=1;
      //code 1
      for(; a<4; a++){
        $('#z'+a).click(function(){
          alert(a);
        });
      }
    
      //code 2
      for(; a<7; a++){
        var c2 = (function(){
          var f = function(){alert(a)};
          return f;
        })();
        $('#z'+a).click(c2);
      }
    
      //code 3
      for(; a<10; a++){
        var c3 = (function(){
          var _a = a;
          var f = function(){alert(_a)};
          return f;
        })();
        $('#z'+a).click(c3);
      }
    });
    
{% endhighlight %}

通过分析代码，可以得知，代码片段1和片段2都无法得到预期的结果：

代码片段1的结果是：当点击#z1、#z2、#z3时，都会alert出10；

代码片段2的结果是：当点击#z4、#z5、#z6时，都会alert出10；

代码片段3的结果是：当点击#z7、#z8、#z9时，会分别alert出7、8、9；

演示见 [在线demo][1]

原因不难解释：由于以上元素均只是绑定了click事件为对应的函数，函数在绑定时并未执行，所以alert的参数a此时是未知；直到click事件触发时，函数才真正从其运行时上下文的作用域链中逐层向外寻找变量a的值。对于代码片段1、2，其a的定义显然是在最外层匿名函数处，而此a在3个循环执行完成后，值为10，故click触发时，alert出的数字为10，而不是预期中的序号。

代码3的click回调函数则与代码1、2有所不同，代码3的回调函数c3，其实质为绑定了运行时环境上下文的函数f，其alert参数_a在事件绑定之前即已确定，因其处于匿名函数的封闭的作用域下，故其值能确保不受更外层环境的影响，因此确保了代码的正确运行。

代码2、3中的回调函数c2、c3，其实质都是匿名函数返回的函数f，区别仅在于前一个f函数的环境上下文未绑定alert参数，后一个绑定了，而致运行结果天差地别，何其微妙！

可见，闭包之重要作用在于为一个函数预先制定一个封闭的上下文环境，并在此上下文环境的作用域预先定义好某些受保护的变量，以该上下文环境的封闭性确保在该函数执行之前，该上下文环境的作用域不会受到外层作用域链的干扰，这正是闭包之精髓所在！

### demo

<a class="jsbin-embed" href="http://jsbin.com/ipawoy/47/embed?live">JS Closure</a><script src="http://static.jsbin.com/js/embed.js"></script>

### 扩展资料

欲了解闭包，还需了解关于作用域及作用域链的相关知识，以下是几篇相关的比较好的文章：

*   [学习Javascript闭包（Closure）][2] by 阮一峰的网络日志 
*   [Javascript作用域原理][3] by laruence 
*   http://www.cnblogs.com/TomXu/archive/2012/01/31/2330252.html

 [1]: http://jsbin.com/ipawoy/45
 [2]: http://www.ruanyifeng.com/blog/2009/08/learning_javascript_closures.html
 [3]: http://www.laruence.com/2009/05/28/863.html
