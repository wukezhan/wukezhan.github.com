

<!--[sidebar]-->
<div id="sidebar">
	<ul>
		<li>
			<a href="/">CATEGORY</a>
			<ul>
				{% for category in site.categories %}
				<li><a href="/category/{{ category[0] }}.html"> {{ category[0] }}</a></li>
				{% endfor %}
			</ul>
		</li>
	</ul>
</div>
<!--[/sidebar]-->

