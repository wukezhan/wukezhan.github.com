

<!--[sidebar]-->
<div id="sidebar">
	<ul>
		<li>
			<a href="/category/">CATEGORY</a>
			<ul>
				{% for category in site.categories %}
				<li><a href="/category/{{ category[0] }}/"> {{ category[0] }}</a></li>
				{% endfor %}
			</ul>
		</li>
		</li>
			<a href="/tag/">TAG</a>
		</li>
	</ul>
</div>
<!--[/sidebar]-->

