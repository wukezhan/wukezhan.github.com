<p><span class="split-line" style="color:red;">---EOF---</span></p>
{% if page.repost %}
<p>
	<span class="license" style="color:green;font-weight:bold;">本文系转载文章，原文：<a href="{{ page.repost }}" target="_blank">{{ page.repost }}</a>.</span>
</p>
{% else %}
<p>
	<span class="license" style="color:green;font-weight:bold;">本文系原创文章，链接：<a href="{{ site.url }}{{ page.url }}" target="_blank">{{ site.url }}{{ page.url }}</a>.</span>
</p>
<p>
	<span class="license" style="color:green;font-weight:bold;">本站原创文章皆遵循 <a href="http://creativecommons.org/licenses/by/3.0/" target="_blank">CC BY 3.0</a>协议发布，原创代码均基于 <a href="http://www.apache.org/licenses/LICENSE-2.0" target="_blank">Apache License v2.0</a> 协议开源。</span>
</p>
{% endif %}