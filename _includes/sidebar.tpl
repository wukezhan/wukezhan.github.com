

<!--[sidebar]-->
<div id="sidebar">
	<ul>
		<li>
			<a href="#">ARTICLES</a>
			<ul>
				{% for category in site.categories %}
				<li><a href="/{{ category[0] }}.html"> {{ category[0]  }}</a></li>
				{% endfor %}
			</ul>
		</li>
	</ul>
</div>
<!--[/sidebar]-->

