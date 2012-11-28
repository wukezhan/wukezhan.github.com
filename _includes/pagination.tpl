<div class="pagination">
	<ul>
		{% if paginator.page > 1 %}
		<li><a href="/">«</a></li>
		{% else %}
		<li class="disabled"><a>«</a></li>
		{% endif %}

		{% if paginator.page == 1 %}
		<li class="active"><a href="/">1</a></li>
		{% else %}
		<li><a href="/">1</a></li>
		{% endif %}
		{% for count in (2..paginator.total_pages) %}
		{% if count == paginator.page %}
		<li class="active"><a href="/page/{{count}}/">{{count}}</a></li>
		{% else %}
		<li><a href="/page/{{count}}/">{{count}}</a></li>
		{% endif %}
		{% endfor %}

		{% if paginator.page<paginator.total_pages %}
		<li><a href="/page/{{paginator.next_page}}/">»</a>&gt;</li>
		{% else %}
		<li class="disabled"><a>»</a></li>
		{% endif %}
		<li class="disabled"><a>(共{{ paginator.total_posts }}篇)</a></li>
	</ul>
</div>